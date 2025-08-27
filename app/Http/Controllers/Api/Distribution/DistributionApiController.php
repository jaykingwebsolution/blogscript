<?php

namespace App\Http\Controllers\Api\Distribution;

use App\Http\Controllers\Controller;
use App\Models\DistributionRequest;
use App\Models\DistributionEarning;
use App\Models\DistributionPayout;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DistributionApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('throttle:60,1'); // 60 requests per minute
    }

    /**
     * Get release status
     */
    public function getReleaseStatus(Request $request, int $id): JsonResponse
    {
        $distributionRequest = DistributionRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$distributionRequest) {
            return response()->json([
                'error' => 'Distribution request not found'
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $distributionRequest->id,
                'song_title' => $distributionRequest->song_title,
                'artist_name' => $distributionRequest->artist_name,
                'status' => $distributionRequest->status,
                'dsp_delivery_status' => $distributionRequest->dsp_delivery_status,
                'dsp_delivery_status_color' => $distributionRequest->dsp_delivery_status_color,
                'aggregator_provider' => $distributionRequest->aggregator_provider,
                'release_date' => $distributionRequest->release_date,
                'submitted_at' => $distributionRequest->created_at,
                'delivered_at' => $distributionRequest->delivered_at,
                'total_earnings' => $distributionRequest->total_earnings,
                'formatted_total_earnings' => $distributionRequest->formatted_total_earnings,
                'platforms_status' => $this->getPlatformsStatus($distributionRequest),
                'analytics' => $this->getReleaseAnalytics($distributionRequest)
            ]
        ]);
    }

    /**
     * Get user's earnings
     */
    public function getEarnings(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        $query = DistributionEarning::where('user_id', $user->id)
            ->with('distributionRequest:id,song_title,artist_name');

        // Filter by date range if provided
        if ($request->has('from_date')) {
            $query->whereDate('period_start', '>=', $request->from_date);
        }
        
        if ($request->has('to_date')) {
            $query->whereDate('period_end', '<=', $request->to_date);
        }

        // Filter by platform if provided
        if ($request->has('platform')) {
            $query->where('platform', $request->platform);
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $earnings = $query->orderBy('period_end', 'desc')
            ->paginate($request->get('per_page', 15));

        // Calculate summary statistics
        $totalEarnings = DistributionEarning::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('amount');

        $totalStreams = DistributionEarning::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('streams');

        $platformBreakdown = DistributionEarning::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->selectRaw('platform, SUM(amount) as total_amount, SUM(streams) as total_streams')
            ->groupBy('platform')
            ->get();

        return response()->json([
            'data' => $earnings->items(),
            'pagination' => [
                'current_page' => $earnings->currentPage(),
                'per_page' => $earnings->perPage(),
                'total' => $earnings->total(),
                'last_page' => $earnings->lastPage()
            ],
            'summary' => [
                'total_earnings' => $totalEarnings,
                'total_streams' => $totalStreams,
                'platform_breakdown' => $platformBreakdown,
                'currency' => 'USD'
            ]
        ]);
    }

    /**
     * Get user's payouts
     */
    public function getPayouts(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        $query = DistributionPayout::where('user_id', $user->id);

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $payouts = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        // Calculate summary statistics
        $totalPaid = DistributionPayout::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $pendingAmount = DistributionPayout::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->sum('amount');

        // Available balance (total earnings - total paid - pending payouts)
        $totalEarnings = DistributionEarning::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('amount');

        $availableBalance = $totalEarnings - $totalPaid - $pendingAmount;

        return response()->json([
            'data' => $payouts->items(),
            'pagination' => [
                'current_page' => $payouts->currentPage(),
                'per_page' => $payouts->perPage(),
                'total' => $payouts->total(),
                'last_page' => $payouts->lastPage()
            ],
            'summary' => [
                'total_earnings' => $totalEarnings,
                'total_paid' => $totalPaid,
                'pending_amount' => $pendingAmount,
                'available_balance' => max(0, $availableBalance),
                'currency' => 'USD',
                'minimum_payout' => 50.00 // Minimum payout threshold
            ]
        ]);
    }

    /**
     * Request a payout
     */
    public function requestPayout(Request $request): JsonResponse
    {
        $user = Auth::user();

        $request->validate([
            'amount' => 'required|numeric|min:50|max:10000',
            'method' => 'required|in:bank_transfer,paypal,mobile_money',
            'payment_details' => 'required|array'
        ]);

        // Calculate available balance
        $totalEarnings = DistributionEarning::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('amount');

        $totalPaid = DistributionPayout::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $pendingAmount = DistributionPayout::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->sum('amount');

        $availableBalance = $totalEarnings - $totalPaid - $pendingAmount;

        if ($request->amount > $availableBalance) {
            return response()->json([
                'error' => 'Insufficient balance',
                'available_balance' => $availableBalance
            ], 400);
        }

        // Create payout request
        $payout = DistributionPayout::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'method' => $request->method,
            'payment_details' => $request->payment_details,
            'status' => 'pending',
            'requested_at' => now()
        ]);

        return response()->json([
            'message' => 'Payout request created successfully',
            'data' => [
                'id' => $payout->id,
                'amount' => $payout->amount,
                'method' => $payout->method,
                'status' => $payout->status,
                'requested_at' => $payout->requested_at
            ]
        ], 201);
    }

    /**
     * Get platforms delivery status for a release
     */
    protected function getPlatformsStatus(DistributionRequest $request): array
    {
        // This would typically come from the aggregator's detailed status
        $aggregatorResponse = $request->aggregator_response ?? [];
        $dspStatuses = $aggregatorResponse['dsp_statuses'] ?? [];

        // Default platforms with estimated status
        $defaultPlatforms = [
            'Spotify' => $request->dsp_delivery_status,
            'Apple Music' => $request->dsp_delivery_status,
            'YouTube Music' => $request->dsp_delivery_status,
            'Amazon Music' => $request->dsp_delivery_status,
            'Boomplay' => $request->dsp_delivery_status,
            'Audiomack' => $request->dsp_delivery_status
        ];

        // Override with actual statuses if available
        return array_merge($defaultPlatforms, $dspStatuses);
    }

    /**
     * Get basic analytics for a release
     */
    protected function getReleaseAnalytics(DistributionRequest $request): array
    {
        $earnings = $request->earnings()->where('status', 'confirmed');

        return [
            'total_streams' => $earnings->sum('streams'),
            'total_downloads' => $earnings->sum('downloads'),
            'total_earnings' => $earnings->sum('amount'),
            'top_platform' => $earnings->selectRaw('platform, SUM(streams) as total_streams')
                ->groupBy('platform')
                ->orderBy('total_streams', 'desc')
                ->first()?->platform ?? 'N/A',
            'top_territory' => $earnings->selectRaw('territory, SUM(streams) as total_streams')
                ->whereNotNull('territory')
                ->groupBy('territory')
                ->orderBy('total_streams', 'desc')
                ->first()?->territory ?? 'N/A'
        ];
    }
}