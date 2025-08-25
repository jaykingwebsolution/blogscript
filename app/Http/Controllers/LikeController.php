<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Request $request, Music $music)
    {
        $user = Auth::user();
        
        $isLiked = $user->hasLikedSong($music->id);
        
        if ($isLiked) {
            $user->unlikeSong($music->id);
            $action = 'unliked';
        } else {
            $user->likeSong($music->id);
            $action = 'liked';
        }
        
        // Get updated like count
        $likeCount = $music->likedBy()->count();
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'action' => $action,
                'liked' => !$isLiked,
                'like_count' => $likeCount
            ]);
        }
        
        return back()->with('success', $action === 'liked' ? 'Song added to your liked songs!' : 'Song removed from your liked songs!');
    }

    public function index()
    {
        $user = Auth::user();
        $likedSongs = $user->likedSongs()
            ->with(['artist', 'category'])
            ->orderBy('likes.created_at', 'desc')
            ->paginate(20);

        return view('music.liked-songs', compact('likedSongs'));
    }

    public function clear()
    {
        $user = Auth::user();
        $user->likedSongs()->detach();
        
        return back()->with('success', 'All liked songs have been removed.');
    }
}
