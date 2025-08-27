<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AggregatorSetting;
use App\Services\Distribution\AggregatorService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AggregatorSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display aggregator settings
     */
    public function index(): View
    {
        $settings = AggregatorSetting::orderBy('provider')->orderBy('environment')->get();
        $availableProviders = AggregatorSetting::getAvailableProviders();
        
        return view('admin.distribution.aggregator-settings.index', compact('settings', 'availableProviders'));
    }

    /**
     * Show form for creating/editing aggregator settings
     */
    public function createOrEdit(Request $request): View
    {
        $setting = null;
        
        if ($request->has('id')) {
            $setting = AggregatorSetting::findOrFail($request->id);
        }

        $availableProviders = AggregatorSetting::getAvailableProviders();
        
        return view('admin.distribution.aggregator-settings.form', compact('setting', 'availableProviders'));
    }

    /**
     * Store or update aggregator settings
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'provider' => 'required|string|in:' . implode(',', array_keys(AggregatorSetting::getAvailableProviders())),
            'environment' => 'required|string|in:test,live',
            'secret_key' => 'required|string|min:10',
            'public_key' => 'nullable|string',
            'configuration' => 'nullable|array',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['provider', 'environment', 'secret_key', 'public_key', 'configuration']);
        $data['is_active'] = $request->has('is_active');

        if ($request->has('id') && $request->id) {
            // Update existing
            $setting = AggregatorSetting::findOrFail($request->id);
            $setting->update($data);
            $message = 'Aggregator settings updated successfully';
        } else {
            // Create new
            AggregatorSetting::create($data);
            $message = 'Aggregator settings created successfully';
        }

        return redirect()->route('admin.aggregator-settings.index')
                        ->with('success', $message);
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(AggregatorSetting $setting): RedirectResponse
    {
        $setting->update(['is_active' => !$setting->is_active]);
        
        $status = $setting->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
                        ->with('success', "Aggregator {$setting->provider_display_name} has been {$status}");
    }

    /**
     * Test connection to aggregator
     */
    public function testConnection(AggregatorSetting $setting, AggregatorService $aggregatorService): RedirectResponse
    {
        try {
            $result = $aggregatorService->testConnection($setting->provider);
            
            if ($result['success']) {
                return redirect()->back()
                                ->with('success', "Connection to {$setting->provider_display_name} successful!");
            } else {
                return redirect()->back()
                                ->with('error', "Connection failed: " . $result['error']);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', "Connection test failed: " . $e->getMessage());
        }
    }

    /**
     * Delete aggregator settings
     */
    public function destroy(AggregatorSetting $setting): RedirectResponse
    {
        $providerName = $setting->provider_display_name;
        $setting->delete();
        
        return redirect()->back()
                        ->with('success', "Aggregator settings for {$providerName} deleted successfully");
    }

    /**
     * Get aggregator statistics
     */
    public function statistics(AggregatorService $aggregatorService): View
    {
        $stats = $aggregatorService->getStatistics();
        
        return view('admin.distribution.aggregator-settings.statistics', compact('stats'));
    }

    /**
     * Send test release (for debugging)
     */
    public function sendTestRelease(Request $request, AggregatorService $aggregatorService): RedirectResponse
    {
        $request->validate([
            'provider' => 'required|string',
            'distribution_request_id' => 'required|integer|exists:distribution_requests,id'
        ]);

        try {
            $distributionRequest = \App\Models\DistributionRequest::findOrFail($request->distribution_request_id);
            
            $result = $aggregatorService->sendRelease($distributionRequest, $request->provider);
            
            if ($result['success']) {
                return redirect()->back()
                                ->with('success', 'Test release sent successfully! Release ID: ' . $result['aggregator_release_id']);
            } else {
                return redirect()->back()
                                ->with('error', 'Test release failed: ' . $result['error']);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Test release failed: ' . $e->getMessage());
        }
    }
}
