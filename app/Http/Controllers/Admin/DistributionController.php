<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of distribution requests.
     */
    public function index(Request $request)
    {
        $query = DistributionRequest::with('user');

        // Filter by status if provided
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'declined'])) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('artist_name', 'LIKE', "%{$search}%")
                  ->orWhere('song_title', 'LIKE', "%{$search}%")
                  ->orWhere('genre', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get counts for each status
        $statusCounts = [
            'all' => DistributionRequest::count(),
            'pending' => DistributionRequest::pending()->count(),
            'approved' => DistributionRequest::approved()->count(),
            'declined' => DistributionRequest::declined()->count(),
        ];

        return view('admin.distribution.index', compact('requests', 'statusCounts'));
    }

    /**
     * Display the specified distribution request.
     */
    public function show(DistributionRequest $distributionRequest)
    {
        $distributionRequest->load('user');
        return view('admin.distribution.show', compact('distributionRequest'));
    }

    /**
     * Approve the specified distribution request.
     */
    public function approve(Request $request, DistributionRequest $distributionRequest)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $distributionRequest->update([
            'status' => 'approved',
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.distribution.show', $distributionRequest)
            ->with('success', 'Distribution request has been approved.');
    }

    /**
     * Decline the specified distribution request.
     */
    public function decline(Request $request, DistributionRequest $distributionRequest)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $distributionRequest->update([
            'status' => 'declined',
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.distribution.show', $distributionRequest)
            ->with('success', 'Distribution request has been declined.');
    }

    /**
     * Update the status of a distribution request via AJAX.
     */
    public function updateStatus(Request $request, DistributionRequest $distributionRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,declined',
            'notes' => 'nullable|string|max:1000',
        ]);

        $distributionRequest->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $distributionRequest->status,
            'status_color' => $distributionRequest->status_color,
        ]);
    }

    /**
     * Remove the specified distribution request.
     */
    public function destroy(DistributionRequest $distributionRequest)
    {
        // Delete associated files if they exist
        if ($distributionRequest->cover_image) {
            \Storage::disk('public')->delete($distributionRequest->cover_image);
        }
        
        if ($distributionRequest->audio_file) {
            \Storage::disk('public')->delete($distributionRequest->audio_file);
        }

        $distributionRequest->delete();

        return redirect()->route('admin.distribution.index')
            ->with('success', 'Distribution request has been deleted.');
    }
}
