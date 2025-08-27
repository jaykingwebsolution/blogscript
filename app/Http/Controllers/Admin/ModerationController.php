<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Music;
use App\Models\Artist;
use App\Models\News;
use App\Models\User;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModerationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->role !== 'admin') {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    /**
     * Display the content moderation dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stats = [
            'pending_music' => Music::where('status', 'pending')->count(),
            'pending_artists' => User::where('role', 'artist')->where('status', 'pending')->count(),
            'pending_posts' => News::where('status', 'draft')->count(),
            'pending_media' => Media::where('status', 'pending')->count(),
            'total_flagged' => 0, // This can be extended when reporting system is added
        ];

        // Recent moderation activities (using existing data)
        $recentMusic = Music::where('status', 'pending')
                           ->with('creator')
                           ->latest()
                           ->take(5)
                           ->get();

        $recentArtists = User::where('role', 'artist')
                            ->where('status', 'pending')
                            ->latest()
                            ->take(5)
                            ->get();

        $recentPosts = News::where('status', 'draft')
                          ->with('user')
                          ->latest()
                          ->take(5)
                          ->get();

        return view('admin.moderation.index', compact('stats', 'recentMusic', 'recentArtists', 'recentPosts'));
    }

    /**
     * Display pending music tracks for moderation.
     * 
     * @return \Illuminate\Http\Response
     */
    public function music(Request $request)
    {
        $query = Music::with('creator')->where('status', 'pending');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist_name', 'like', "%{$search}%")
                  ->orWhereHas('creator', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $music = $query->latest()->paginate(20);
        
        return view('admin.moderation.music', compact('music'));
    }

    /**
     * Display pending artists for moderation.
     * 
     * @return \Illuminate\Http\Response
     */
    public function artists(Request $request)
    {
        $query = User::where('role', 'artist')->where('status', 'pending');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('artist_stage_name', 'like', "%{$search}%");
            });
        }

        $artists = $query->latest()->paginate(20);
        
        return view('admin.moderation.artists', compact('artists'));
    }

    /**
     * Display pending posts/news for moderation.
     * 
     * @return \Illuminate\Http\Response
     */
    public function posts(Request $request)
    {
        $query = News::with('user')->where('status', 'draft');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $posts = $query->latest()->paginate(20);
        
        return view('admin.moderation.posts', compact('posts'));
    }

    /**
     * Display pending comments for moderation.
     * 
     * @return \Illuminate\Http\Response
     */
    public function comments()
    {
        // For now, return empty view since comments system isn't implemented
        // This can be extended when comment system is added
        return view('admin.moderation.comments');
    }

    /**
     * Display reported content requiring review.
     * 
     * @return \Illuminate\Http\Response
     */
    public function reports()
    {
        // For now, return empty view since reporting system isn't implemented
        // This can be extended when reporting system is added
        return view('admin.moderation.reports');
    }

    /**
     * Approve content item.
     * 
     * @param  string  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($type, $id)
    {
        switch ($type) {
            case 'music':
                $item = Music::findOrFail($id);
                $item->update(['status' => 'published']);
                $message = 'Music track approved and published successfully.';
                break;
                
            case 'artist':
                $item = User::where('role', 'artist')->findOrFail($id);
                $item->update(['status' => 'approved', 'approved_at' => now(), 'approved_by' => Auth::id()]);
                $message = 'Artist profile approved successfully.';
                break;
                
            case 'post':
                $item = News::findOrFail($id);
                $item->update(['status' => 'published']);
                $message = 'Post approved and published successfully.';
                break;
                
            default:
                return redirect()->back()->with('error', 'Invalid content type.');
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Reject content item with reason.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, $type, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        switch ($type) {
            case 'music':
                $item = Music::findOrFail($id);
                $item->update(['status' => 'rejected']);
                $message = 'Music track rejected.';
                break;
                
            case 'artist':
                $item = User::where('role', 'artist')->findOrFail($id);
                $item->update(['status' => 'rejected']);
                $message = 'Artist profile rejected.';
                break;
                
            case 'post':
                $item = News::findOrFail($id);
                $item->update(['status' => 'rejected']);
                $message = 'Post rejected.';
                break;
                
            default:
                return redirect()->back()->with('error', 'Invalid content type.');
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Flag content as inappropriate.
     * 
     * @param  string  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function flag($type, $id)
    {
        switch ($type) {
            case 'music':
                $item = Music::findOrFail($id);
                $item->update(['status' => 'flagged']);
                break;
                
            case 'artist':
                $item = User::where('role', 'artist')->findOrFail($id);
                $item->update(['status' => 'suspended']);
                break;
                
            case 'post':
                $item = News::findOrFail($id);
                $item->update(['status' => 'flagged']);
                break;
                
            default:
                return redirect()->back()->with('error', 'Invalid content type.');
        }

        return redirect()->back()->with('success', ucfirst($type) . ' flagged for review.');
    }

    /**
     * Bulk moderation actions.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,flag',
            'type' => 'required|in:music,artist,post',
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'reason' => 'required_if:action,reject|string|max:500'
        ]);

        $count = 0;
        
        switch ($request->type) {
            case 'music':
                $items = Music::whereIn('id', $request->ids);
                break;
            case 'artist':
                $items = User::where('role', 'artist')->whereIn('id', $request->ids);
                break;
            case 'post':
                $items = News::whereIn('id', $request->ids);
                break;
        }

        switch ($request->action) {
            case 'approve':
                if ($request->type === 'music') {
                    $count = $items->update(['status' => 'published']);
                } elseif ($request->type === 'artist') {
                    $count = $items->update(['status' => 'approved', 'approved_at' => now(), 'approved_by' => Auth::id()]);
                } else {
                    $count = $items->update(['status' => 'published']);
                }
                $message = "{$count} items approved successfully.";
                break;
                
            case 'reject':
                $count = $items->update(['status' => 'rejected']);
                $message = "{$count} items rejected successfully.";
                break;
                
            case 'flag':
                if ($request->type === 'artist') {
                    $count = $items->update(['status' => 'suspended']);
                } else {
                    $count = $items->update(['status' => 'flagged']);
                }
                $message = "{$count} items flagged successfully.";
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Display moderation settings and rules.
     * 
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        // For now, return a basic settings view
        // This can be extended with actual settings when needed
        return view('admin.moderation.settings');
    }

    /**
     * Update moderation settings.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        // This can be implemented when moderation settings are needed
        return redirect()->route('admin.moderation.settings')
                         ->with('success', 'Moderation settings updated successfully.');
    }

    /**
     * Display moderation activity log.
     * 
     * @return \Illuminate\Http\Response
     */
    public function logs()
    {
        // For now, return a basic logs view
        // This can be extended with actual activity logging when needed
        return view('admin.moderation.logs');
    }
}