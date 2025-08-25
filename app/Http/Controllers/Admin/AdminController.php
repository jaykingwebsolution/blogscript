<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Music;
use App\Models\Artist;
use App\Models\Video;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized. Admin access required.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'total_music' => Music::count(),
            'total_artists' => Artist::count(),
            'total_videos' => Video::count(),
            'total_news' => News::count(),
            'pending_users' => User::pending()->count(),
            'total_users' => User::count(),
            'featured_music' => Music::featured()->count(),
            'trending_artists' => Artist::trending()->count(),
        ];

        $recentContent = [
            'music' => Music::latest()->take(5)->get(),
            'artists' => Artist::latest()->take(5)->get(),
            'videos' => Video::latest()->take(5)->get(),
            'news' => News::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats', 'recentContent'));
    }

    // Music Management
    public function musicIndex()
    {
        $music = Music::with('creator')->latest()->paginate(10);
        return view('admin.music.index', compact('music'));
    }

    public function musicCreate()
    {
        return view('admin.music.create');
    }

    public function musicStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:music,slug',
            'description' => 'nullable|string',
            'artist_name' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'audio_url' => 'nullable|url',
            'duration' => 'nullable|string|max:10',
            'genre' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published,archived'
        ]);

        $validated['created_by'] = Auth::id();

        Music::create($validated);

        return redirect()->route('admin.music.index')->with('success', 'Music added successfully!');
    }

    public function musicEdit(Music $music)
    {
        return view('admin.music.edit', compact('music'));
    }

    public function musicUpdate(Request $request, Music $music)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:music,slug,' . $music->id,
            'description' => 'nullable|string',
            'artist_name' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'audio_url' => 'nullable|url',
            'duration' => 'nullable|string|max:10',
            'genre' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published,archived'
        ]);

        $music->update($validated);

        return redirect()->route('admin.music.index')->with('success', 'Music updated successfully!');
    }

    public function musicDestroy(Music $music)
    {
        $music->delete();
        return redirect()->route('admin.music.index')->with('success', 'Music deleted successfully!');
    }

    // Artist Management
    public function artistIndex()
    {
        $artists = Artist::with('creator')->latest()->paginate(10);
        return view('admin.artists.index', compact('artists'));
    }

    public function artistCreate()
    {
        return view('admin.artists.create');
    }

    public function artistStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image_url' => 'nullable|url',
            'genre' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'is_trending' => 'boolean',
            'status' => 'required|in:draft,published,archived'
        ]);

        $validated['created_by'] = Auth::id();

        Artist::create($validated);

        return redirect()->route('admin.artists.index')->with('success', 'Artist added successfully!');
    }

    public function artistEdit(Artist $artist)
    {
        return view('admin.artists.edit', compact('artist'));
    }

    public function artistUpdate(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image_url' => 'nullable|url',
            'genre' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'is_trending' => 'boolean',
            'status' => 'required|in:draft,published,archived'
        ]);

        $artist->update($validated);

        return redirect()->route('admin.artists.index')->with('success', 'Artist updated successfully!');
    }

    public function artistDestroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->route('admin.artists.index')->with('success', 'Artist deleted successfully!');
    }

    // User Management & Approval
    public function userIndex()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function userApprove(User $user)
    {
        $user->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id()
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User approved successfully!');
    }

    public function userSuspend(User $user)
    {
        $user->update([
            'status' => 'suspended',
            'approved_at' => null,
            'approved_by' => null
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User suspended successfully!');
    }

    // Subscription Management
    public function subscriptionIndex()
    {
        $subscriptions = \App\Models\Subscription::with('user')->latest()->paginate(20);
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    // Verification Request Management
    public function verificationIndex()
    {
        $requests = \App\Models\VerificationRequest::with('user')->pending()->latest()->paginate(20);
        return view('admin.verification.index', compact('requests'));
    }

    public function verificationApprove(\App\Models\VerificationRequest $request)
    {
        $request->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now()
        ]);

        // Update user verification status
        $request->user->update([
            'verification_status' => 'verified'
        ]);

        return back()->with('success', 'Verification request approved successfully!');
    }

    public function verificationReject(\App\Models\VerificationRequest $request, Request $httpRequest)
    {
        $httpRequest->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $request->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $httpRequest->admin_notes
        ]);

        return back()->with('success', 'Verification request rejected.');
    }

    // Trending Request Management
    public function trendingIndex()
    {
        $requests = \App\Models\TrendingRequest::with('user')->pending()->latest()->paginate(20);
        return view('admin.trending.index', compact('requests'));
    }

    public function trendingApprove(\App\Models\TrendingRequest $request)
    {
        // Calculate expiry date based on type
        $expiresAt = match($request->type) {
            'week' => now()->addWeek(),
            'month' => now()->addMonth(),
            'all-time' => now()->addYear(), // All-time trending for 1 year
        };

        $request->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'expires_at' => $expiresAt
        ]);

        return back()->with('success', 'Trending request approved successfully!');
    }

    public function trendingReject(\App\Models\TrendingRequest $request, Request $httpRequest)
    {
        $httpRequest->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $request->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $httpRequest->admin_notes
        ]);

        return back()->with('success', 'Trending request rejected.');
    }

    // Music approval (for artist uploads)
    public function musicApprove(Music $music)
    {
        $music->update(['status' => 'published']);
        return back()->with('success', 'Music approved and published!');
    }

    public function musicReject(Music $music)
    {
        $music->update(['status' => 'rejected']);
        return back()->with('success', 'Music rejected.');
    }
}