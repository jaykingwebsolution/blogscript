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
     * Get count of users who have paid for distribution.
     */
    private function getPaidUsersCount()
    {
        return User::where('distribution_paid', true)->count();
    }
}