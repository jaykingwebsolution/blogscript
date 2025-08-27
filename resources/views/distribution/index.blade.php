@extends('layouts.distribution')

@section('title', 'Music Distribution Platform')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 distro-gradient rounded-full mb-6">
                <i class="fas fa-music text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Get Your Music <span class="text-spotify-green">Everywhere</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-8">
                Distribute your music to 150+ digital stores worldwide including Spotify, Apple Music, YouTube Music, and more. Keep 100% of your rights and royalties.
            </p>
            
            @auth
                @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('distribution.create') }}" 
                           class="inline-flex items-center px-8 py-3 distro-gradient text-white font-semibold rounded-full hover:scale-105 transition-transform">
                            <i class="fas fa-upload mr-2"></i>
                            Upload Your Music
                        </a>
                        <a href="{{ route('distribution.my-submissions') }}" 
                           class="inline-flex items-center px-8 py-3 border-2 border-gray-600 text-gray-300 font-semibold rounded-full hover:bg-gray-800 transition-colors">
                            <i class="fas fa-list mr-2"></i>
                            My Submissions
                        </a>
                    </div>
                @else
                    <p class="text-gray-400 mb-6">Distribution is available for artists and record labels only.</p>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-8 py-3 distro-gradient text-white font-semibold rounded-full hover:scale-105 transition-transform">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Artist Account
                    </a>
                @endif
            @else
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-8 py-3 distro-gradient text-white font-semibold rounded-full hover:scale-105 transition-transform">
                        <i class="fas fa-rocket mr-2"></i>
                        Get Started Today
                    </a>
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-8 py-3 border-2 border-gray-600 text-gray-300 font-semibold rounded-full hover:bg-gray-800 transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </a>
                </div>
            @endauth
        </div>

        <!-- Streaming Platforms -->
        <div class="bg-distro-gray rounded-3xl p-8 mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Your Music on Every Platform
                </h2>
                <p class="text-gray-400 text-lg">
                    We distribute to all major streaming platforms and digital stores
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-6 items-center justify-items-center">
                <div class="text-center group hover:scale-110 transition-transform">
                    <div class="w-16 h-16 bg-[#1DB954] rounded-2xl flex items-center justify-center mb-3 group-hover:shadow-lg group-hover:shadow-green-500/25">
                        <i class="fab fa-spotify text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">Spotify</span>
                </div>
                
                <div class="text-center group hover:scale-110 transition-transform">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#FA243C] to-[#E0245E] rounded-2xl flex items-center justify-center mb-3 group-hover:shadow-lg group-hover:shadow-red-500/25">
                        <i class="fab fa-apple text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">Apple Music</span>
                </div>
                
                <div class="text-center group hover:scale-110 transition-transform">
                    <div class="w-16 h-16 bg-[#FF0000] rounded-2xl flex items-center justify-center mb-3 group-hover:shadow-lg group-hover:shadow-red-500/25">
                        <i class="fab fa-youtube text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">YouTube Music</span>
                </div>
                
                <div class="text-center group hover:scale-110 transition-transform">
                    <div class="w-16 h-16 bg-[#FF5500] rounded-2xl flex items-center justify-center mb-3 group-hover:shadow-lg group-hover:shadow-orange-500/25">
                        <i class="fab fa-soundcloud text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">SoundCloud</span>
                </div>
                
                <div class="text-center group hover:scale-110 transition-transform">
                    <div class="w-16 h-16 bg-[#1877F2] rounded-2xl flex items-center justify-center mb-3 group-hover:shadow-lg group-hover:shadow-blue-500/25">
                        <i class="fab fa-facebook text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">Facebook</span>
                </div>
                
                <div class="text-center group hover:scale-110 transition-transform">
                    <div class="w-16 h-16 bg-[#1DA1F2] rounded-2xl flex items-center justify-center mb-3 group-hover:shadow-lg group-hover:shadow-blue-400/25">
                        <i class="fab fa-twitter text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">Twitter</span>
                </div>
                
                <div class="text-center group hover:scale-110 transition-transform">
                    <div class="w-16 h-16 bg-[#FF6600] rounded-2xl flex items-center justify-center mb-3 group-hover:shadow-lg group-hover:shadow-orange-600/25">
                        <i class="fab fa-amazon text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">Amazon</span>
                </div>
                
                <div class="text-center group hover:scale-110 transition-transform">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-3 group-hover:shadow-lg group-hover:shadow-purple-500/25">
                        <i class="fas fa-plus text-white text-lg"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">150+ More</span>
                </div>
            </div>
        </div>

        @auth
            @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                <!-- User Status Dashboard -->
                <div class="bg-distro-gray rounded-3xl p-8 mb-16">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-white mb-4">Your Distribution Dashboard</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-4 gap-6">
                        <a href="{{ route('distribution.create') }}" 
                           class="bg-distro-dark rounded-xl p-6 hover:bg-gray-800 transition-colors border border-distro-border hover:border-spotify-green group">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-upload text-spotify-green text-2xl group-hover:scale-110 transition-transform"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-white">Upload Music</h3>
                                    <p class="text-gray-400 text-sm">Submit new releases</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('distribution.my-submissions') }}" 
                           class="bg-distro-dark rounded-xl p-6 hover:bg-gray-800 transition-colors border border-distro-border hover:border-distro-accent group">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-list text-distro-accent text-2xl group-hover:scale-110 transition-transform"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-white">My Submissions</h3>
                                    <p class="text-gray-400 text-sm">Track your releases</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('distribution.earnings') }}" 
                           class="bg-distro-dark rounded-xl p-6 hover:bg-gray-800 transition-colors border border-distro-border hover:border-yellow-500 group">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chart-line text-yellow-500 text-2xl group-hover:scale-110 transition-transform"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-white">Analytics</h3>
                                    <p class="text-gray-400 text-sm">View earnings & stats</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('distribution.payouts') }}" 
                           class="bg-distro-dark rounded-xl p-6 hover:bg-gray-800 transition-colors border border-distro-border hover:border-green-500 group">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-money-bill-wave text-green-500 text-2xl group-hover:scale-110 transition-transform"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-white">Payouts</h3>
                                    <p class="text-gray-400 text-sm">Request withdrawals</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        @endauth

        <!-- Features Section -->
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <div class="text-center">
                <div class="w-16 h-16 distro-gradient rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Global Distribution</h3>
                <p class="text-gray-400">Get your music on 150+ platforms worldwide with just one upload.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 distro-gradient rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-crown text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Keep 100% Rights</h3>
                <p class="text-gray-400">You maintain full ownership and control of your music and royalties.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 distro-gradient rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-bar text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Detailed Analytics</h3>
                <p class="text-gray-400">Track your streams, downloads, and earnings across all platforms.</p>
            </div>
        </div>

        <!-- Pricing Teaser -->
        @if($distributionPlans->count() > 0)
            <div class="bg-distro-gray rounded-3xl p-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Simple, Transparent Pricing</h2>
                <p class="text-gray-400 mb-8">Choose the perfect plan for your distribution needs</p>
                
                <div class="grid md:grid-cols-{{ min($distributionPlans->count(), 3) }} gap-6 max-w-4xl mx-auto mb-8">
                    @foreach($distributionPlans->take(3) as $plan)
                        <div class="bg-distro-dark rounded-xl p-6 border border-distro-border {{ $plan->isPopular() ? 'border-spotify-green' : '' }}">
                            @if($plan->isPopular())
                                <div class="bg-spotify-green text-white text-xs font-bold py-1 px-3 rounded-full inline-block mb-3">
                                    Most Popular
                                </div>
                            @endif
                            <h3 class="text-xl font-bold text-white mb-2">{{ $plan->type_display_name }}</h3>
                            <div class="text-3xl font-bold text-spotify-green mb-4">{{ $plan->formatted_price }}</div>
                            <p class="text-gray-400 text-sm">{{ $plan->description }}</p>
                        </div>
                    @endforeach
                </div>
                
                <a href="{{ route('distribution.pricing') }}" 
                   class="inline-flex items-center px-8 py-3 distro-gradient text-white font-semibold rounded-full hover:scale-105 transition-transform">
                    <i class="fas fa-arrow-right mr-2"></i>
                    View All Plans
                </a>
            </div>
        @endif
    </div>
</div>
@endsection