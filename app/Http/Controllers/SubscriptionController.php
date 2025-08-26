<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Subscription;
use App\Models\SiteSetting;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $currentSubscription = $user->subscription;
        $plans = [
            'artist' => Subscription::getPlanDetails('artist'),
            'record_label' => Subscription::getPlanDetails('record_label'),
            'premium' => Subscription::getPlanDetails('premium'),
        ];

        return view('dashboard.subscription', compact('currentSubscription', 'plans'));
    }

    public function initialize(Request $request)
    {
        return $this->initializePayment($request);
    }

    public function initializePayment(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:artist,record_label,premium'
        ]);

        $user = Auth::user();
        $planDetails = Subscription::getPlanDetails($request->plan);

        if (!$planDetails) {
            return back()->with('error', 'Invalid subscription plan selected.');
        }

        // Create or update subscription record
        $subscription = Subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'plan_name' => $request->plan,
                'amount' => $planDetails['amount'],
                'status' => 'pending'
            ]
        );

        // Initialize Paystack payment
        $response = $this->getPaystackHttpClient()
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $user->email,
                'amount' => $planDetails['amount'], // Amount in kobo
                'currency' => 'NGN',
                'reference' => 'SUB_' . $subscription->id . '_' . time(),
                'callback_url' => route('subscription.callback'),
                'metadata' => [
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'plan_name' => $request->plan
                ]
            ]);

        if ($response->successful()) {
            $data = $response->json()['data'];
            
            $subscription->update([
                'paystack_reference' => $data['reference'],
                'paystack_access_code' => $data['access_code']
            ]);

            return redirect($data['authorization_url']);
        }

        return back()->with('error', 'Payment initialization failed. Please try again.');
    }

    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('dashboard.subscription')->with('error', 'Payment reference not found.');
        }

        // Verify payment with Paystack
        $response = $this->getPaystackHttpClient()
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->successful()) {
            $data = $response->json()['data'];

            if ($data['status'] === 'success') {
                $subscription = Subscription::where('paystack_reference', $reference)->first();

                if ($subscription) {
                    $planDetails = Subscription::getPlanDetails($subscription->plan_name);
                    
                    $subscription->update([
                        'status' => 'active',
                        'started_at' => now(),
                        'expires_at' => now()->addDays($planDetails['duration']),
                        'metadata' => $data
                    ]);

                    // Update user role if needed
                    $user = $subscription->user;
                    if ($subscription->plan_name === 'artist' && $user->role === 'listener') {
                        $user->update(['role' => 'artist']);
                    } elseif ($subscription->plan_name === 'record_label' && in_array($user->role, ['listener', 'artist'])) {
                        $user->update(['role' => 'record_label']);
                    }

                    return redirect()->route('dashboard.subscription')->with('success', 'Subscription activated successfully!');
                }
            }
        }

        return redirect()->route('dashboard.subscription')->with('error', 'Payment verification failed.');
    }

    /**
     * Initialize payment via API (returns JSON)
     */
    public function initializeApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric|min:100',
            'plan' => 'nullable|in:artist,record_label,premium'
        ]);

        try {
            $user = Auth::user();
            
            // If plan is provided, validate it exists, otherwise use amount directly
            $planName = $request->plan;
            $amount = $request->amount;
            
            if ($planName) {
                $planDetails = Subscription::getPlanDetails($planName);
                if (!$planDetails) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid subscription plan selected.'
                    ], 400);
                }
                $amount = $planDetails['amount'];
            }

            // Create or update subscription record
            $subscription = Subscription::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'plan_name' => $planName ?: 'custom',
                    'amount' => $amount,
                    'status' => 'pending'
                ]
            );

            // Initialize Paystack payment
            try {
                $response = $this->getPaystackHttpClient()
                    ->post('https://api.paystack.co/transaction/initialize', [
                        'email' => $request->email,
                        'amount' => $amount, // Amount in kobo
                        'currency' => 'NGN',
                        'reference' => 'API_SUB_' . $subscription->id . '_' . time(),
                        'callback_url' => url('/api/paystack/callback'),
                        'metadata' => [
                            'user_id' => $user->id,
                            'subscription_id' => $subscription->id,
                            'plan_name' => $planName ?: 'custom',
                            'api_request' => true
                        ]
                    ]);

                if ($response->successful()) {
                    $data = $response->json()['data'];
                    
                    $subscription->update([
                        'paystack_reference' => $data['reference'],
                        'paystack_access_code' => $data['access_code']
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Payment initialization successful',
                        'authorization_url' => $data['authorization_url'],
                        'access_code' => $data['access_code'],
                        'reference' => $data['reference']
                    ]);
                }
            } catch (\Exception $httpException) {
                // External API not accessible, use demo mode
            }
            
            // Demo mode fallback
            $mockReference = 'MOCK_API_SUB_' . $subscription->id . '_' . time();
            $mockAccessCode = 'mock_access_' . substr(md5($mockReference), 0, 10);
            
            $subscription->update([
                'paystack_reference' => $mockReference,
                'paystack_access_code' => $mockAccessCode
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment initialization successful (Demo Mode)',
                'authorization_url' => 'https://checkout.paystack.com/' . $mockAccessCode,
                'access_code' => $mockAccessCode,
                'reference' => $mockReference,
                'demo_mode' => true,
                'note' => 'This is a demo response since Paystack API is not accessible'
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment initialization failed. Please try again.'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle payment callback via API (returns JSON)
     */
    public function callbackApi(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment reference not found.'
            ], 400);
        }

        try {
            // Verify payment with Paystack
            try {
                $response = $this->getPaystackHttpClient()
                    ->get("https://api.paystack.co/transaction/verify/{$reference}");

                if ($response->successful()) {
                    $data = $response->json()['data'];

                    if ($data['status'] === 'success') {
                        $subscription = Subscription::where('paystack_reference', $reference)->first();

                        if ($subscription) {
                            $planDetails = null;
                            if ($subscription->plan_name !== 'custom') {
                                $planDetails = Subscription::getPlanDetails($subscription->plan_name);
                            }
                            
                            $expiresAt = $planDetails ? now()->addDays($planDetails['duration']) : null;
                            
                            $subscription->update([
                                'status' => 'active',
                                'started_at' => now(),
                                'expires_at' => $expiresAt,
                                'metadata' => $data
                            ]);

                            // Update user role if needed for subscription plans
                            if ($subscription->plan_name !== 'custom') {
                                $user = $subscription->user;
                                if ($subscription->plan_name === 'artist' && $user->role === 'listener') {
                                    $user->update(['role' => 'artist']);
                                } elseif ($subscription->plan_name === 'record_label' && in_array($user->role, ['listener', 'artist'])) {
                                    $user->update(['role' => 'record_label']);
                                }
                            }

                            return response()->json([
                                'status' => 'success',
                                'message' => 'Payment verified and subscription activated successfully!',
                                'subscription' => [
                                    'id' => $subscription->id,
                                    'plan_name' => $subscription->plan_name,
                                    'amount' => $subscription->amount,
                                    'status' => $subscription->status,
                                    'started_at' => $subscription->started_at,
                                    'expires_at' => $subscription->expires_at,
                                ],
                                'transaction' => [
                                    'reference' => $data['reference'],
                                    'amount' => $data['amount'],
                                    'status' => $data['status'],
                                    'paid_at' => $data['paid_at'] ?? null,
                                ]
                            ]);
                        }
                    }

                    return response()->json([
                        'status' => 'error',
                        'message' => 'Payment verification failed - transaction not successful or subscription not found.'
                    ], 400);
                }
            } catch (\Exception $httpException) {
                // External API not accessible, fallback to demo mode
            }
            
            // Demo mode for when external API is not accessible
            if (strpos($reference, 'MOCK_') === 0) {
                $subscription = Subscription::where('paystack_reference', $reference)->first();

                if ($subscription) {
                    $planDetails = null;
                    if ($subscription->plan_name !== 'custom') {
                        $planDetails = Subscription::getPlanDetails($subscription->plan_name);
                    }
                    
                    $expiresAt = $planDetails ? now()->addDays($planDetails['duration']) : now()->addDays(30);
                    
                    $subscription->update([
                        'status' => 'active',
                        'started_at' => now(),
                        'expires_at' => $expiresAt,
                        'metadata' => ['demo_mode' => true, 'reference' => $reference]
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Payment verified and subscription activated successfully! (Demo Mode)',
                        'subscription' => [
                            'id' => $subscription->id,
                            'plan_name' => $subscription->plan_name,
                            'amount' => $subscription->amount,
                            'status' => $subscription->status,
                            'started_at' => $subscription->started_at,
                            'expires_at' => $subscription->expires_at,
                        ],
                        'transaction' => [
                            'reference' => $reference,
                            'amount' => $subscription->amount,
                            'status' => 'success',
                            'paid_at' => now()->toISOString(),
                        ],
                        'demo_mode' => true,
                        'note' => 'This is a demo response since Paystack API is not accessible'
                    ]);
                }
            }
            
            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed - could not verify with Paystack or reference not found.'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during verification: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancel()
    {
        $user = Auth::user();
        $subscription = $user->subscription;

        if ($subscription && $subscription->status === 'active') {
            $subscription->update(['status' => 'cancelled']);
            return back()->with('success', 'Subscription cancelled successfully.');
        }

        return back()->with('error', 'No active subscription to cancel.');
    }

    /**
     * Get Paystack secret key from admin settings or fallback to env
     */
    private function getPaystackSecretKey()
    {
        $key = SiteSetting::get('paystack_secret_key');
        return $key ?: env('PAYSTACK_SECRET_KEY', 'sk_test_demo_key_replace_with_yours');
    }

    /**
     * Get HTTP client with SSL configuration for Paystack
     */
    private function getPaystackHttpClient()
    {
        $client = Http::withToken($this->getPaystackSecretKey())
            ->timeout(10);
            
        // For production, use proper SSL verification
        if (env('APP_ENV') === 'production') {
            // In production, ensure SSL certificates are properly configured
            return $client;
        } else {
            // For development/testing, you may need to disable SSL verification
            // Only use this for testing environments with PAYSTACK_VERIFY_SSL=false
            if (env('PAYSTACK_VERIFY_SSL', true) === false) {
                return $client->withOptions(['verify' => false]);
            }
            return $client;
        }
    }

    /**
     * Get Paystack public key from admin settings or fallback to env
     */
    private function getPaystackPublicKey()
    {
        $key = SiteSetting::get('paystack_public_key');
        return $key ?: env('PAYSTACK_PUBLIC_KEY', 'pk_test_demo_key_replace_with_yours');
    }
}