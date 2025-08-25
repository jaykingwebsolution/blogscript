<?php

namespace App\Http\Controllers;

use App\Models\DistributionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->isArtist() && !$user->isRecordLabel()) {
                abort(403, 'Access denied. Only artists and record labels can submit music for distribution.');
            }
            return $next($request);
        });
    }

    /**
     * Show the distribution submission form.
     */
    public function create()
    {
        $user = auth()->user();
        
        // Check if user has distribution access (has paid)
        if (!$user->hasDistributionAccess()) {
            return redirect()->route('payment.distribution')
                           ->with('info', 'You need to pay the distribution fee to submit music for distribution.');
        }
        
        $genres = DistributionRequest::getGenres();
        return view('distribution.create', compact('genres'));
    }

    /**
     * Store a newly created distribution request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if user has distribution access (has paid)
        if (!$user->hasDistributionAccess()) {
            return redirect()->route('payment.distribution')
                           ->with('error', 'You need to pay the distribution fee to submit music for distribution.');
        }
        
        $request->validate([
            'artist_name' => 'required|string|max:255',
            'song_title' => 'required|string|max:255',
            'genre' => 'required|string|in:' . implode(',', array_keys(DistributionRequest::getGenres())),
            'release_date' => 'required|date|after_or_equal:today',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
            'audio_file' => 'required|mimes:mp3,wav,m4a,aac|max:51200', // 50MB
            'description' => 'nullable|string|max:1000',
        ]);
        
        // Handle file uploads
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('distribution/covers', 'public');
        }

        $audioFilePath = null;
        if ($request->hasFile('audio_file')) {
            $audioFilePath = $request->file('audio_file')->store('distribution/audio', 'public');
        }

        DistributionRequest::create([
            'user_id' => $user->id,
            'artist_name' => $request->artist_name,
            'song_title' => $request->song_title,
            'genre' => $request->genre,
            'release_date' => $request->release_date,
            'cover_image' => $coverImagePath,
            'audio_file' => $audioFilePath,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('distribution.my-submissions')
            ->with('success', 'Your music has been submitted for distribution review.');
    }

    /**
     * Display the user's submissions.
     */
    public function mySubmissions()
    {
        $user = Auth::user();
        $submissions = $user->distributionRequests()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('distribution.my-submissions', compact('submissions'));
    }

    /**
     * Show the specified distribution request.
     */
    public function show(DistributionRequest $distributionRequest)
    {
        $user = Auth::user();
        
        // Ensure the user can only view their own submissions
        if ($distributionRequest->user_id !== $user->id) {
            abort(403, 'Access denied.');
        }

        return view('distribution.show', compact('distributionRequest'));
    }
}
