<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\User;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->role !== 'admin') {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of playlists.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Playlist::with(['user', 'music'])
                        ->withCount('music')
                        ->latest();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply visibility filter
        if ($request->filled('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        // Apply featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        // Apply creator filter
        if ($request->filled('creator')) {
            $query->where('user_id', $request->creator);
        }

        $playlists = $query->paginate(15)->withQueryString();
        $users = User::select('id', 'name')->orderBy('name')->get();
        
        return view('admin.playlists.index', compact('playlists', 'users'));
    }

    /**
     * Show the form for creating a new playlist.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();
        $music = Music::select('id', 'title', 'artist_name')->where('status', 'published')->orderBy('title')->get();
        
        return view('admin.playlists.create', compact('users', 'music'));
    }

    /**
     * Store a newly created playlist in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'user_id' => 'required|exists:users,id',
            'visibility' => 'required|in:public,private,unlisted',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'music_ids' => 'array',
            'music_ids.*' => 'exists:music,id',
            'is_featured' => 'boolean'
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('playlists', 'public');
        }

        // Generate unique slug
        $validated['slug'] = Str::slug($validated['title']);
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Playlist::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter++;
        }

        $playlist = Playlist::create($validated);

        // Attach music tracks if provided
        if (!empty($validated['music_ids'])) {
            $musicData = [];
            foreach ($validated['music_ids'] as $index => $musicId) {
                $musicData[$musicId] = ['order_in_playlist' => $index + 1];
            }
            $playlist->music()->attach($musicData);
        }

        return redirect()->route('admin.playlists.index')
                         ->with('success', 'Playlist created successfully.');
    }

    /**
     * Display the specified playlist.
     * 
     * @param  Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        $playlist->load(['user', 'music.creator']);
        
        return view('admin.playlists.show', compact('playlist'));
    }

    /**
     * Show the form for editing the specified playlist.
     * 
     * @param  Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        $playlist->load('music');
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();
        $availableMusic = Music::select('id', 'title', 'artist_name')
                              ->where('status', 'published')
                              ->orderBy('title')
                              ->get();
        $selectedMusicIds = $playlist->music->pluck('id')->toArray();
        
        return view('admin.playlists.edit', compact('playlist', 'users', 'availableMusic', 'selectedMusicIds'));
    }

    /**
     * Update the specified playlist in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'user_id' => 'required|exists:users,id',
            'visibility' => 'required|in:public,private,unlisted',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'music_ids' => 'array',
            'music_ids.*' => 'exists:music,id',
            'is_featured' => 'boolean'
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($playlist->cover_image) {
                Storage::disk('public')->delete($playlist->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('playlists', 'public');
        }

        // Update slug if title changed
        if ($validated['title'] !== $playlist->title) {
            $validated['slug'] = Str::slug($validated['title']);
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Playlist::where('slug', $validated['slug'])->where('id', '!=', $playlist->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        $playlist->update($validated);

        // Update music associations
        if (isset($validated['music_ids'])) {
            $musicData = [];
            foreach ($validated['music_ids'] as $index => $musicId) {
                $musicData[$musicId] = ['order_in_playlist' => $index + 1];
            }
            $playlist->music()->sync($musicData);
        } else {
            $playlist->music()->detach();
        }

        return redirect()->route('admin.playlists.index')
                         ->with('success', 'Playlist updated successfully.');
    }

    /**
     * Remove the specified playlist from storage.
     * 
     * @param  Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        // Delete cover image if exists
        if ($playlist->cover_image) {
            Storage::disk('public')->delete($playlist->cover_image);
        }

        // Detach all music relationships
        $playlist->music()->detach();
        
        // Delete the playlist
        $playlist->delete();

        return redirect()->route('admin.playlists.index')
                         ->with('success', 'Playlist deleted successfully.');
    }

    /**
     * Feature a playlist (make it appear in featured sections).
     * 
     * @param  Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function feature(Playlist $playlist)
    {
        $playlist->update(['is_featured' => true]);

        return redirect()->back()->with('success', 'Playlist featured successfully.');
    }

    /**
     * Unfeature a playlist.
     * 
     * @param  Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function unfeature(Playlist $playlist)
    {
        $playlist->update(['is_featured' => false]);

        return redirect()->back()->with('success', 'Playlist unfeatured successfully.');
    }

    /**
     * Moderate playlist content (approve/reject).
     * 
     * @param  Request  $request
     * @param  Playlist  $playlist
     * @param  string  $action
     * @return \Illuminate\Http\Response
     */
    public function moderate(Request $request, Playlist $playlist, $action)
    {
        if ($action === 'approve') {
            $playlist->update(['visibility' => 'public']);
            $message = 'approved';
        } else {
            $playlist->update(['visibility' => 'private']);
            $message = 'rejected';
        }

        return redirect()->back()->with('success', "Playlist {$message} successfully.");
    }

    /**
     * Bulk operations on selected playlists.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,feature,unfeature,make_public,make_private',
            'playlist_ids' => 'required|array',
            'playlist_ids.*' => 'exists:playlists,id'
        ]);

        $playlists = Playlist::whereIn('id', $request->playlist_ids);

        switch ($request->action) {
            case 'delete':
                foreach ($playlists->get() as $playlist) {
                    if ($playlist->cover_image) {
                        Storage::disk('public')->delete($playlist->cover_image);
                    }
                    $playlist->music()->detach();
                }
                $playlists->delete();
                $message = 'Playlists deleted successfully.';
                break;
            
            case 'feature':
                $playlists->update(['is_featured' => true]);
                $message = 'Playlists featured successfully.';
                break;
                
            case 'unfeature':
                $playlists->update(['is_featured' => false]);
                $message = 'Playlists unfeatured successfully.';
                break;
                
            case 'make_public':
                $playlists->update(['visibility' => 'public']);
                $message = 'Playlists made public successfully.';
                break;
                
            case 'make_private':
                $playlists->update(['visibility' => 'private']);
                $message = 'Playlists made private successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}