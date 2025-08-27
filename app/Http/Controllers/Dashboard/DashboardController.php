<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Music;
use App\Models\Playlist;

class DashboardController extends Controller
{
    /**
     * Display user's library (playlists, liked songs, uploaded music)
     */
    public function library()
    {
        $user = Auth::user();
        
        $playlists = $user->playlists()->with('tracks')->latest()->get();
        $likedSongs = $user->likedSongs()->with(['user', 'artist'])->latest()->get();
        
        // If user is artist/record label, show their uploaded music
        $uploadedMusic = collect();
        if ($user->isArtist() || $user->isRecordLabel()) {
            $uploadedMusic = Music::where('created_by', $user->id)
                ->with(['user', 'artist'])
                ->latest()
                ->get();
        }
        
        return view('dashboard.library', compact('playlists', 'likedSongs', 'uploadedMusic'));
    }
    
    /**
     * Display user's liked songs
     */
    public function likedSongs()
    {
        $user = Auth::user();
        
        $likedSongs = $user->likedSongs()
            ->with(['artist', 'category'])
            ->latest('likes.created_at')
            ->paginate(50);
            
        return view('music.liked-songs', compact('likedSongs'));
    }
    
    /**
     * Toggle like/unlike for a song
     */
    public function toggleLike(Request $request)
    {
        $user = Auth::user();
        $musicId = $request->input('music_id');
        
        $music = Music::findOrFail($musicId);
        
        $isLiked = $user->likedSongs()->where('music_id', $musicId)->exists();
        
        if ($isLiked) {
            $user->likedSongs()->detach($musicId);
            $message = 'Removed from liked songs';
            $action = 'unliked';
        } else {
            $user->likedSongs()->attach($musicId);
            $message = 'Added to liked songs';
            $action = 'liked';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'likes_count' => $music->likes()->count()
        ]);
    }
}