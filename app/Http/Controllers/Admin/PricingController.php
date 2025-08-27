<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PricingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $pricingPlans = PricingPlan::orderBy('created_at', 'desc')->get();
        return view('admin.pricing.index', compact('pricingPlans'));
    }

    public function create()
    {
        return view('admin.pricing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'currency' => 'required|string|size:3',
            'type' => 'required|in:one_time,recurring',
            'interval' => 'nullable|required_if:type,recurring|in:monthly,yearly',
            'features' => 'nullable|string|max:5000',
            'is_active' => 'boolean'
        ]);

        $slug = Str::slug($request->name);
        $counter = 1;
        $originalSlug = $slug;
        
        while (PricingPlan::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $features = [];
        if ($request->features) {
            $features = array_filter(explode("\n", $request->features));
            $features = array_map('trim', $features);
        }

        PricingPlan::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => strtoupper($request->currency),
            'type' => $request->type,
            'interval' => $request->interval,
            'features' => $features,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.pricing.index')
                        ->with('success', 'Pricing plan created successfully!');
    }

    public function edit(PricingPlan $pricingPlan)
    {
        return view('admin.pricing.edit', compact('pricingPlan'));
    }

    public function update(Request $request, PricingPlan $pricingPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'currency' => 'required|string|size:3',
            'type' => 'required|in:one_time,recurring',
            'interval' => 'nullable|required_if:type,recurring|in:monthly,yearly',
            'features' => 'nullable|string|max:5000',
            'is_active' => 'boolean'
        ]);

        $features = [];
        if ($request->features) {
            $features = array_filter(explode("\n", $request->features));
            $features = array_map('trim', $features);
        }

        $pricingPlan->update([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => strtoupper($request->currency),
            'type' => $request->type,
            'interval' => $request->interval,
            'features' => $features,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.pricing.index')
                        ->with('success', 'Pricing plan updated successfully!');
    }

    public function destroy(PricingPlan $pricingPlan)
    {
        // Don't allow deletion of distribution fee
        if ($pricingPlan->slug === 'distribution-fee') {
            return back()->with('error', 'Cannot delete the distribution fee plan.');
        }

        $pricingPlan->delete();

        return redirect()->route('admin.pricing.index')
                        ->with('success', 'Pricing plan deleted successfully!');
    }

    public function toggleStatus(PricingPlan $pricingPlan)
    {
        $pricingPlan->update([
            'is_active' => !$pricingPlan->is_active
        ]);

        $status = $pricingPlan->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Pricing plan {$status} successfully!");
    }
}
