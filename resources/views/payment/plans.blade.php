@extends('layouts.app')

@section('title', 'Subscription Plans - MusicStream')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-spotify-black to-gray-900 p-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-spotify-green rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-4">Choose Your Plan</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">Unlock premium features and distribute your music worldwide</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg mb-8 max-w-2xl mx-auto">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-8 max-w-2xl mx-auto">
                {{ session('success') }}
            </div>
        @endif

        <!-- Distribution Plan -->
        @if($distributionPlan && ($user->isArtist() || $user->isRecordLabel()) && !$user->hasDistributionAccess())
        <div class="mb-12">
            <div class="bg-gradient-to-r from-spotify-green/20 to-green-600/20 backdrop-blur-sm rounded-2xl p-8 border border-spotify-green/30">
                <div class="flex items-center justify-between flex-wrap gap-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">🎵 Music Distribution Required</h2>
                        <p class="text-gray-300 mb-4">Distribute your music to 50+ streaming platforms worldwide</p>
                        <div class="text-3xl font-bold text-spotify-green">{{ $distributionPlan->formatted_amount }}</div>
                        <div class="text-gray-400">One-time payment</div>
                    </div>
                    <div class="flex flex-col space-y-3">
                        <a href="{{ route('payment.distribution') }}" 
                           class="bg-spotify-green text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-600 transition-colors text-center">
                            Pay for Distribution
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Subscription Plans -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($subscriptionPlans as $plan)
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 relative {{ $plan->is_featured ? 'ring-2 ring-spotify-green' : '' }}">
                    @if($plan->is_featured)
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="bg-spotify-green text-white px-4 py-2 rounded-full text-sm font-semibold">
                                Most Popular
                            </span>
                        </div>
                    @endif

                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $plan->name }}</h3>
                        
                        <div class="mb-6">
                            <div class="text-4xl font-bold text-spotify-green">{{ $plan->formatted_amount }}</div>
                            <div class="text-gray-400">{{ ucfirst($plan->billing_interval) }}</div>
                        </div>

                        @if($plan->description)
                            <p class="text-gray-300 mb-6">{{ $plan->description }}</p>
                        @endif

                        <!-- Features -->
                        @if($plan->features)
                            <div class="text-left space-y-3 mb-8">
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

                        @if($user->hasActiveSubscription() && $user->subscription_plan_id === $plan->id)
                            <div class="w-full bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg cursor-not-allowed">
                                Current Plan
                            </div>
                        @else
                            <a href="{{ route('payment.subscription', ['plan' => $plan->id]) }}" 
                               class="w-full {{ $plan->is_featured ? 'bg-spotify-green hover:bg-green-600' : 'bg-white/20 hover:bg-white/30' }} text-white font-semibold py-3 px-6 rounded-lg transition-colors inline-block text-center">
                                Choose Plan
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-400 text-lg">No subscription plans available at the moment.</div>
                </div>
            @endforelse
        </div>

        <!-- Current Subscription Status -->
        @if($user->hasActiveSubscription())
            <div class="mt-12 bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <h3 class="text-xl font-bold text-white mb-4">Current Subscription</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <div class="text-gray-400 text-sm">Plan</div>
                        <div class="text-white font-semibold">{{ $user->subscriptionPlan->name ?? 'Unknown' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-400 text-sm">Status</div>
                        <div class="text-green-400 font-semibold">{{ ucfirst($user->subscription_status) }}</div>
                    </div>
                    <div>
                        <div class="text-gray-400 text-sm">Expires</div>
                        <div class="text-white font-semibold">
                            {{ $user->subscription_expires_at ? $user->subscription_expires_at->format('M d, Y') : 'Never' }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back Link -->
        <div class="text-center mt-8">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection