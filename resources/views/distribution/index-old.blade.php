@extends('layouts.app')

@section('title', 'Music Distribution')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-spotify-green to-green-400 rounded-full mb-6">
                <i class="fas fa-music text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Music Distribution Platform
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Get your music on 150+ digital stores worldwide including Spotify, Apple Music, YouTube Music, and more.
            </p>
        </div>

        <!-- User Status -->
        @if($user->hasDistributionAccess())
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-green-800 dark:text-green-300">
                            Distribution Access Active
                        </h3>
                        <p class="text-green-700 dark:text-green-400">
                            You have access to our distribution services. Start uploading your music today!
                        </p>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('distribution.create') }}" 
                           class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            <i class="fas fa-upload mr-2"></i>Upload Music
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-blue-800 dark:text-blue-300">
                            Get Started with Distribution
                        </h3>
                        <p class="text-blue-700 dark:text-blue-400">
                            Choose a distribution plan to start getting your music on streaming platforms worldwide.
                        </p>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('distribution.pricing') }}" 
                           class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-tag mr-2"></i>View Plans
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Features Grid -->
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-spotify-green/10 rounded-full mb-4">
                    <i class="fas fa-globe text-spotify-green text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    150+ Digital Stores
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Get your music on Spotify, Apple Music, YouTube Music, Amazon Music, Boomplay, Audiomack, and more.
                </p>
            </div>

            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500/10 rounded-full mb-4">
                    <i class="fas fa-chart-line text-green-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Real-Time Analytics
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Track your streams, downloads, and earnings across all platforms with detailed analytics.
                </p>
            </div>

            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500/10 rounded-full mb-4">
                    <i class="fas fa-money-bill-wave text-blue-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Keep Your Royalties
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Keep 85-95% of your streaming royalties depending on your plan. Get paid monthly.
                </p>
            </div>
        </div>

        <!-- Pricing Plans Preview -->
        @if($distributionPlans->count() > 0)
            <div class="mb-16">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Choose Your Plan
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Select the perfect distribution plan for your music career
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($distributionPlans->take(3) as $plan)
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 {{ $plan->isPopular() ? 'ring-2 ring-spotify-green shadow-lg transform scale-105' : '' }}">
                            @if($plan->isPopular())
                                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                    <span class="bg-spotify-green text-white px-3 py-1 rounded-full text-sm font-medium">
                                        Most Popular
                                    </span>
                                </div>
                            @endif
                            
                            <div class="text-center mb-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $plan->type_display_name }}
                                </h3>
                                <div class="mb-4">
                                    <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                        {{ $plan->formatted_price }}
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-400">
                                        /{{ $plan->duration }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                    {{ $plan->description }}
                                </p>
                            </div>

                            <ul class="space-y-3 mb-6">
                                @foreach($plan->formatted_features as $feature)
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-spotify-green mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300 text-sm">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- TODO: Update the route name below if 'distribution.purchase' is not correct --}}
                            <a href="{{ route('distribution.purchase', $plan) }}" 
                               class="w-full px-4 py-3 {{ $plan->isPopular() ? 'bg-spotify-green hover:bg-spotify-green/90' : 'bg-gray-900 hover:bg-gray-800' }} text-white rounded-lg transition-colors font-medium text-center block">
                                Get Started
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('distribution.pricing') }}" 
                       class="text-spotify-green hover:text-spotify-green/80 font-medium">
                        View All Plans <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        @endif

        <!-- Platform Showcase -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-8 mb-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Get Your Music Everywhere
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    We distribute to all major streaming platforms and digital stores
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-6 items-center justify-items-center">
                <div class="text-center">
                    <div class="w-12 h-12 bg-[#1DB954] rounded-lg flex items-center justify-center mb-2">
                        <i class="fab fa-spotify text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Spotify</span>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#FA243C] to-[#E0245E] rounded-lg flex items-center justify-center mb-2">
                        <i class="fab fa-apple text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Apple Music</span>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-[#FF0000] rounded-lg flex items-center justify-center mb-2">
                        <i class="fab fa-youtube text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">YouTube</span>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-[#FF9500] rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-music text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Amazon</span>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-[#FF6600] rounded-lg flex items-center justify-center mb-2">
                        <i class="fab fa-soundcloud text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">SoundCloud</span>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-[#00C9FF] rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-music text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Deezer</span>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mb-2">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">150+ More</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        @if($user->hasDistributionAccess())
            <div class="grid md:grid-cols-4 gap-6">
                <a href="{{ route('distribution.create') }}" 
                   class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-upload text-spotify-green text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Upload Music</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Submit new releases</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('distribution.my-submissions') }}" 
                   class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-list text-blue-500 text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">My Releases</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Track your music</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('distribution.earnings') }}" 
                   class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-bar text-green-500 text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Earnings</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">View your royalties</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('distribution.payouts') }}" 
                   class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-money-bill-wave text-purple-500 text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Payouts</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Request payments</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection