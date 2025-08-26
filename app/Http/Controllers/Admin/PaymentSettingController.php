<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class PaymentSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $paymentSettings = [
            'paystack_public_key' => SiteSetting::get('paystack_public_key', 'pk_test_demo_key_replace_with_yours'),
            'paystack_secret_key' => SiteSetting::get('paystack_secret_key', 'sk_test_demo_key_replace_with_yours'),
            'paystack_merchant_email' => SiteSetting::get('paystack_merchant_email', 'admin@blogscript.com'),
            'payment_environment' => SiteSetting::get('payment_environment', 'test'), // test or live
        ];

        return view('admin.payment-settings.index', compact('paymentSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'paystack_public_key' => 'required|string|min:10',
            'paystack_secret_key' => 'required|string|min:10',
            'paystack_merchant_email' => 'required|email',
            'payment_environment' => 'required|in:test,live',
        ]);

        // Update payment settings
        SiteSetting::set('paystack_public_key', $request->paystack_public_key);
        SiteSetting::set('paystack_secret_key', $request->paystack_secret_key);
        SiteSetting::set('paystack_merchant_email', $request->paystack_merchant_email);
        SiteSetting::set('payment_environment', $request->payment_environment);

        // Update .env file for runtime configuration
        $this->updateEnvFile([
            'PAYSTACK_PUBLIC_KEY' => $request->paystack_public_key,
            'PAYSTACK_SECRET_KEY' => $request->paystack_secret_key,
        ]);

        return redirect()->back()->with('success', 'Payment settings updated successfully! Changes will take effect on next request.');
    }

    public function testConnection()
    {
        $publicKey = SiteSetting::get('paystack_public_key');
        $secretKey = SiteSetting::get('paystack_secret_key');

        if (!$publicKey || !$secretKey) {
            return response()->json([
                'success' => false,
                'message' => 'Paystack keys not configured'
            ]);
        }

        try {
            // Test the API keys by making a simple request
            $response = \Illuminate\Support\Facades\Http::withToken($secretKey)
                ->get('https://api.paystack.co/bank');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Paystack connection successful!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Paystack credentials'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ]);
        }
    }

    private function updateEnvFile($data)
    {
        $envFile = base_path('.env');
        
        if (file_exists($envFile)) {
            $contents = file_get_contents($envFile);
            
            foreach ($data as $key => $value) {
                $pattern = "/^{$key}=.*/m";
                $replacement = "{$key}={$value}";
                
                if (preg_match($pattern, $contents)) {
                    $contents = preg_replace($pattern, $replacement, $contents);
                } else {
                    $contents .= "\n{$replacement}";
                }
            }
            
            file_put_contents($envFile, $contents);
        }
    }
}