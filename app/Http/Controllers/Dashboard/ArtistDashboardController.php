<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DistributionRequest;
use App\Models\TrendingRequest;
use App\Models\Music;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtistDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show artist dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user is an artist
        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        // Get artist statistics
        $stats = [
            'total_songs' => $user->createdMusic()->count(),
            'approved_songs' => $user->createdMusic()->where('status', 'approved')->count(),
            'distribution_requests' => $user->distributionRequests()->count(),
            'pending_distribution' => $user->distributionRequests()->where('status', 'pending')->count(),
            'trending_requests' => $user->trendingRequests()->count(),
            'active_trending' => $user->trendingRequests()->where('status', 'approved')->where('expires_at', '>', now())->count(),
            'total_plays' => 0, // This would come from analytics table
            'total_likes' => $user->createdMusic()->withCount('likes')->get()->sum('likes_count'),
        ];

        // Get recent activity
        $recentDistributions = $user->distributionRequests()
            ->with(['user'])
            ->latest()
            ->take(5)
            ->get();

        $recentTrending = $user->trendingRequests()
            ->with(['user'])
            ->latest()
            ->take(3)
            ->get();

        $recentMusic = $user->createdMusic()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.artist.index', compact(
            'stats', 
            'recentDistributions', 
            'recentTrending',
            'recentMusic'
        ));
    }

    /**
     * Show submit song for distribution form
     */
    public function showSubmitSong()
    {
        $user = Auth::user();

        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        return view('dashboard.artist.submit-song');
    }

    /**
     * Submit song for distribution
     */
    public function submitSong(Request $request)
    {
        $request->validate([
            'artist_name' => 'required|string|max:255',
            'song_title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'release_date' => 'required|date|after_or_equal:today',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'audio_file' => 'required|file|mimes:mp3,wav|max:51200',
            'description' => 'nullable|string|max:1000'
        ]);

        // Handle file uploads
        $coverPath = null;
        $audioPath = null;

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('distribution/covers', 'public');
        }

        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('distribution/audio', 'public');
        }

        // Create distribution request
        DistributionRequest::create([
            'user_id' => Auth::id(),
            'artist_name' => $request->artist_name,
            'song_title' => $request->song_title,
            'genre' => $request->genre,
            'release_date' => $request->release_date,
            'cover_image' => $coverPath,
            'audio_file' => $audioPath,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard.artist')
            ->with('success', 'Song submitted for distribution successfully! We will review your submission.');
    }

    /**
     * Show submit trending song form
     */
    public function showSubmitTrendingSong()
    {
        $user = Auth::user();

        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        return view('dashboard.artist.submit-trending-song');
    }

    /**
     * Submit trending song request
     */
    public function submitTrendingSong(Request $request)
    {
        $request->validate([
            'type' => 'required|in:week,month,all-time',
            'message' => 'required|string|max:1000'
        ]);

        // Check if user already has an active trending request
        $existingRequest = Auth::user()->trendingRequests()
            ->where('status', 'pending')
            ->orWhere(function($query) {
                $query->where('status', 'approved')
                      ->where('expires_at', '>', now());
            })
            ->first();

        if ($existingRequest) {
            return back()->withErrors([
                'message' => 'You already have an active trending request. Please wait for it to be processed.'
            ]);
        }

        TrendingRequest::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'message' => $request->message,
            'status' => 'pending',
            'expires_at' => now()->addDays(30) // Default 30 days
        ]);

        return redirect()->route('dashboard.artist')
            ->with('success', 'Trending song request submitted successfully!');
    }

    /**
     * Show submit trending mixtape form
     */
    public function showSubmitTrendingMixtape()
    {
        $user = Auth::user();

        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        return view('dashboard.artist.submit-trending-mixtape');
    }

    /**
     * Submit trending mixtape request
     */
    public function submitTrendingMixtape(Request $request)
    {
        $request->validate([
            'mixtape_title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'tracks_count' => 'required|integer|min:3|max:50',
            'release_date' => 'required|date'
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('trending/mixtapes', 'public');
        }

        // Create trending request for mixtape (using existing TrendingRequest model)
        TrendingRequest::create([
            'user_id' => Auth::id(),
            'type' => 'mixtape',
            'message' => json_encode([
                'mixtape_title' => $request->mixtape_title,
                'description' => $request->description,
                'cover_image' => $coverPath,
                'tracks_count' => $request->tracks_count,
                'release_date' => $request->release_date
            ]),
            'status' => 'pending',
            'expires_at' => now()->addDays(30)
        ]);

        return redirect()->route('dashboard.artist')
            ->with('success', 'Trending mixtape request submitted successfully!');
    }

    /**
     * Show analytics page
     */
    public function analytics()
    {
        $user = Auth::user();

        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        // Analytics data (would typically come from analytics tables)
        $analytics = [
            'plays_this_month' => 0,
            'plays_total' => 0,
            'likes_this_month' => 0,
            'likes_total' => $user->createdMusic()->withCount('likes')->get()->sum('likes_count'),
            'top_tracks' => $user->createdMusic()->withCount('likes')->orderBy('likes_count', 'desc')->take(5)->get(),
            'recent_activity' => collect(), // Would come from activity log
        ];

        return view('dashboard.artist.analytics', compact('analytics'));
    }

    /**
     * Show upload music form
     */
    public function showUploadMusic()
    {
        $user = Auth::user();

        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        return view('dashboard.artist.upload-music');
    }

    /**
     * Handle music upload
     */
    public function uploadMusic(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'genre' => 'required|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'audio_file' => 'required|file|mimes:mp3,wav|max:51200',
            'release_date' => 'nullable|date',
        ]);

        // Handle file uploads
        $coverPath = null;
        $audioPath = null;

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('music/covers', 'public');
        }

        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('music/audio', 'public');
        }

        // Create music entry
        Music::create([
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $request->genre,
            'cover_image' => $coverPath,
            'audio_file' => $audioPath,
            'release_date' => $request->release_date ?? now(),
            'status' => 'pending',
            'created_by' => Auth::id(),
            'artist_name' => Auth::user()->artist_stage_name ?? Auth::user()->name,
        ]);

        return redirect()->route('dashboard.artist')
            ->with('success', 'Music uploaded successfully! It will be reviewed by our team.');
    }

    /**
     * Show my songs page
     */
    public function mySongs()
    {
        $user = Auth::user();

        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        $songs = $user->createdMusic()
            ->withCount('likes')
            ->latest()
            ->paginate(12);

        return view('dashboard.artist.my-songs', compact('songs'));
    }

    /**
     * Show edit song form
     */
    public function editSong(Music $music)
    {
        $user = Auth::user();

        if (!$user->isArtist() || $music->created_by !== $user->id) {
            abort(403);
        }

        return view('dashboard.artist.edit-song', compact('music'));
    }

    /**
     * Update song
     */
    public function updateSong(Request $request, Music $music)
    {
        $user = Auth::user();

        if (!$user->isArtist() || $music->created_by !== $user->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'genre' => 'required|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'release_date' => 'nullable|date',
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $request->genre,
            'release_date' => $request->release_date,
        ];

        // Handle cover image update
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($music->cover_image) {
                Storage::disk('public')->delete($music->cover_image);
            }
            $updateData['cover_image'] = $request->file('cover_image')->store('music/covers', 'public');
        }

        $music->update($updateData);

        return redirect()->route('dashboard.artist.my-songs')
            ->with('success', 'Song updated successfully!');
    }

    /**
     * Delete song
     */
    public function deleteSong(Music $music)
    {
        $user = Auth::user();

        if (!$user->isArtist() || $music->created_by !== $user->id) {
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

        return redirect()->route('dashboard.artist.my-songs')
            ->with('success', 'Song deleted successfully!');
    }

    /**
     * Show earnings page
     */
    public function earnings()
    {
        $user = Auth::user();

        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        // Earnings data (would typically come from earnings tables)
        $earnings = [
            'total_earnings' => 0,
            'this_month' => 0,
            'pending_payments' => 0,
            'recent_transactions' => collect(),
        ];

        return view('dashboard.artist.earnings', compact('earnings'));
    }

    /**
     * Show distribution history
     */
    public function distributionHistory()
    {
        $user = Auth::user();

        if (!$user->isArtist()) {
            return redirect()->route('dashboard');
        }

        $distributions = $user->distributionRequests()
            ->latest()
            ->paginate(10);

        return view('dashboard.artist.distribution-history', compact('distributions'));
    }
}
