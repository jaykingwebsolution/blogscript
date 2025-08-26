<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PricingPlan;
use App\Models\User;
use App\Models\ManualPayment;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showPlans()
    {
        $user = auth()->user();
        $distributionPlan = PricingPlan::getDistributionFee();
        $subscriptionPlans = PricingPlan::getActiveSubscriptions();
        
        return view('payment.plans', compact('distributionPlan', 'subscriptionPlans', 'user'));
    }

    public function showDistributionPayment()
    {
        $user = auth()->user();
        
        // Only artists and record labels can access this
        if (!$user->isArtist() && !$user->isRecordLabel()) {
            abort(403, 'Only artists and record labels can access distribution services.');
        }

        // If already paid, redirect to distribution form
        if ($user->hasDistributionAccess()) {
            return redirect()->route('distribution.create');
        }

        $distributionPlan = PricingPlan::getDistributionFee();
        $bankDetails = $this->getBankDetails();
        
        if (!$distributionPlan) {
            return back()->with('error', 'Distribution pricing is not configured. Please contact support.');
        }

        return view('payment.distribution', compact('distributionPlan', 'bankDetails'));
    }

    public function showSubscriptionPayment(Request $request)
    {
        $user = auth()->user();
        $planId = $request->input('plan');
        
        if (!$planId) {
            return redirect()->route('payment.plans')->with('error', 'Please select a subscription plan.');
        }

        $plan = PricingPlan::findOrFail($planId);
        $bankDetails = $this->getBankDetails();
        
        return view('payment.subscription', compact('plan', 'bankDetails'));
    }

    // Paystack Integration
    public function initializeDistributionPayment(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isArtist() && !$user->isRecordLabel()) {
            abort(403, 'Unauthorized access.');
        }

        if ($user->hasDistributionAccess()) {
            return redirect()->route('distribution.create')->with('success', 'You already have distribution access.');
        }

        $distributionPlan = PricingPlan::getDistributionFee();
        
        if (!$distributionPlan) {
            return back()->with('error', 'Distribution pricing is not configured.');
        }

        // Generate reference
        $reference = 'DIST_' . strtoupper(Str::random(10)) . '_' . $user->id;
        
        // Initialize Paystack payment
        $response = Http::withToken($this->getPaystackSecretKey())
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $user->email,
                'amount' => $distributionPlan->amount * 100, // Convert to kobo
                'currency' => $distributionPlan->currency,
                'reference' => $reference,
                'callback_url' => route('payment.distribution.callback'),
                'metadata' => [
                    'user_id' => $user->id,
                    'payment_type' => 'distribution',
                    'plan_id' => $distributionPlan->id
                ]
            ]);

        if ($response->successful() && $response->json()['status']) {
            $data = $response->json()['data'];
            
            // Store payment reference in session for verification
            session(['payment_reference' => $reference, 'payment_type' => 'distribution']);
            
            return redirect($data['authorization_url']);
        }

        // If Paystack fails, show payment page with manual option
        return view('payment.process', [
            'plan' => $distributionPlan,
            'reference' => $reference,
            'user' => $user,
            'paystack_error' => 'Payment initialization failed. Please use manual payment or try again.'
        ]);
    }

    public function initializeSubscriptionPayment(Request $request)
    {
        $user = auth()->user();
        $planId = $request->input('plan_id');
        
        $plan = PricingPlan::findOrFail($planId);
        
        // Generate reference
        $reference = 'SUB_' . strtoupper(Str::random(10)) . '_' . $user->id;
        
        // Initialize Paystack payment
        $response = Http::withToken($this->getPaystackSecretKey())
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $user->email,
                'amount' => $plan->amount * 100, // Convert to kobo
                'currency' => $plan->currency,
                'reference' => $reference,
                'callback_url' => route('payment.subscription.callback'),
                'metadata' => [
                    'user_id' => $user->id,
                    'payment_type' => 'subscription',
                    'plan_id' => $plan->id
                ]
            ]);

        if ($response->successful() && $response->json()['status']) {
            $data = $response->json()['data'];
            
            // Store payment reference in session for verification
            session(['payment_reference' => $reference, 'payment_type' => 'subscription', 'plan_id' => $plan->id]);
            
            return redirect($data['authorization_url']);
        }

        // If Paystack fails, show payment page with manual option
        return view('payment.process', [
            'plan' => $plan,
            'reference' => $reference,
            'user' => $user,
            'paystack_error' => 'Payment initialization failed. Please use manual payment or try again.'
        ]);
    }

    public function handleDistributionCallback(Request $request)
    {
        $reference = $request->input('reference') ?? session('payment_reference');
        
        if (!$reference) {
            return redirect()->route('payment.distribution')->with('error', 'Invalid payment reference.');
        }

        // Verify payment with Paystack
        $response = Http::withToken($this->getPaystackSecretKey())
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->successful()) {
            $data = $response->json()['data'];

            if ($data['status'] === 'success') {
                $user = auth()->user();
                $distributionPlan = PricingPlan::getDistributionFee();
                
                // Mark user as having paid for distribution
                $user->markDistributionAsPaid($distributionPlan->amount, $reference);
                
                // Log the payment
                Log::info("Distribution payment successful", [
                    'user_id' => $user->id,
                    'reference' => $reference,
                    'amount' => $distributionPlan->amount
                ]);

                // Clear session
                session()->forget(['payment_reference', 'payment_type']);

                return redirect()->route('distribution.create')->with('success', 'Payment successful! You can now submit your music for distribution.');
            }
        }

        return redirect()->route('payment.distribution')->with('error', 'Payment verification failed. Please try again or contact support.');
    }

    public function handleSubscriptionCallback(Request $request)
    {
        $reference = $request->input('reference') ?? session('payment_reference');
        
        if (!$reference) {
            return redirect()->route('payment.plans')->with('error', 'Invalid payment reference.');
        }

        // Verify payment with Paystack
        $response = Http::withToken($this->getPaystackSecretKey())
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->successful()) {
            $data = $response->json()['data'];

            if ($data['status'] === 'success') {
                $user = auth()->user();
                $planId = session('plan_id');
                $plan = PricingPlan::find($planId);
                
                if ($plan) {
                    // Update user subscription status
                    $user->update([
                        'subscription_status' => 'active',
                        'subscription_plan_id' => $plan->id,
                        'subscription_paid_at' => now(),
                        'subscription_expires_at' => now()->addDays($plan->billing_interval === 'monthly' ? 30 : 365)
                    ]);
                    
                    // Log the payment
                    Log::info("Subscription payment successful", [
                        'user_id' => $user->id,
                        'reference' => $reference,
                        'plan_id' => $plan->id,
                        'amount' => $plan->amount
                    ]);

                    // Clear session
                    session()->forget(['payment_reference', 'payment_type', 'plan_id']);

                    return redirect()->route('dashboard')->with('success', 'Subscription activated successfully!');
                }
            }
        }

        return redirect()->route('payment.plans')->with('error', 'Payment verification failed. Please try again or contact support.');
    }

    // Manual Payment System
    public function submitManualPayment(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|in:distribution,subscription',
            'plan_id' => 'required|exists:pricing_plans,id',
            'transaction_reference' => 'required|string|max:255',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB max
        ]);

        $user = auth()->user();
        $plan = PricingPlan::findOrFail($request->plan_id);
        
        // Store the payment proof
        $proofPath = $request->file('payment_proof')->store('manual_payments', 'public');
        
        // Create manual payment record
        ManualPayment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'payment_type' => $request->payment_type,
            'transaction_reference' => $request->transaction_reference,
            'payment_proof' => $proofPath,
            'amount' => $plan->amount,
            'currency' => $plan->currency,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Manual payment submitted successfully! Your payment will be reviewed within 24 hours.');
    }

    // Helper method to get bank details
    private function getBankDetails()
    {
        return [
            'account_name' => SiteSetting::get('bank_account_name', 'MusicStream Limited'),
            'account_number' => SiteSetting::get('bank_account_number', '1234567890'),
            'bank_name' => SiteSetting::get('bank_name', 'First Bank of Nigeria'),
            'instructions' => SiteSetting::get('payment_instructions', 'Please include your email address as payment description.')
        ];
    }

    // For demo purposes - simulate payment success
    public function simulatePaymentSuccess(Request $request)
    {
        $user = auth()->user();
        $distributionPlan = PricingPlan::getDistributionFee();
        $reference = 'DEMO_' . strtoupper(Str::random(10)) . '_' . $user->id;

        $user->markDistributionAsPaid($distributionPlan->amount, $reference);

        return redirect()->route('distribution.create')->with('success', 'Demo payment successful! You can now submit your music for distribution.');
    }

    // For demo purposes - simulate subscription success
    public function simulateSubscriptionSuccess(Request $request)
    {
        $user = auth()->user();
        $planId = $request->input('plan_id');
        $plan = PricingPlan::find($planId);
        
        if (!$plan) {
            return redirect()->back()->with('error', 'Plan not found.');
        }
        
        $reference = 'DEMO_SUB_' . strtoupper(Str::random(10)) . '_' . $user->id;
        
        // Update user subscription status
        $user->update([
            'subscription_status' => 'active',
            'subscription_plan_id' => $plan->id,
            'subscription_paid_at' => now(),
            'subscription_expires_at' => now()->addDays($plan->billing_interval === 'monthly' ? 30 : 365)
        ]);
        
        // Log the demo payment
        Log::info("Demo subscription payment successful", [
            'user_id' => $user->id,
            'reference' => $reference,
            'plan_id' => $plan->id,
            'amount' => $plan->amount
        ]);

        return redirect()->route('dashboard')->with('success', 'Demo subscription activated successfully!');
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
     * Get Paystack public key from admin settings or fallback to env
     */
    private function getPaystackPublicKey()
    {
        $key = SiteSetting::get('paystack_public_key');
        return $key ?: env('PAYSTACK_PUBLIC_KEY', 'pk_test_demo_key_replace_with_yours');
    }
}
