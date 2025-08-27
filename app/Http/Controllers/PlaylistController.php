<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::with(['user', 'music'])
            ->public()
            ->latest()
            ->paginate(12);

        $featuredPlaylists = Playlist::with(['user', 'music'])
            ->featured()
            ->public()
            ->latest()
            ->take(6)
            ->get();

        return view('playlists.index', compact('playlists', 'featuredPlaylists'));
    }

    /**
     * Display the user's playlists
     */
    public function myPlaylists()
    {
        $playlists = Auth::user()
            ->playlists()
            ->with('music')
            ->latest()
            ->paginate(12);

        return view('playlists.my-playlists', compact('playlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'visibility' => 'required|in:public,private,unlisted',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'visibility']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('playlists', 'public');
        }

        $playlist = Playlist::create($data);

        return redirect()->route('playlists.show', $playlist)
            ->with('success', 'Playlist created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        if (!$playlist->canBeViewedBy(Auth::user())) {
            abort(404);
        }

        $playlist->load(['user', 'music.artist']);

        return view('playlists.show', compact('playlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        return view('playlists.edit', compact('playlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'visibility' => 'required|in:public,private,unlisted',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'visibility']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('playlists', 'public');
        }

        // Update slug if title changed
        if ($playlist->title !== $data['title']) {
            $slug = Str::slug($data['title']);
            $originalSlug = $slug;
            $counter = 1;
            while (Playlist::where('slug', $slug)->where('id', '!=', $playlist->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $data['slug'] = $slug;
        }

        $playlist->update($data);

        return redirect()->route('playlists.show', $playlist)
            ->with('success', 'Playlist updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        $playlist->delete();

        return redirect()->route('playlists.my-playlists')
            ->with('success', 'Playlist deleted successfully!');
    }

    /**
     * Add music to playlist
     */
    public function addMusic(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'music_id' => 'required|exists:music,id',
        ]);

        $music = Music::find($request->music_id);

        if ($playlist->music()->where('music_id', $music->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Music is already in this playlist'
            ]);
        }

        $order = $playlist->music()->count() + 1;
        $playlist->music()->attach($music->id, ['order_in_playlist' => $order]);

        return response()->json([
            'success' => true,
            'message' => 'Music added to playlist successfully!'
        ]);
    }

    /**
     * Remove music from playlist
     */
    public function removeMusic(Request $request, Playlist $playlist, Music $music)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        $playlist->music()->detach($music->id);

        // Reorder remaining music
        $playlist->music()->each(function ($music, $index) use ($playlist) {
            $playlist->music()->updateExistingPivot($music->id, ['order_in_playlist' => $index + 1]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Music removed from playlist successfully!'
        ]);
    }

    /**
     * Update music order in playlist
     */
    public function updateMusicOrder(Request $request, Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'music_ids' => 'required|array',
            'music_ids.*' => 'exists:music,id',
        ]);

        foreach ($request->music_ids as $order => $musicId) {
            $playlist->music()->updateExistingPivot($musicId, ['order_in_playlist' => $order + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Playlist order updated successfully!'
        ]);
    }

    /**
     * Create a new playlist via AJAX and optionally add music to it
     */
    public function createPlaylistAjax(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'visibility' => 'required|in:public,private,unlisted',
            'music_id' => 'nullable|exists:music,id',
        ]);

        $data = $request->only(['title', 'description', 'visibility']);
        $data['user_id'] = Auth::id();

        $playlist = Playlist::create($data);

        // Add music to playlist if provided
        if ($request->music_id) {
            $music = Music::find($request->music_id);
            if ($music) {
                $playlist->music()->attach($music->id, ['order_in_playlist' => 1]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Playlist created successfully!',
            'playlist' => [
                'id' => $playlist->id,
                'title' => $playlist->title,
                'music_count' => $playlist->music()->count(),
                'cover_image_url' => $playlist->cover_image_url,
            ]
        ]);
    }

    /**
     * Get user's playlists for AJAX requests
     */
    public function getUserPlaylists()
    {
        $playlists = Auth::user()->playlists()->latest()->get()->map(function ($playlist) {
            return [
                'id' => $playlist->id,
                'title' => $playlist->title,
                'music_count' => $playlist->music_count,
                'cover_image_url' => $playlist->cover_image_url,
            ];
        });

        return response()->json([
            'success' => true,
            'playlists' => $playlists
        ]);
    }
}
