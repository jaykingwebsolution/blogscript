@extends('layouts.app')

@section('title', 'Subscription')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Subscription Management</h1>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Current Subscription Status -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold mb-2">Current Plan</h2>
                            @if($currentSubscription && $currentSubscription->isActive())
                                <p class="text-lg">{{ ucfirst($currentSubscription->plan_name) }} Plan</p>
                                <p class="text-sm opacity-75">Expires: {{ $currentSubscription->expires_at->format('M j, Y') }}</p>
                                <p class="text-sm opacity-75">{{ $currentSubscription->daysRemaining() }} days remaining</p>
                            @else
                                <p class="text-lg">Free Plan</p>
                                <p class="text-sm opacity-75">Basic features included</p>
                            @endif
                        </div>
                        <div class="text-right">
                            @if($currentSubscription && $currentSubscription->isActive())
                                <form method="POST" action="{{ route('subscription.cancel') }}" onsubmit="return confirm('Are you sure you want to cancel your subscription?')">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm transition-colors">
                                        Cancel Subscription
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Available Plans -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($plans as $planKey => $planDetails)
                    <div class="bg-white border-2 {{ ($currentSubscription && $currentSubscription->plan_name === $planKey && $currentSubscription->isActive()) ? 'border-purple-500' : 'border-gray-200' }} rounded-lg p-6 relative">
                        @if($currentSubscription && $currentSubscription->plan_name === $planKey && $currentSubscription->isActive())
                            <div class="absolute top-0 right-0 bg-purple-500 text-white px-3 py-1 rounded-bl-lg rounded-tr-lg text-sm font-medium">
                                Current
                            </div>
                        @endif

                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $planDetails['name'] }}</h3>
                            <div class="text-3xl font-bold text-purple-600 mb-4">
                                ₦{{ number_format($planDetails['amount'] / 100, 0) }}
                                @if($planDetails['duration'] > 0)
                                    <span class="text-sm text-gray-500 font-normal">/ {{ $planDetails['duration'] }} days</span>
                                @endif
                            </div>

                            <ul class="text-left text-sm text-gray-600 mb-6 space-y-2">
                                @foreach($planDetails['features'] as $feature)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $feature }}
                                </li>
                                @endforeach
                            </ul>

                            @if($planKey === 'free')
                                @if(!$currentSubscription || !$currentSubscription->isActive() || $currentSubscription->plan_name !== 'free')
                                    <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded cursor-not-allowed" disabled>
                                        Current Plan
                                    </button>
                                @else
                                    <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded cursor-not-allowed" disabled>
                                        Free Forever
                                    </button>
                                @endif
                            @else
                                @if($currentSubscription && $currentSubscription->plan_name === $planKey && $currentSubscription->isActive())
                                    <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded cursor-not-allowed" disabled>
                                        Current Plan
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('subscription.initialize') }}">
                                        @csrf
                                        <input type="hidden" name="plan" value="{{ $planKey }}">
                                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded transition-colors">
                                            @if($currentSubscription && $currentSubscription->isActive())
                                                Upgrade to {{ $planDetails['name'] }}
                                            @else
                                                Subscribe Now
                                            @endif
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($currentSubscription && $currentSubscription->isActive())
                <!-- Subscription Details -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Subscription Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Plan:</span>
                            <span class="text-gray-900">{{ ucfirst($currentSubscription->plan_name) }} Plan</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst($currentSubscription->status) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Started:</span>
                            <span class="text-gray-900">{{ $currentSubscription->started_at ? $currentSubscription->started_at->format('M j, Y') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Expires:</span>
                            <span class="text-gray-900">{{ $currentSubscription->expires_at ? $currentSubscription->expires_at->format('M j, Y') : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Amount Paid:</span>
                            <span class="text-gray-900">₦{{ number_format($currentSubscription->amount, 2) }}</span>
                        </div>
                        @if($currentSubscription->paystack_reference)
                        <div>
                            <span class="font-medium text-gray-700">Reference:</span>
                            <span class="text-gray-900 font-mono text-xs">{{ $currentSubscription->paystack_reference }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Distribution Pricing Section (for Artists and Record Labels) -->
                @if($distributionPricingPlans && ($distributionPricingPlans->count() > 0) && (auth()->user()->isArtist() || auth()->user()->isRecordLabel()))
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        Distribution Pricing Plans
                    </h3>
                    
                    @if(auth()->user()->hasDistributionAccess())
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                You already have distribution access! You can submit your music for distribution.
                            </div>
                            <a href="{{ route('distribution.create') }}" class="inline-flex items-center mt-2 text-green-800 hover:text-green-900 font-medium">
                                Go to Distribution Form →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-600 mb-6">Choose a distribution plan to get your music on major streaming platforms like Spotify, Apple Music, and more.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($distributionPricingPlans as $plan)
                            <div class="bg-white border-2 border-gray-200 rounded-lg p-6 hover:border-purple-500 transition-colors">
                                <div class="text-center">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $plan->name }}</h4>
                                    <div class="text-2xl font-bold text-purple-600 mb-3">
                                        {{ $plan->formatted_price }}
                                    </div>
                                    <div class="mb-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            @if(str_contains(strtolower($plan->duration), '6 month')) bg-blue-100 text-blue-800
                                            @elseif(str_contains(strtolower($plan->duration), '1 year') || str_contains(strtolower($plan->duration), '12 month')) bg-purple-100 text-purple-800
                                            @elseif(str_contains(strtolower($plan->duration), 'lifetime')) bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $plan->duration }}
                                        </span>
                                    </div>
                                    
                                    <ul class="text-left text-sm text-gray-600 mb-6 space-y-2">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Distribute to all major platforms
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Keep 100% of your royalties
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Unlimited uploads
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Analytics & reporting
                                        </li>
                                    </ul>

                                    <a href="{{ route('payment.distribution-plan', $plan->id) }}" 
                                       class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded transition-colors inline-block text-center font-medium">
                                        Choose This Plan
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endif

                <!-- Benefits Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Why Upgrade?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <div>
                                <h4 class="font-medium text-gray-900">Unlimited Uploads</h4>
                                <p class="text-sm text-gray-600">Upload unlimited music tracks and manage your catalog</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <div>
                                <h4 class="font-medium text-gray-900">Advanced Analytics</h4>
                                <p class="text-sm text-gray-600">Track your music performance and audience insights</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-medium text-gray-900">Priority Support</h4>
                                <p class="text-sm text-gray-600">Get faster response times and dedicated support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection