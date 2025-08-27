<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.distribution-pricing.index', compact('pricingPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.distribution-pricing.create');
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
        ]);

        $duration = $request->duration === 'custom' ? $request->custom_duration : $request->duration;

        DistributionPricing::create([
            'name' => $request->name,
            'duration' => $duration,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.distribution-pricing.index')
            ->with('success', 'Distribution pricing plan created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DistributionPricing $distributionPricing)
    {
        return view('admin.distribution-pricing.edit', compact('distributionPricing'));
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
        ]);

        $duration = $request->duration === 'custom' ? $request->custom_duration : $request->duration;

        $distributionPricing->update([
            'name' => $request->name,
            'duration' => $duration,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.distribution-pricing.index')
            ->with('success', 'Distribution pricing plan updated successfully.');
    }

    /**
     * Generate a random distribution pricing plan for demo/testing purposes.
     */
    public function generateRandom()
    {
        $planNames = [
            'Basic Distribution Package',
            'Premium Music Distribution',
            'Pro Artist Package',
            'Standard Distribution Plan',
            'Elite Music Distribution',
            'Starter Distribution Package',
            'Advanced Artist Plan',
            'Complete Distribution Suite',
            'Professional Music Package',
            'Ultimate Distribution Plan',
        ];

        $durations = ['6 months', '1 year', 'lifetime'];

        // Generate realistic random price between 5,000 and 50,000 NGN
        $minPrice = 5000;
        $maxPrice = 50000;
        $price = rand($minPrice, $maxPrice);

        // Round to nearest 500 for more realistic pricing
        $price = round($price / 500) * 500;

        $randomName = $availableNames[array_rand($availableNames)];
        $randomDuration = $durations[array_rand($durations)];

        DistributionPricing::create([
            'name' => $randomName,
            'duration' => $randomDuration,
            'price' => $price,
        ]);

        return redirect()->route('admin.distribution-pricing.create')
            ->with('success', "Random distribution plan created successfully: {$randomName} ({$randomDuration}) - ₦".number_format($price, 2));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DistributionPricing $distributionPricing)
    {
        $distributionPricing->delete();

        return redirect()->route('admin.distribution-pricing.index')
            ->with('success', 'Distribution pricing plan deleted successfully.');
    }
}
