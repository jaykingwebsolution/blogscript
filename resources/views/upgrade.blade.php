@extends('layouts.app')

@section('title', 'Upgrade Account - MusicStream')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-4">
                Upgrade Your Account
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Choose the perfect plan to unlock premium features and take your music experience to the next level
            </p>
        </div>

        <!-- Current Plan Display -->
        @if(Auth::check() && Auth::user()->hasActiveSubscription())
        <div class="bg-gradient-to-r from-green-900/50 to-green-700/50 border border-green-700/50 rounded-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-500 p-2 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-300">Current Active Plan</h3>
                        <p class="text-sm text-green-200">{{ ucfirst(Auth::user()->subscription->plan_name) }} Plan</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-green-200">Expires</p>
                    <p class="font-semibold text-green-300">{{ Auth::user()->subscription->expires_at->format('M j, Y') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Pricing Plans -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Free Plan -->
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 relative">
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-2">Free</h3>
                    <div class="mb-4">
                        <span class="text-3xl font-bold">₦0</span>
                        <span class="text-gray-400">/forever</span>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-300 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Basic music streaming
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Limited playlist creation
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Follow artists
                        </li>
                    </ul>
                    @if(!Auth::check() || !Auth::user()->hasActiveSubscription())
                    <span class="block w-full bg-gray-600 text-gray-300 py-2 px-4 rounded-full text-center font-medium">
                        Current Plan
                    </span>
                    @else
                    <button disabled class="block w-full bg-gray-600 text-gray-400 py-2 px-4 rounded-full text-center font-medium cursor-not-allowed">
                        Free Plan
                    </button>
                    @endif
                </div>
            </div>

            <!-- Artist Plan -->
            <div class="bg-purple-900/50 backdrop-blur-sm border border-purple-700/50 rounded-xl p-6 relative transform hover:scale-105 transition-transform">
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-2">Artist</h3>
                    <div class="mb-4">
                        <span class="text-3xl font-bold">₦50</span>
                        <span class="text-gray-400">/month</span>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-300 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-purple-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Unlimited music uploads
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-purple-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Basic analytics
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-purple-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Priority support
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-purple-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Earnings dashboard
                        </li>
                    </ul>
                    @if(Auth::check() && Auth::user()->hasActiveSubscription() && Auth::user()->subscription->plan_name === 'artist')
                    <span class="block w-full bg-purple-600 text-white py-2 px-4 rounded-full text-center font-medium">
                        Current Plan
                    </span>
                    @else
                    <button onclick="subscribeToPlan('artist', 5000)" class="block w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-full text-center font-medium transition-colors">
                        Subscribe Now
                    </button>
                    @endif
                </div>
            </div>

            <!-- Artist Premium Plan -->
            <div class="bg-gradient-to-br from-pink-900/50 to-purple-900/50 backdrop-blur-sm border border-pink-700/50 rounded-xl p-6 relative transform hover:scale-105 transition-transform">
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                    <span class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                        POPULAR
                    </span>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-2">Artist Premium</h3>
                    <div class="mb-4">
                        <span class="text-3xl font-bold">₦100</span>
                        <span class="text-gray-400">/month</span>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-300 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-pink-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            All Artist features
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-pink-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Advanced analytics
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-pink-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Music distribution
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-pink-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Priority promotion
                        </li>
                    </ul>
                    @if(Auth::check() && Auth::user()->hasActiveSubscription() && Auth::user()->subscription->plan_name === 'artist_premium')
                    <span class="block w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white py-2 px-4 rounded-full text-center font-medium">
                        Current Plan
                    </span>
                    @else
                    <button onclick="subscribeToPlan('artist_premium', 10000)" class="block w-full bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white py-2 px-4 rounded-full text-center font-medium transition-colors">
                        Subscribe Now
                    </button>
                    @endif
                </div>
            </div>

            <!-- Record Label Premium -->
            <div class="bg-blue-900/50 backdrop-blur-sm border border-blue-700/50 rounded-xl p-6 relative transform hover:scale-105 transition-transform">
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-2">Record Label</h3>
                    <div class="mb-4">
                        <span class="text-3xl font-bold">₦200</span>
                        <span class="text-gray-400">/month</span>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-300 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Manage multiple artists
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Advanced analytics
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Custom branding
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Bulk distribution
                        </li>
                    </ul>
                    @if(Auth::check() && Auth::user()->hasActiveSubscription() && Auth::user()->subscription->plan_name === 'record_label')
                    <span class="block w-full bg-blue-600 text-white py-2 px-4 rounded-full text-center font-medium">
                        Current Plan
                    </span>
                    @else
                    <button onclick="subscribeToPlan('record_label', 20000)" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-full text-center font-medium transition-colors">
                        Subscribe Now
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Diamond Plan -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-gradient-to-r from-yellow-900/50 via-yellow-800/50 to-yellow-900/50 backdrop-blur-sm border border-yellow-700/50 rounded-xl p-8 relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black text-sm font-bold px-4 py-2 rounded-full flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        DIAMOND VIP
                    </span>
                </div>
                <div class="text-center mt-4">
                    <h3 class="text-2xl font-bold mb-2 text-yellow-400">Diamond</h3>
                    <div class="mb-4">
                        <span class="text-4xl font-bold text-yellow-300">₦500</span>
                        <span class="text-gray-400">/month</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-300 mb-8">
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                All premium features
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Dedicated account manager
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Priority playlist placement
                            </li>
                        </ul>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Marketing campaign support
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Custom homepage features
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                24/7 priority support
                            </li>
                        </ul>
                    </div>
                    @if(Auth::check() && Auth::user()->hasActiveSubscription() && Auth::user()->subscription->plan_name === 'diamond')
                    <span class="block w-full bg-gradient-to-r from-yellow-600 to-yellow-700 text-black py-3 px-6 rounded-full text-center font-bold">
                        Current Plan
                    </span>
                    @else
                    <button onclick="subscribeToPlan('diamond', 50000)" class="block w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-black py-3 px-6 rounded-full text-center font-bold transition-colors">
                        Subscribe Now
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-center mb-8">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="bg-gray-800/50 rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-2">Can I change my plan anytime?</h3>
                    <p class="text-gray-400">Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle.</p>
                </div>
                <div class="bg-gray-800/50 rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-2">What payment methods do you accept?</h3>
                    <p class="text-gray-400">We accept all major credit/debit cards and mobile money payments through our secure Paystack integration.</p>
                </div>
                <div class="bg-gray-800/50 rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-2">Is there a free trial?</h3>
                    <p class="text-gray-400">Yes! All new users start with our free plan, and you can upgrade to any premium plan at any time.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-900 rounded-lg p-8 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="mb-4">
                <svg class="w-12 h-12 text-blue-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Complete Your Subscription</h3>
            <p class="text-gray-400 mb-6">You will be redirected to Paystack to complete your payment securely.</p>
            <div class="flex space-x-3">
                <button onclick="closePaymentModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded font-medium transition-colors">
                    Cancel
                </button>
                <button id="proceedPayment" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded font-medium transition-colors">
                    Proceed
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let selectedPlan = null;
let selectedAmount = null;

function subscribeToPlan(plan, amount) {
    @guest
    window.location.href = '{{ route('login') }}';
    return;
    @endguest

    selectedPlan = plan;
    selectedAmount = amount;
    
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    selectedPlan = null;
    selectedAmount = null;
}

document.getElementById('proceedPayment').addEventListener('click', function() {
    if (!selectedPlan || !selectedAmount) {
        alert('Please select a plan first');
        return;
    }

    // Show loading state
    this.innerHTML = 'Processing...';
    this.disabled = true;

    // Initialize payment
    fetch('{{ route('payment.subscription.initialize') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            plan: selectedPlan,
            amount: selectedAmount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.authorization_url;
        } else {
            alert(data.message || 'Payment initialization failed. Please try again.');
            this.innerHTML = 'Proceed';
            this.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        this.innerHTML = 'Proceed';
        this.disabled = false;
    });
});
</script>
@endpush
@endsection