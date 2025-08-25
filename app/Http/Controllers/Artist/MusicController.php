<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Music;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isArtist() && !Auth::user()->isRecordLabel()) {
                abort(403, 'Only artists and record labels can access this area.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::user();
        $music = Music::where('created_by', $user->id)
                     ->with(['category', 'tags'])
                     ->latest()
                     ->paginate(10);

        return view('artist.music.index', compact('music'));
    }

    public function create()
    {
        $categories = Category::active()->byType('music')->get();
        $tags = Tag::active()->get();

        return view('artist.music.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'genre' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_file' => 'required|file|mimes:mp3,wav,aac,ogg|max:20480', // 20MB max
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|string|max:10'
        ]);

        $data = $request->only([
            'title', 'artist_name', 'description', 'genre', 'category_id', 'release_date', 'duration'
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('music/covers', 'public');
            $data['cover_image'] = $coverPath;
        }

        // Handle audio file upload
        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('music/audio', 'public');
            $data['audio_file'] = $audioPath;
        }

        $data['created_by'] = $user->id;
        $data['status'] = 'pending'; // Require admin approval for new uploads

        $music = Music::create($data);

        // Attach tags if provided
        if ($request->filled('tags')) {
            $music->tags()->attach($request->tags);
        }

        return redirect()->route('artist.music.index')
                        ->with('success', 'Music uploaded successfully! It will be reviewed by admin.');
    }

    public function show(Music $music)
    {
        // Ensure the artist can only view their own music
        if ($music->created_by !== Auth::id()) {
            abort(403);
        }

        return view('artist.music.show', compact('music'));
    }

    public function edit(Music $music)
    {
        // Ensure the artist can only edit their own music
        if ($music->created_by !== Auth::id()) {
            abort(403);
        }

        $categories = Category::active()->byType('music')->get();
        $tags = Tag::active()->get();

        return view('artist.music.edit', compact('music', 'categories', 'tags'));
    }

    public function update(Request $request, Music $music)
    {
        // Ensure the artist can only update their own music
        if ($music->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'genre' => 'nullable|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_file' => 'nullable|file|mimes:mp3,wav,aac,ogg|max:20480',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|string|max:10'
        ]);

        $data = $request->only([
            'title', 'artist_name', 'description', 'genre', 'category_id', 'release_date', 'duration'
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($music->cover_image) {
                Storage::disk('public')->delete($music->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('music/covers', 'public');
            $data['cover_image'] = $coverPath;
        }

        // Handle audio file upload
        if ($request->hasFile('audio_file')) {
            // Delete old audio file
            if ($music->audio_file) {
                Storage::disk('public')->delete($music->audio_file);
            }
            $audioPath = $request->file('audio_file')->store('music/audio', 'public');
            $data['audio_file'] = $audioPath;
        }

        // If content was changed, set status back to pending for review
        if ($request->hasFile('cover_image') || $request->hasFile('audio_file') || 
            $music->title !== $request->title || $music->description !== $request->description) {
            $data['status'] = 'pending';
        }

        $music->update($data);

        // Sync tags if provided
        if ($request->has('tags')) {
            $music->tags()->sync($request->tags ?? []);
        }

        return redirect()->route('artist.music.index')
                        ->with('success', 'Music updated successfully!');
    }

    public function destroy(Music $music)
    {
        // Ensure the artist can only delete their own music
        if ($music->created_by !== Auth::id()) {
            abort(403);
        }

        // Delete associated files
        if ($music->cover_image) {
            Storage::disk('public')->delete($music->cover_image);
        }
        if ($music->audio_file) {
            Storage::disk('public')->delete($music->audio_file);
        }

        $music->delete();

        return redirect()->route('artist.music.index')
                        ->with('success', 'Music deleted successfully!');
    }
}