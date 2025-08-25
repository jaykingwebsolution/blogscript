<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PricingPlan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        
        if (!$distributionPlan) {
            return back()->with('error', 'Distribution pricing is not configured. Please contact support.');
        }

        return view('payment.distribution', compact('distributionPlan'));
    }

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
        
        // In a real implementation, you would initialize Paystack payment here
        // For demo purposes, we'll simulate a successful payment
        
        return view('payment.process', [
            'plan' => $distributionPlan,
            'reference' => $reference,
            'user' => $user
        ]);
    }

    public function handleDistributionCallback(Request $request)
    {
        $reference = $request->input('reference');
        $status = $request->input('status', 'success'); // For demo, assume success
        
        if (!$reference) {
            return redirect()->route('payment.distribution')->with('error', 'Invalid payment reference.');
        }

        $user = auth()->user();
        $distributionPlan = PricingPlan::getDistributionFee();

        if ($status === 'success') {
            // Mark user as having paid for distribution
            $user->markDistributionAsPaid($distributionPlan->amount, $reference);
            
            // Log the payment
            Log::info("Distribution payment successful", [
                'user_id' => $user->id,
                'reference' => $reference,
                'amount' => $distributionPlan->amount
            ]);

            return redirect()->route('distribution.create')->with('success', 'Payment successful! You can now submit your music for distribution.');
        }

        return redirect()->route('payment.distribution')->with('error', 'Payment failed. Please try again.');
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
}
