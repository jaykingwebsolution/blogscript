<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use App\Models\DistributionPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionPricingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! Auth::check() || ! Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized access.');
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pricingPlans = DistributionPricing::getOrderedPlans();

        return view('admin.distribution_dashboard.pricing.index', compact('pricingPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.distribution_dashboard.pricing.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'custom_duration' => 'required_if:duration,custom|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
            'type' => 'required|string|in:standard,premium,ultimate',
            'is_active' => 'boolean',
        ]);

        $duration = $request->duration === 'custom' ? $request->custom_duration : $request->duration;

        DistributionPricing::create([
            'name' => $request->name,
            'duration' => $duration,
            'price' => $request->price,
            'description' => $request->description,
            'features' => $request->features,
            'type' => $request->type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.distribution.pricing.index')
            ->with('success', 'Distribution pricing plan created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DistributionPricing $distributionPricing)
    {
        return view('admin.distribution_dashboard.pricing.edit', compact('distributionPricing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DistributionPricing $distributionPricing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'custom_duration' => 'required_if:duration,custom|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
            'type' => 'required|string|in:standard,premium,ultimate',
            'is_active' => 'boolean',
        ]);

        $duration = $request->duration === 'custom' ? $request->custom_duration : $request->duration;

        $distributionPricing->update([
            'name' => $request->name,
            'duration' => $duration,
            'price' => $request->price,
            'description' => $request->description,
            'features' => $request->features,
            'type' => $request->type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.distribution.pricing.index')
            ->with('success', 'Distribution pricing plan updated successfully.');
    }

    /**
     * Generate a random distribution pricing plan for demo/testing purposes.
     */
    public function generateRandom()
    {
        $planTypes = [
            'standard' => [
                'name' => 'Musician',
                'features' => [
                    'Upload unlimited songs',
                    'Distribute to 150+ digital stores',
                    'Keep 85% of royalties',
                    'Basic analytics dashboard',
                    'Email support'
                ],
                'description' => 'Perfect for individual artists starting their distribution journey.',
                'price_range' => [5000, 15000]
            ],
            'premium' => [
                'name' => 'Musician Plus',
                'features' => [
                    'Everything in Musician',
                    'Keep 90% of royalties',
                    'Advanced analytics & insights',
                    'YouTube monetization',
                    'Priority support',
                    'Custom release dates'
                ],
                'description' => 'Ideal for serious artists looking to maximize their revenue and reach.',
                'price_range' => [15000, 30000]
            ],
            'ultimate' => [
                'name' => 'Ultimate',
                'features' => [
                    'Everything in Musician Plus',
                    'Keep 95% of royalties',
                    'Dedicated account manager',
                    'Playlist pitching service',
                    'Social media promotion tools',
                    'Advanced split payments',
                    '24/7 priority support'
                ],
                'description' => 'The complete solution for professional artists and labels.',
                'price_range' => [30000, 50000]
            ]
        ];

        $durations = ['6 months', '1 year', 'lifetime'];

        $randomType = array_rand($planTypes);
        $planConfig = $planTypes[$randomType];
        $randomDuration = $durations[array_rand($durations)];

        // Generate price within the plan's range
        $minPrice = $planConfig['price_range'][0];
        $maxPrice = $planConfig['price_range'][1];
        $price = rand($minPrice, $maxPrice);

        // Round to nearest 500 for more realistic pricing
        $price = round($price / 500) * 500;

        try {
            DistributionPricing::create([
                'name' => $planConfig['name'],
                'duration' => $randomDuration,
                'price' => $price,
                'description' => $planConfig['description'],
                'features' => $planConfig['features'],
                'type' => $randomType,
                'is_active' => true,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.distribution.pricing.create')
                ->with('error', 'Failed to create random distribution plan. Please try again. Error: ' . $e->getMessage());
        }

        return redirect()->route('admin.distribution.pricing.create')
            ->with('success', "Random distribution plan created successfully: {$planConfig['name']} ({$randomDuration}) - ₦".number_format($price, 2));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DistributionPricing $distributionPricing)
    {
        $distributionPricing->delete();

        return redirect()->route('admin.distribution.pricing.index')
            ->with('success', 'Distribution pricing plan deleted successfully.');
    }
}