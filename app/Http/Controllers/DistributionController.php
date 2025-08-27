<?php

namespace App\Http\Controllers;

use App\Models\DistributionRequest;
use App\Models\DistributionPricing;
use App\Models\DistributionPayout;
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
            // Enhanced metadata fields
            'isrc' => 'nullable|string|max:255',
            'upc' => 'nullable|string|max:255',
            'record_label' => 'nullable|string|max:255',
            'contributors' => 'nullable|array',
            'contributors.*.name' => 'nullable|string|max:255',
            'contributors.*.role' => 'nullable|string|max:255',
            'contributors.*.percentage' => 'nullable|numeric|min:0|max:100',
            'territory_type' => 'required|in:worldwide,selected',
            'territories' => 'required_if:territory_type,selected|array',
            'territories.*' => 'string|max:255',
            'explicit_content' => 'boolean',
            'lyrics' => 'nullable|string|max:10000',
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

        // Process territories
        $territories = $request->territory_type === 'worldwide' ? null : $request->territories;

        // Process contributors - filter out empty entries
        $contributors = [];
        if ($request->contributors) {
            foreach ($request->contributors as $contributor) {
                if (!empty($contributor['name'])) {
                    $contributors[] = [
                        'name' => $contributor['name'],
                        'role' => $contributor['role'] ?? '',
                        'percentage' => $contributor['percentage'] ?? 0,
                    ];
                }
            }
        }

        $distributionRequest = DistributionRequest::create([
            'user_id' => $user->id,
            'artist_name' => $request->artist_name,
            'song_title' => $request->song_title,
            'genre' => $request->genre,
            'release_date' => $request->release_date,
            'cover_image' => $coverImagePath,
            'audio_file' => $audioFilePath,
            'description' => $request->description,
            'status' => 'pending',
            // Enhanced metadata
            'isrc' => $request->isrc,
            'upc' => $request->upc,
            'record_label' => $request->record_label,
            'contributors' => empty($contributors) ? null : $contributors,
            'territories' => $territories,
            'explicit_content' => $request->has('explicit_content'),
            'lyrics' => $request->lyrics,
            'dsp_delivery_status' => 'pending',
        ]);

        return redirect()->route('distribution.my-submissions')
            ->with('success', 'Your music has been submitted for distribution review.');
    }

    /**
     * Show the distribution home page with pricing information.
     */
    public function index()
    {
        $user = auth()->user();
        $distributionPlans = DistributionPricing::getActivePlans();
        
        return view('distribution.index', compact('distributionPlans', 'user'));
    }

    /**
     * Show the pricing plans page.
     */
    public function pricing()
    {
        $distributionPlans = DistributionPricing::getActivePlans();
        
        return view('distribution.pricing', compact('distributionPlans'));
    }

    /**
     * Display the user's submissions.
     */
    public function mySubmissions()
    {
        $user = Auth::user();
        $submissions = $user->distributionRequests()
            ->with(['assets', 'earnings'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate totals
        $totalEarnings = $user->distributionEarnings()->where('status', 'confirmed')->sum('amount');
        $pendingEarnings = $user->distributionEarnings()->where('status', 'pending')->sum('amount');

        return view('distribution.my-submissions', compact('submissions', 'totalEarnings', 'pendingEarnings'));
    }

    /**
     * Show earnings page
     */
    public function earnings()
    {
        $user = Auth::user();
        $earnings = $user->distributionEarnings()
            ->with(['distributionRequest'])
            ->orderBy('period_start', 'desc')
            ->paginate(15);

        // Calculate stats
        $totalEarnings = $user->distributionEarnings()->where('status', 'confirmed')->sum('amount');
        $pendingEarnings = $user->distributionEarnings()->where('status', 'pending')->sum('amount');
        $thisMonthEarnings = $user->distributionEarnings()
            ->where('status', 'confirmed')
            ->whereMonth('period_start', now()->month)
            ->whereYear('period_start', now()->year)
            ->sum('amount');

        // Platform breakdown
        $platformEarnings = $user->distributionEarnings()
            ->where('status', 'confirmed')
            ->selectRaw('platform, SUM(amount) as total')
            ->groupBy('platform')
            ->pluck('total', 'platform');

        return view('distribution.earnings', compact(
            'earnings', 'totalEarnings', 'pendingEarnings', 'thisMonthEarnings', 'platformEarnings'
        ));
    }

    /**
     * Show payouts page
     */
    public function payouts()
    {
        $user = Auth::user();
        $payouts = $user->distributionPayouts()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate available balance
        $totalEarnings = $user->distributionEarnings()->where('status', 'confirmed')->sum('amount');
        $totalPayouts = $user->distributionPayouts()->where('status', 'completed')->sum('amount');
        $pendingPayouts = $user->distributionPayouts()->whereIn('status', ['pending', 'processing'])->sum('amount');
        $availableBalance = $totalEarnings - $totalPayouts - $pendingPayouts;

        return view('distribution.payouts', compact('payouts', 'totalEarnings', 'totalPayouts', 'pendingPayouts', 'availableBalance'));
    }

    /**
     * Request a payout
     */
    public function requestPayout(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'amount' => 'required|numeric|min:10', // Minimum payout amount
            'method' => 'required|in:bank_transfer,paypal,mobile_money',
            'payment_details' => 'required|array',
        ]);

        // Check available balance
        $totalEarnings = $user->distributionEarnings()->where('status', 'confirmed')->sum('amount');
        $totalPayouts = $user->distributionPayouts()->where('status', 'completed')->sum('amount');
        $pendingPayouts = $user->distributionPayouts()->whereIn('status', ['pending', 'processing'])->sum('amount');
        $availableBalance = $totalEarnings - $totalPayouts - $pendingPayouts;

        if ($request->amount > $availableBalance) {
            return back()->with('error', 'Requested amount exceeds available balance.');
        }

        DistributionPayout::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'method' => $request->method,
            'payment_details' => $request->payment_details,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return back()->with('success', 'Payout request submitted successfully. It will be processed within 3-5 business days.');
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
