@extends('layouts.distribution')

@section('title', 'About Music Distribution')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 distro-gradient rounded-full mb-6">
                <i class="fas fa-info-circle text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                About Our <span class="text-spotify-green">Distribution Platform</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                We're revolutionizing music distribution by putting artists first. Learn about our mission, values, and commitment to your success.
            </p>
        </div>

        <!-- Mission Section -->
        <div class="bg-distro-gray rounded-3xl p-8 mb-16">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-white mb-6">Our Mission</h2>
                <p class="text-lg text-gray-300 mb-8">
                    To democratize music distribution and empower independent artists and labels to reach global audiences without compromising their rights, royalties, or creative control.
                </p>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 distro-gradient rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-handshake text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Fair Partnership</h3>
                        <p class="text-gray-400">You keep 100% of your rights and earn fair royalties from every stream and sale.</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 distro-gradient rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-rocket text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Global Reach</h3>
                        <p class="text-gray-400">Access 150+ digital platforms worldwide with lightning-fast distribution.</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 distro-gradient rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Full Control</h3>
                        <p class="text-gray-400">Maintain complete ownership and control over your music catalog and metadata.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- What Makes Us Different -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">What Makes Us Different</h2>
                <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                    We're not just another distribution service. We're your partner in building a sustainable music career.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-distro-gray rounded-2xl p-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-spotify-green/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-chart-line text-spotify-green text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-white mb-3">Transparent Analytics</h3>
                            <p class="text-gray-300">
                                Get detailed insights into your music performance across all platforms with real-time data and comprehensive reports.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-distro-accent/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-headset text-distro-accent text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-white mb-3">24/7 Support</h3>
                            <p class="text-gray-300">
                                Our dedicated support team is always here to help you succeed, whether you have technical questions or need career advice.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-bolt text-yellow-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-white mb-3">Fast Distribution</h3>
                            <p class="text-gray-300">
                                Get your music live on all major platforms within 24-48 hours, not weeks like traditional distributors.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-green-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-white mb-3">Instant Payouts</h3>
                            <p class="text-gray-300">
                                Access your earnings immediately with our instant payout system. No more waiting months for your money.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Story -->
        <div class="bg-distro-gray rounded-3xl p-8 mb-16">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-4">Our Story</h2>
                </div>
                
                <div class="prose prose-lg prose-invert mx-auto">
                    <p class="text-gray-300 leading-relaxed mb-6">
                        Founded by musicians, for musicians, our platform was born from the frustration of dealing with traditional distribution services that prioritized major labels over independent artists. We experienced firsthand the challenges of complex contracts, delayed payouts, and lack of transparency.
                    </p>
                    
                    <p class="text-gray-300 leading-relaxed mb-6">
                        In 2020, we decided to build the distribution platform we wished existed – one that treats artists as partners, not customers. Today, we've helped thousands of independent artists and labels distribute their music worldwide while maintaining full control over their careers.
                    </p>
                    
                    <p class="text-gray-300 leading-relaxed">
                        Our team combines decades of music industry experience with cutting-edge technology to deliver the best distribution experience possible. We're not just a platform; we're your partners in success.
                    </p>
                </div>
            </div>
        </div>

        <!-- Platform Stats -->
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-white mb-12">Platform Statistics</h2>
            
            <div class="grid md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="bg-distro-gray rounded-2xl p-6">
                    <div class="text-4xl font-bold text-spotify-green mb-2">150+</div>
                    <div class="text-gray-400">Digital Stores</div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-6">
                    <div class="text-4xl font-bold text-distro-accent mb-2">10K+</div>
                    <div class="text-gray-400">Active Artists</div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-6">
                    <div class="text-4xl font-bold text-yellow-500 mb-2">1M+</div>
                    <div class="text-gray-400">Songs Distributed</div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-6">
                    <div class="text-4xl font-bold text-green-500 mb-2">24-48h</div>
                    <div class="text-gray-400">Distribution Time</div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-distro-gray rounded-3xl p-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
            <p class="text-gray-400 mb-8 max-w-2xl mx-auto">
                Join thousands of artists who trust us to distribute their music worldwide. Your journey to global success starts here.
            </p>
            
            @auth
                @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                    <a href="{{ route('distribution.create') }}" 
                       class="inline-flex items-center px-8 py-3 distro-gradient text-white font-semibold rounded-full hover:scale-105 transition-transform">
                        <i class="fas fa-upload mr-2"></i>
                        Upload Your First Song
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-8 py-3 distro-gradient text-white font-semibold rounded-full hover:scale-105 transition-transform">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Artist Account
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center px-8 py-3 distro-gradient text-white font-semibold rounded-full hover:scale-105 transition-transform">
                    <i class="fas fa-rocket mr-2"></i>
                    Get Started Today
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection