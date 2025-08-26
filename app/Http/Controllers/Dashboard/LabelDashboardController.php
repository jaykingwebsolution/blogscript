<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DistributionRequest;
use App\Models\Music;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LabelDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show record label dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user is a record label
        if (!$user->isRecordLabel()) {
            return redirect()->route('dashboard');
        }

        // Get record label statistics
        $stats = [
            'total_artists' => $user->createdArtists()->count(),
            'total_songs' => $user->createdMusic()->count(),
            'approved_songs' => $user->createdMusic()->where('status', 'approved')->count(),
            'distribution_requests' => $user->distributionRequests()->count(),
            'pending_distribution' => $user->distributionRequests()->where('status', 'pending')->count(),
            'approved_distribution' => $user->distributionRequests()->where('status', 'approved')->count()
        ];

        // Get recent activity
        $recentDistributions = $user->distributionRequests()
            ->with(['user'])
            ->latest()
            ->take(5)
            ->get();

        $recentMusic = $user->createdMusic()
            ->with(['artists'])
            ->latest()
            ->take(5)
            ->get();

        $recentArtists = $user->createdArtists()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.record-label.index', compact(
            'stats', 
            'recentDistributions', 
            'recentMusic',
            'recentArtists'
        ));
    }

    /**
     * Show submit song form
     */
    public function showSubmitSong()
    {
        $user = Auth::user();

        if (!$user->isRecordLabel()) {
            return redirect()->route('dashboard');
        }

        // Get artists managed by this record label
        $artists = $user->createdArtists()->get();

        return view('dashboard.record-label.submit-song', compact('artists'));
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
            'description' => 'nullable|string|max:1000',
            'artist_id' => 'nullable|exists:artists,id'
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

        return redirect()->route('dashboard.record-label')
            ->with('success', 'Song submitted for distribution successfully! We will review your submission.');
    }

    /**
     * Show create artist form
     */
    public function showCreateArtist()
    {
        $user = Auth::user();

        if (!$user->isRecordLabel()) {
            return redirect()->route('dashboard');
        }

        return view('dashboard.record-label.create-artist');
    }

    /**
     * Create new artist
     */
    public function createArtist(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'genre' => 'required|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url'
        ]);

        $profilePicture = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture')->store('artists/profiles', 'public');
        }

        Artist::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'bio' => $request->bio,
            'genre' => $request->genre,
            'profile_picture' => $profilePicture,
            'social_links' => $request->social_links ?? [],
            'created_by' => Auth::id(),
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard.record-label')
            ->with('success', 'Artist created successfully! Pending admin approval.');
    }
}
