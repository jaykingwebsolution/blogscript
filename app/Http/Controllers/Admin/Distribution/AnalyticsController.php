<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show distribution analytics
     */
    public function index()
    {
        // Placeholder analytics data - in a real app this would query the database
        $analytics = [
            'monthly_submissions' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [45, 52, 38, 67, 71, 83]
            ],
            'platform_distribution' => [
                'Spotify' => 35,
                'Apple Music' => 28,
                'YouTube Music' => 18,
                'Amazon Music' => 12,
                'Others' => 7
            ],
            'revenue_stats' => [
                'total_revenue' => 15420.50,
                'monthly_growth' => 12.5,
                'active_artists' => 247
            ]
        ];

        return view('admin.distribution_dashboard.analytics.index', compact('analytics'));
    }
}