<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->isAdmin()) {
                abort(403, 'Access denied. Admin privileges required.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $plans = Plan::orderBy('sort_order')->orderBy('price')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'duration_days' => 'required|integer|min:1',
            'type' => 'required|in:free,artist,record_label,premium',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $validator->validated();
        $data['features'] = $data['features'] ?? [];
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->has('is_active');

        Plan::create($data);

        return redirect()->route('admin.plans.index')
                       ->with('success', 'Plan created successfully!');
    }

    public function show(Plan $plan)
    {
        return view('admin.plans.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'duration_days' => 'required|integer|min:1',
            'type' => 'required|in:free,artist,record_label,premium',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $validator->validated();
        $data['features'] = $data['features'] ?? [];
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->has('is_active');

        $plan->update($data);

        return redirect()->route('admin.plans.index')
                       ->with('success', 'Plan updated successfully!');
    }

    public function destroy(Plan $plan)
    {
        // Check if plan has active subscriptions
        if ($plan->subscriptions()->where('status', 'active')->exists()) {
            return redirect()->back()
                           ->with('error', 'Cannot delete plan with active subscriptions.');
        }

        $plan->delete();

        return redirect()->route('admin.plans.index')
                       ->with('success', 'Plan deleted successfully!');
    }
}
