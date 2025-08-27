<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use App\Models\DistributionRequest;
use App\Models\DistributionPricing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionDashboardController extends Controller
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
     * Display the main distribution dashboard.
     */
    public function index(Request $request)
    {
        // Get distribution statistics
        $stats = [
            'total_requests' => DistributionRequest::count(),
            'pending_requests' => DistributionRequest::where('status', 'pending')->count(),
            'approved_requests' => DistributionRequest::where('status', 'approved')->count(),
            'declined_requests' => DistributionRequest::where('status', 'declined')->count(),
            'total_pricing_plans' => DistributionPricing::count(),
            'paid_users_count' => $this->getPaidUsersCount(),
        ];

        // Get recent distribution requests from users who have paid
        $recentRequests = DistributionRequest::with('user')
            ->whereHas('user', function ($query) {
                $query->where('distribution_paid', true);
            })
            ->latest()
            ->take(10)
            ->get();

        // Get pricing plans
        $pricingPlans = DistributionPricing::getOrderedPlans();

        return view('admin.distribution_dashboard.index', compact('stats', 'recentRequests', 'pricingPlans'));
    }

    /**
     * Display the distribution requests index page.
     */
    public function requests(Request $request)
    {
        $query = DistributionRequest::with('user')
            // Only show requests from users who have paid for distribution
            ->whereHas('user', function ($userQuery) {
                $userQuery->where('distribution_paid', true);
            });

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
                               ->orWhere('email', 'LIKE', "%{$search}%")
                               ->where('distribution_paid', true);
                  });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get counts for each status (only for paid users) with a single query
        $baseQuery = DistributionRequest::whereHas('user', function ($q) {
            $q->where('distribution_paid', true);
        });
        $statusCountsRaw = $baseQuery
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        $statusCounts = [
            'all' => $baseQuery->count(),
            'pending' => isset($statusCountsRaw['pending']) ? $statusCountsRaw['pending'] : 0,
            'approved' => isset($statusCountsRaw['approved']) ? $statusCountsRaw['approved'] : 0,
            'declined' => isset($statusCountsRaw['declined']) ? $statusCountsRaw['declined'] : 0,
        ];

        return view('admin.distribution_dashboard.requests.index', compact('requests', 'statusCounts'));
    }

    /**
     * Get count of users who have paid for distribution.
     */
    private function getPaidUsersCount()
    {
        return User::where('distribution_paid', true)->count();
    }
}