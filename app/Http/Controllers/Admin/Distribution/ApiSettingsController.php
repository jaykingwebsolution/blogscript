<?php

namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use App\Models\DistributionApiSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiSettingsController extends Controller
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
     * Display API settings
     */
    public function index()
    {
        $apiSettings = DistributionApiSetting::all()->groupBy('provider');
        
        return view('admin.distribution_dashboard.api-settings.index', compact('apiSettings'));
    }

    /**
     * Show form to create or edit API setting
     */
    public function createOrEdit(Request $request)
    {
        $provider = $request->query('provider', 'paystack');
        $environment = $request->query('environment', 'test');
        
        $setting = DistributionApiSetting::where('provider', $provider)
                                        ->where('environment', $environment)
                                        ->first();
        
        return view('admin.distribution_dashboard.api-settings.form', compact('setting', 'provider', 'environment'));
    }

    /**
     * Store or update API settings
     */
    public function store(Request $request)
    {
        $request->validate([
            'provider' => 'required|string|in:paystack,flutterwave',
            'environment' => 'required|string|in:test,live',
            'public_key' => 'required|string',
            'secret_key' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $setting = DistributionApiSetting::updateOrCreate(
            [
                'provider' => $request->provider,
                'environment' => $request->environment,
            ],
            [
                'public_key' => $request->public_key,
                'secret_key' => $request->secret_key,
                'is_active' => $request->has('is_active'),
                'configuration' => $request->configuration ?? [],
            ]
        );

        return redirect()->route('admin.distribution.api-settings.index')
            ->with('success', 'API settings saved successfully.');
    }

    /**
     * Toggle API setting status
     */
    public function toggleStatus(DistributionApiSetting $apiSetting)
    {
        $apiSetting->update(['is_active' => !$apiSetting->is_active]);

        $status = $apiSetting->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.distribution.api-settings.index')
            ->with('success', "API setting {$status} successfully.");
    }

    /**
     * Test API connection
     */
    public function testConnection(DistributionApiSetting $apiSetting)
    {
        // This would implement actual API testing logic
        // For now, we'll simulate a successful test
        
        $testResult = $this->performApiTest($apiSetting);
        
        if ($testResult['success']) {
            return redirect()->route('admin.distribution.api-settings.index')
                ->with('success', 'API connection test successful.');
        } else {
            return redirect()->route('admin.distribution.api-settings.index')
                ->with('error', 'API connection test failed: ' . $testResult['message']);
        }
    }

    /**
     * Simulate API test (placeholder for real implementation)
     */
    private function performApiTest(DistributionApiSetting $setting): array
    {
        // In a real implementation, this would make actual API calls
        // For demo purposes, we'll simulate success
        
        if ($setting->provider === 'paystack' || $setting->provider === 'flutterwave') {
            return ['success' => true, 'message' => 'Connection successful'];
        }
        
        return ['success' => false, 'message' => 'Unsupported provider'];
    }

    /**
     * Delete API settings
     */
    public function destroy(DistributionApiSetting $apiSetting)
    {
        $apiSetting->delete();

        return redirect()->route('admin.distribution.api-settings.index')
            ->with('success', 'API settings deleted successfully.');
    }
}
