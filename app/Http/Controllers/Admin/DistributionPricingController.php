<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistributionPricing;
use Illuminate\Support\Facades\Auth;

class DistributionPricingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdmin()) {
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
     * Remove the specified resource from storage.
     */
    public function destroy(DistributionPricing $distributionPricing)
    {
        $distributionPricing->delete();

        return redirect()->route('admin.distribution-pricing.index')
                        ->with('success', 'Distribution pricing plan deleted successfully.');
    }
}
