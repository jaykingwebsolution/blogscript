<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListenerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show listener dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user is a listener
        if (!$user->isListener()) {
            return redirect()->route('dashboard');
        }

        // Get user's playlists
        $playlists = $user->playlists()
            ->withCount('music')
            ->latest()
            ->take(6)
            ->get();

        // Get recent activity (liked songs, playlist updates, etc.)
        // This would typically come from an activity log table
        $recentActivity = collect([
            [
                'type' => 'playlist_created',
                'title' => 'Created new playlist',
                'description' => 'My Favorites',
                'time' => now()->subHours(2),
                'icon' => 'music'
            ],
            [
                'type' => 'song_liked',
                'title' => 'Liked a song',
                'description' => 'Amazing Afrobeats Hit',
                'time' => now()->subDay(),
                'icon' => 'heart'
            ]
        ]);

        // Get listening statistics
        $stats = [
            'total_playlists' => $user->playlists()->count(),
            'public_playlists' => $user->playlists()->where('visibility', 'public')->count(),
            'total_songs' => $user->playlists()->withCount('music')->get()->sum('music_count'),
            'hours_listened' => 0, // This would come from a listening history table
        ];

        return view('dashboard.listener.index', compact('playlists', 'recentActivity', 'stats'));
    }

    /**
     * Show listening history
     */
    public function listeningHistory()
    {
        // This would typically fetch from a listening history table
        $history = collect();

        return view('dashboard.listener.history', compact('history'));
    }

    /**
     * Show liked songs
     */
    public function likedSongs()
    {
        // This would typically fetch from a likes table
        $likedSongs = collect();

        return view('dashboard.listener.liked-songs', compact('likedSongs'));
    }
}
