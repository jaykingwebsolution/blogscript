<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Subscription;
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
        $response = Http::withToken(config('paystack.secret_key'))
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
        $response = Http::withToken(config('paystack.secret_key'))
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
}