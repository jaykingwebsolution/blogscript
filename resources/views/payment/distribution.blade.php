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
            <h1 class="text-3xl font-bold text-white mb-2">Music Distribution Access</h1>
            <p class="text-gray-300">Get your music on all major streaming platforms</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pricing Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-white mb-4">{{ $distributionPlan->name }}</h2>
                    
                    <div class="mb-6">
                        <div class="text-4xl font-bold text-spotify-green">{{ $distributionPlan->formatted_amount }}</div>
                        <div class="text-gray-400">One-time payment</div>
                    </div>

                    <div class="text-gray-300 mb-6">
                        {{ $distributionPlan->description }}
                    </div>

                    <!-- Features -->
                    @if($distributionPlan->features)
                        <div class="text-left space-y-3 mb-8">
                            <h3 class="text-lg font-semibold text-white mb-4">What you get:</h3>
                            @foreach($distributionPlan->features as $feature)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-spotify-green mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-gray-300">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Payment Form -->
                    <form method="POST" action="{{ route('payment.distribution.initialize') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-spotify-green text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Pay Securely with Paystack
                        </button>
                    </form>

                    <!-- Demo Payment Button -->
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <p class="text-xs text-gray-400 mb-2">For demo purposes:</p>
                        <form method="POST" action="{{ route('payment.distribution.demo') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-700 transition-colors text-sm">
                                Simulate Successful Payment (Demo)
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <h3 class="text-xl font-bold text-white mb-6">Why Choose Our Distribution?</h3>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-spotify-green/20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-spotify-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white">Global Reach</h4>
                            <p class="text-gray-300 text-sm">Distribute to over 50 streaming platforms worldwide including Spotify, Apple Music, YouTube Music, and more.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-spotify-green/20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-spotify-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white">Keep 100% Royalties</h4>
                            <p class="text-gray-300 text-sm">You keep all your earnings. We don't take any percentage from your streaming revenue.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-spotify-green/20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-spotify-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white">Detailed Analytics</h4>
                            <p class="text-gray-300 text-sm">Track your music's performance with comprehensive analytics and reporting tools.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-spotify-green/20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-spotify-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white">Fast Processing</h4>
                            <p class="text-gray-300 text-sm">Your music will be live on streaming platforms within 24-48 hours of approval.</p>
                        </div>
                    </div>
                </div>

                <!-- Security Badge -->
                <div class="mt-8 pt-6 border-t border-white/20 text-center">
                    <div class="flex items-center justify-center space-x-2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="text-sm">Secure payment powered by Paystack</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-8">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection