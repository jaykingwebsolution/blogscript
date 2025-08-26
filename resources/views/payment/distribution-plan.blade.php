@extends('layouts.app')

@section('title', 'Distribution Payment - MusicStream')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-spotify-black to-gray-900 p-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-spotify-green rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Music Distribution Payment</h1>
            <p class="text-gray-300">Complete your payment to get your music on all major streaming platforms</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Payment Methods -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white mb-4">{{ $distributionPricing->name }}</h2>
                    
                    <div class="mb-6">
                        <div class="text-4xl font-bold text-spotify-green">{{ $distributionPricing->formatted_price }}</div>
                        <div class="text-gray-400">{{ $distributionPricing->duration }}</div>
                    </div>

                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if(str_contains(strtolower($distributionPricing->duration), '6 month')) bg-blue-100 text-blue-800
                            @elseif(str_contains(strtolower($distributionPricing->duration), '1 year') || str_contains(strtolower($distributionPricing->duration), '12 month')) bg-purple-100 text-purple-800
                            @elseif(str_contains(strtolower($distributionPricing->duration), 'lifetime')) bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $distributionPricing->duration }} Access
                        </span>
                    </div>
                </div>

                <!-- Paystack Payment -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-white mb-4">💳 Online Payment</h3>
                    <p class="text-gray-300 text-sm mb-4">Pay securely with your card via Paystack</p>
                    
                    <form method="POST" action="{{ route('payment.distribution.initialize') }}">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $distributionPricing->id }}">
                        <button type="submit" 
                                class="w-full bg-spotify-green hover:bg-spotify-green-light text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Pay {{ $distributionPricing->formatted_price }}
                        </button>
                    </form>
                </div>

                <!-- Manual Payment -->
                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-white mb-4">🏦 Bank Transfer</h3>
                    <p class="text-gray-300 text-sm mb-4">Make a direct bank transfer and upload proof of payment</p>
                    
                    <button onclick="toggleBankDetails()" 
                            class="w-full bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Bank Transfer Details
                    </button>
                </div>

                <!-- Demo Mode -->
                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-white mb-4">🚀 Demo Mode</h3>
                    <p class="text-gray-300 text-sm mb-4">For testing purposes - skip payment</p>
                    
                    <form method="POST" action="{{ route('payment.distribution.demo') }}">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $distributionPricing->id }}">
                        <button type="submit" 
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Demo Payment (Skip)
                        </button>
                    </form>
                </div>
            </div>

            <!-- Plan Features -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <h3 class="text-xl font-bold text-white mb-6">What You Get</h3>
                
                <div class="space-y-4 mb-8">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-spotify-green mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-white font-semibold">All Major Platforms</h4>
                            <p class="text-gray-300 text-sm">Spotify, Apple Music, Amazon Music, YouTube Music, and 150+ more</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-spotify-green mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-white font-semibold">100% Royalty Retention</h4>
                            <p class="text-gray-300 text-sm">Keep all your royalties - no hidden fees or revenue sharing</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-spotify-green mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-white font-semibold">Unlimited Uploads</h4>
                            <p class="text-gray-300 text-sm">Upload as many tracks as you want during your plan period</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-spotify-green mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-white font-semibold">Analytics & Reports</h4>
                            <p class="text-gray-300 text-sm">Detailed performance analytics and earnings reports</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-spotify-green mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-white font-semibold">Fast Processing</h4>
                            <p class="text-gray-300 text-sm">Your music goes live within 24-48 hours on most platforms</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-spotify-green mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-white font-semibold">{{ $distributionPricing->duration }} Access</h4>
                            <p class="text-gray-300 text-sm">Full distribution access for the entire {{ strtolower($distributionPricing->duration) }} period</p>
                        </div>
                    </div>
                </div>

                <!-- Back to Plans Button -->
                <div class="border-t border-gray-700 pt-6">
                    <a href="{{ route('dashboard.subscription') }}" 
                       class="w-full bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Plans
                    </a>
                </div>
            </div>
        </div>

        <!-- Bank Details Modal -->
        <div id="bankDetailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Bank Transfer Details</h3>
                    <button onclick="toggleBankDetails()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Account Name</label>
                        <p class="text-gray-900 font-mono">{{ $bankDetails['account_name'] }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Account Number</label>
                        <p class="text-gray-900 font-mono text-lg">{{ $bankDetails['account_number'] }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Bank Name</label>
                        <p class="text-gray-900">{{ $bankDetails['bank_name'] }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Amount</label>
                        <p class="text-gray-900 text-lg font-bold">{{ $distributionPricing->formatted_price }}</p>
                    </div>
                </div>

                <!-- Manual Payment Form -->
                <form method="POST" action="{{ route('payment.manual.submit') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="payment_type" value="distribution">
                    <input type="hidden" name="plan_id" value="{{ $distributionPricing->id }}">
                    
                    <div>
                        <label for="transaction_reference" class="block text-sm font-medium text-gray-700 mb-2">
                            Transaction Reference <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="transaction_reference" 
                               name="transaction_reference" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent"
                               placeholder="Enter bank transfer reference">
                    </div>

                    <div>
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                            Payment Proof <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               id="payment_proof" 
                               name="payment_proof" 
                               accept="image/*,.pdf"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Upload screenshot or receipt (JPG, PNG, PDF - Max 10MB)</p>
                    </div>

                    <button type="submit" 
                            class="w-full bg-spotify-green hover:bg-spotify-green-light text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                        Submit Manual Payment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleBankDetails() {
    const modal = document.getElementById('bankDetailsModal');
    modal.classList.toggle('hidden');
}

// Close modal when clicking outside
document.getElementById('bankDetailsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        toggleBankDetails();
    }
});
</script>
@endsection