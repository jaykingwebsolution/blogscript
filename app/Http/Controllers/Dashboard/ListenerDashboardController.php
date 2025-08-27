<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Music;
use App\Models\TrendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListenerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:listener']);
    }

    /**
     * Show listener dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Get greeting based on time of day
        $hour = now()->hour;
        if ($hour < 12) {
            $greeting = 'morning';
        } elseif ($hour < 17) {
            $greeting = 'afternoon';
        } else {
            $greeting = 'evening';
        }

        // Get user's playlists
        $playlists = $user->playlists()
            ->withCount('music')
            ->latest()
            ->take(6)
            ->get();

        // Get recently played tracks (simulate with latest music for now)
        $recentlyPlayed = Music::where('status', 'approved')
            ->with(['artists'])
            ->latest()
            ->take(5)
            ->get();

        // Get recommendations based on user's activity
        $recommendations = Music::where('status', 'approved')
            ->with(['artists'])
            ->inRandomOrder()
            ->take(5)
            ->get();

        // Get trending tracks
        $trendingTracks = Music::where('status', 'approved')
            ->with(['artists'])
            ->whereHas('trendingRequests', function($query) {
                $query->where('status', 'approved')
                      ->where('expires_at', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get listening statistics
        $stats = [
            'total_playlists' => $user->playlists()->count(),
            'public_playlists' => $user->playlists()->where('visibility', 'public')->count(),
            'total_songs' => $user->playlists()->withCount('music')->get()->sum('music_count'),
            'liked_songs_count' => $user->likedSongs()->count(),
            'following_count' => 0, // Will implement artist following later
            'hours_listened' => 0, // This would come from a listening history table
        ];

        return view('dashboard.listener.index', compact(
            'playlists', 
            'recentlyPlayed',
            'recommendations',
            'trendingTracks',
            'stats',
            'greeting'
        ));
    }

    /**
     * Show browse page
     */
    public function browse(Request $request)
    {
        $query = Music::where('status', 'approved')->with(['artists']);

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('artists', function($artistQuery) use ($search) {
                      $artistQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Apply genre filter
        if ($request->has('genre') && $request->genre) {
            $query->where('genre', $request->genre);
        }

        // Apply sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->withCount('likes')->orderBy('likes_count', 'desc');
                break;
            case 'trending':
                $query->whereHas('trendingRequests', function($q) {
                    $q->where('status', 'approved')
                      ->where('expires_at', '>', now());
                })->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }

        $music = $query->paginate(12);
        $genres = Music::select('genre')->distinct()->pluck('genre')->filter();

        return view('dashboard.listener.browse', compact('music', 'genres'));
    }

    /**
     * Show trending page
     */
    public function trending()
    {
        // Get trending tracks
        $weeklyTrending = Music::where('status', 'approved')
            ->with(['artists'])
            ->whereHas('trendingRequests', function($query) {
                $query->where('status', 'approved')
                      ->where('type', 'week')
                      ->where('expires_at', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $monthlyTrending = Music::where('status', 'approved')
            ->with(['artists'])
            ->whereHas('trendingRequests', function($query) {
                $query->where('status', 'approved')
                      ->where('type', 'month')
                      ->where('expires_at', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $allTimeTrending = Music::where('status', 'approved')
            ->with(['artists'])
            ->whereHas('trendingRequests', function($query) {
                $query->where('status', 'approved')
                      ->where('type', 'all-time')
                      ->where('expires_at', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.listener.trending', compact(
            'weeklyTrending', 
            'monthlyTrending', 
            'allTimeTrending'
        ));
    }

    /**
     * Search functionality
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return redirect()->route('dashboard.listener.browse');
        }

        $music = Music::where('status', 'approved')
            ->with(['artists'])
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhereHas('artists', function($artistQuery) use ($query) {
                      $artistQuery->where('name', 'LIKE', "%{$query}%");
                  });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('dashboard.listener.search', compact('music', 'query'));
    }

    /**
     * Show listening history
     */
    public function history()
    {
        // This would typically fetch from a listening history table
        $history = collect();

        return view('dashboard.listener.history', compact('history'));
    }
}
