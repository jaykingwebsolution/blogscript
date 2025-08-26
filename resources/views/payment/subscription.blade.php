@extends('layouts.app')

@section('title', 'Subscription Payment - MusicStream')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-spotify-black to-gray-900 p-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-spotify-green rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Complete Your Subscription</h1>
            <p class="text-gray-300">{{ $plan->name }} - {{ $plan->formatted_amount }}/{{ $plan->billing_interval }}</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Payment Methods -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <h2 class="text-xl font-bold text-white mb-6">Choose Payment Method</h2>

                <!-- Paystack Payment -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-white mb-4">💳 Online Payment</h3>
                    <p class="text-gray-300 text-sm mb-4">Pay securely with your card via Paystack</p>
                    
                    <form method="POST" action="{{ route('payment.subscription.initialize') }}">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <button type="submit" 
                                class="w-full bg-spotify-green text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Pay {{ $plan->formatted_amount }} with Card
                        </button>
                    </form>
                    
                    @if(config('app.env') !== 'production')
                        <div class="mt-4">
                            <p class="text-orange-300 text-sm mb-2">Demo Mode (Test Environment)</p>
                            <form method="POST" action="{{ route('payment.subscription.demo') }}" class="inline">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" 
                                        class="w-full bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-700 transition-colors flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Test Payment Success
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Manual Payment -->
                <div class="border-t border-white/20 pt-6">
                    <h3 class="text-lg font-semibold text-white mb-4">🏦 Bank Transfer</h3>
                    <p class="text-gray-300 text-sm mb-4">Transfer to our bank account and upload receipt</p>
                    
                    <!-- Bank Details -->
                    <div class="bg-white/5 rounded-lg p-4 mb-4">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Account Name:</span>
                                <span class="text-white">{{ $bankDetails['account_name'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Account Number:</span>
                                <span class="text-white font-mono">{{ $bankDetails['account_number'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Bank:</span>
                                <span class="text-white">{{ $bankDetails['bank_name'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Amount:</span>
                                <span class="text-spotify-green font-semibold">{{ $plan->formatted_amount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Manual Payment Form -->
                    <form method="POST" action="{{ route('payment.manual.submit') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="payment_type" value="subscription">
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        
                        <div>
                            <label for="transaction_reference" class="block text-sm font-medium text-gray-300 mb-2">Transaction Reference</label>
                            <input type="text" 
                                   id="transaction_reference" 
                                   name="transaction_reference" 
                                   required 
                                   class="w-full bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg px-4 py-3 focus:ring-2 focus:ring-spotify-green focus:border-transparent"
                                   placeholder="Enter your bank reference number">
                            @error('transaction_reference')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="payment_proof" class="block text-sm font-medium text-gray-300 mb-2">Payment Receipt</label>
                            <input type="file" 
                                   id="payment_proof" 
                                   name="payment_proof" 
                                   accept="image/*,.pdf" 
                                   required 
                                   class="w-full bg-white/10 border border-white/20 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-spotify-green focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:bg-spotify-green file:text-white hover:file:bg-green-600">
                            <p class="text-gray-400 text-xs mt-1">Upload PNG, JPG, or PDF (max 10MB)</p>
                            @error('payment_proof')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Submit Manual Payment
                        </button>
                    </form>

                    @if($bankDetails['instructions'])
                        <div class="mt-4 p-3 bg-yellow-500/10 border border-yellow-500/50 rounded-lg">
                            <p class="text-yellow-200 text-sm">{{ $bankDetails['instructions'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Plan Details -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <h3 class="text-xl font-bold text-white mb-6">Plan Details</h3>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Plan:</span>
                        <span class="text-white font-semibold">{{ $plan->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Price:</span>
                        <span class="text-spotify-green font-semibold">{{ $plan->formatted_amount }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Billing:</span>
                        <span class="text-white">{{ ucfirst($plan->billing_interval) }}</span>
                    </div>
                </div>

                @if($plan->features)
                    <div class="space-y-3">
                        <h4 class="font-semibold text-white">What's included:</h4>
                        @foreach($plan->features as $feature)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-spotify-green mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-300 text-sm">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Security Badge -->
                <div class="mt-8 pt-6 border-t border-white/20 text-center">
                    <div class="flex items-center justify-center space-x-2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="text-sm">Secure payment processing</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-8">
            <a href="{{ route('payment.plans') }}" class="text-gray-400 hover:text-white transition-colors">
                ← Back to Plans
            </a>
        </div>
    </div>
</div>
@endsection