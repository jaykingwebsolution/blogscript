<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VerificationRequest;
use App\Models\TrendingRequest;

class ArtistRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function verificationIndex()
    {
        $user = Auth::user();
        $requests = $user->verificationRequests()->latest()->get();
        
        return view('dashboard.verification', compact('requests'));
    }

    public function verificationStore(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Check if user has been active for 30 days
        $activeFor30Days = $user->created_at->diffInDays(now()) >= 30;
        
        if (!$activeFor30Days) {
            return back()->with('error', 'You must be active for at least 30 days before applying for verification.');
        }

        // Check if there's already a pending request
        $pendingRequest = $user->verificationRequests()->where('status', 'pending')->first();
        
        if ($pendingRequest) {
            return back()->with('error', 'You already have a pending verification request.');
        }

        VerificationRequest::create([
            'user_id' => $user->id,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Verification request submitted successfully!');
    }

    public function trendingIndex()
    {
        $user = Auth::user();
        $requests = $user->trendingRequests()->latest()->get();
        
        return view('dashboard.trending', compact('requests'));
    }

    public function trendingStore(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'type' => 'required|in:week,month,all-time',
            'message' => 'required|string|max:1000'
        ]);

        // Check if user is verified (optional requirement)
        if (!$user->isVerified() && $request->type === 'all-time') {
            return back()->with('error', 'You must be verified to apply for all-time trending status.');
        }

        // Check if there's already a pending request of the same type
        $pendingRequest = $user->trendingRequests()
            ->where('status', 'pending')
            ->where('type', $request->type)
            ->first();
        
        if ($pendingRequest) {
            return back()->with('error', 'You already have a pending trending request of this type.');
        }

        // Check if there's an active trending request of the same type
        $activeRequest = $user->trendingRequests()
            ->where('status', 'approved')
            ->where('type', $request->type)
            ->where('expires_at', '>', now())
            ->first();

        if ($activeRequest) {
            return back()->with('error', 'You already have an active trending status of this type.');
        }

        TrendingRequest::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Trending request submitted successfully!');
    }
}