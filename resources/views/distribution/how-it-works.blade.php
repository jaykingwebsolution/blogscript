@extends('layouts.distribution')

@section('title', 'How Music Distribution Works')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 distro-gradient rounded-full mb-6">
                <i class="fas fa-question-circle text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                How It <span class="text-spotify-green">Works</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Getting your music on every major platform is easier than you think. Follow our simple 4-step process and watch your music reach fans worldwide.
            </p>
        </div>

        <!-- Process Steps -->
        <div class="mb-16">
            <div class="relative">
                <!-- Connection Lines -->
                <div class="hidden lg:block absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-spotify-green to-distro-accent opacity-20"></div>
                
                <div class="space-y-16">
                    <!-- Step 1 -->
                    <div class="relative">
                        <div class="lg:flex lg:items-center lg:space-x-12">
                            <div class="lg:w-1/2 mb-8 lg:mb-0">
                                <div class="bg-distro-gray rounded-3xl p-8">
                                    <div class="flex items-center mb-6">
                                        <div class="flex items-center justify-center w-12 h-12 bg-spotify-green rounded-full text-white font-bold text-lg mr-4">
                                            1
                                        </div>
                                        <h3 class="text-2xl font-bold text-white">Upload Your Music</h3>
                                    </div>
                                    <p class="text-gray-300 text-lg mb-6">
                                        Upload your high-quality audio files, artwork, and metadata. Our system accepts WAV, FLAC, and high-quality MP3 files. Add your song title, artist name, genre, and release information.
                                    </p>
                                    <div class="space-y-3">
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-spotify-green mr-3"></i>
                                            Supports WAV, FLAC, and 320kbps MP3
                                        </div>
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-spotify-green mr-3"></i>
                                            3000x3000px artwork minimum
                                        </div>
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-spotify-green mr-3"></i>
                                            Comprehensive metadata fields
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:w-1/2">
                                <div class="bg-gradient-to-br from-spotify-green/20 to-distro-accent/20 rounded-3xl p-8 border border-spotify-green/30">
                                    <div class="text-center">
                                        <i class="fas fa-upload text-6xl text-spotify-green mb-6"></i>
                                        <h4 class="text-xl font-bold text-white mb-4">Easy Upload Interface</h4>
                                        <p class="text-gray-300">Drag and drop your files or browse to select them. Our system automatically validates everything.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative">
                        <div class="lg:flex lg:items-center lg:space-x-12 lg:flex-row-reverse">
                            <div class="lg:w-1/2 mb-8 lg:mb-0">
                                <div class="bg-distro-gray rounded-3xl p-8">
                                    <div class="flex items-center mb-6">
                                        <div class="flex items-center justify-center w-12 h-12 bg-distro-accent rounded-full text-white font-bold text-lg mr-4">
                                            2
                                        </div>
                                        <h3 class="text-2xl font-bold text-white">Review & Approve</h3>
                                    </div>
                                    <p class="text-gray-300 text-lg mb-6">
                                        Our team reviews your submission for quality and compliance. We check audio quality, artwork standards, and metadata accuracy. Most submissions are approved within 24 hours.
                                    </p>
                                    <div class="space-y-3">
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-distro-accent mr-3"></i>
                                            Professional quality review
                                        </div>
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-distro-accent mr-3"></i>
                                            Copyright verification
                                        </div>
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-distro-accent mr-3"></i>
                                            24-hour approval process
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:w-1/2">
                                <div class="bg-gradient-to-br from-distro-accent/20 to-purple-500/20 rounded-3xl p-8 border border-distro-accent/30">
                                    <div class="text-center">
                                        <i class="fas fa-search text-6xl text-distro-accent mb-6"></i>
                                        <h4 class="text-xl font-bold text-white mb-4">Quality Assurance</h4>
                                        <p class="text-gray-300">Our experts ensure your music meets all platform requirements before distribution.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative">
                        <div class="lg:flex lg:items-center lg:space-x-12">
                            <div class="lg:w-1/2 mb-8 lg:mb-0">
                                <div class="bg-distro-gray rounded-3xl p-8">
                                    <div class="flex items-center mb-6">
                                        <div class="flex items-center justify-center w-12 h-12 bg-yellow-500 rounded-full text-white font-bold text-lg mr-4">
                                            3
                                        </div>
                                        <h3 class="text-2xl font-bold text-white">Global Distribution</h3>
                                    </div>
                                    <p class="text-gray-300 text-lg mb-6">
                                        Once approved, your music is automatically sent to 150+ digital stores and streaming platforms worldwide. This includes Spotify, Apple Music, YouTube Music, Amazon Music, and many more.
                                    </p>
                                    <div class="space-y-3">
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-yellow-500 mr-3"></i>
                                            150+ digital platforms
                                        </div>
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-yellow-500 mr-3"></i>
                                            Worldwide availability
                                        </div>
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-yellow-500 mr-3"></i>
                                            24-48 hour delivery time
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:w-1/2">
                                <div class="bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-3xl p-8 border border-yellow-500/30">
                                    <div class="text-center">
                                        <i class="fas fa-globe text-6xl text-yellow-500 mb-6"></i>
                                        <h4 class="text-xl font-bold text-white mb-4">Worldwide Reach</h4>
                                        <p class="text-gray-300">Your music goes live on every major platform simultaneously, reaching millions of potential fans.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative">
                        <div class="lg:flex lg:items-center lg:space-x-12 lg:flex-row-reverse">
                            <div class="lg:w-1/2 mb-8 lg:mb-0">
                                <div class="bg-distro-gray rounded-3xl p-8">
                                    <div class="flex items-center mb-6">
                                        <div class="flex items-center justify-center w-12 h-12 bg-green-500 rounded-full text-white font-bold text-lg mr-4">
                                            4
                                        </div>
                                        <h3 class="text-2xl font-bold text-white">Track & Earn</h3>
                                    </div>
                                    <p class="text-gray-300 text-lg mb-6">
                                        Monitor your performance with detailed analytics and collect 100% of your royalties. Track streams, downloads, and earnings across all platforms with real-time updates.
                                    </p>
                                    <div class="space-y-3">
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-green-500 mr-3"></i>
                                            Real-time analytics dashboard
                                        </div>
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-green-500 mr-3"></i>
                                            100% royalty retention
                                        </div>
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-check text-green-500 mr-3"></i>
                                            Instant payout system
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:w-1/2">
                                <div class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-3xl p-8 border border-green-500/30">
                                    <div class="text-center">
                                        <i class="fas fa-chart-line text-6xl text-green-500 mb-6"></i>
                                        <h4 class="text-xl font-bold text-white mb-4">Analytics & Earnings</h4>
                                        <p class="text-gray-300">Get detailed insights and instant access to your earnings from every stream and download.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Showcase -->
        <div class="bg-distro-gray rounded-3xl p-8 mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">Your Music on Every Platform</h2>
                <p class="text-gray-400 text-lg">We distribute to all major platforms and many specialized stores</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center justify-items-center">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-[#1DB954] rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fab fa-spotify text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">Spotify</span>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#FA243C] to-[#E0245E] rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fab fa-apple text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">Apple Music</span>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-[#FF0000] rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fab fa-youtube text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">YouTube Music</span>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-[#FF5500] rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fab fa-soundcloud text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">SoundCloud</span>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-[#FF6600] rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fab fa-amazon text-white text-2xl"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">Amazon Music</span>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus text-white text-lg"></i>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-white">145+ More</span>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-400 text-lg">Common questions about our distribution process</p>
            </div>
            
            <div class="max-w-4xl mx-auto space-y-6" x-data="{ activeTab: 1 }">
                <div class="bg-distro-gray rounded-2xl overflow-hidden">
                    <button @click="activeTab = activeTab === 1 ? 0 : 1" 
                            class="w-full text-left p-6 flex items-center justify-between hover:bg-gray-700 transition-colors">
                        <h3 class="text-xl font-bold text-white">How long does distribution take?</h3>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform" 
                           :class="{ 'rotate-180': activeTab === 1 }"></i>
                    </button>
                    <div x-show="activeTab === 1" x-collapse class="px-6 pb-6">
                        <p class="text-gray-300">
                            Once your music is approved (usually within 24 hours), it takes 24-48 hours to go live on most platforms. Some platforms like Spotify and Apple Music are usually faster, while others may take the full 48 hours.
                        </p>
                    </div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl overflow-hidden">
                    <button @click="activeTab = activeTab === 2 ? 0 : 2" 
                            class="w-full text-left p-6 flex items-center justify-between hover:bg-gray-700 transition-colors">
                        <h3 class="text-xl font-bold text-white">Do I keep the rights to my music?</h3>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform" 
                           :class="{ 'rotate-180': activeTab === 2 }"></i>
                    </button>
                    <div x-show="activeTab === 2" x-collapse class="px-6 pb-6">
                        <p class="text-gray-300">
                            Absolutely! You retain 100% ownership of your music and rights. We only act as a distribution service - we never claim ownership of your content or take any rights from you.
                        </p>
                    </div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl overflow-hidden">
                    <button @click="activeTab = activeTab === 3 ? 0 : 3" 
                            class="w-full text-left p-6 flex items-center justify-between hover:bg-gray-700 transition-colors">
                        <h3 class="text-xl font-bold text-white">What percentage of royalties do I keep?</h3>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform" 
                           :class="{ 'rotate-180': activeTab === 3 }"></i>
                    </button>
                    <div x-show="activeTab === 3" x-collapse class="px-6 pb-6">
                        <p class="text-gray-300">
                            You keep 100% of your royalties. We don't take any percentage from your earnings - you pay a one-time distribution fee and keep everything you earn from streams and downloads.
                        </p>
                    </div>
                </div>
                
                <div class="bg-distro-gray rounded-2xl overflow-hidden">
                    <button @click="activeTab = activeTab === 4 ? 0 : 4" 
                            class="w-full text-left p-6 flex items-center justify-between hover:bg-gray-700 transition-colors">
                        <h3 class="text-xl font-bold text-white">Can I remove my music later?</h3>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform" 
                           :class="{ 'rotate-180': activeTab === 4 }"></i>
                    </button>
                    <div x-show="activeTab === 4" x-collapse class="px-6 pb-6">
                        <p class="text-gray-300">
                            Yes, you have complete control over your catalog. You can remove your music from any or all platforms at any time through your dashboard. Removal typically takes 24-48 hours to process.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-distro-gray rounded-3xl p-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Your Journey?</h2>
            <p class="text-gray-400 mb-8 max-w-2xl mx-auto">
                Join thousands of artists who have chosen our platform to distribute their music worldwide. Your fans are waiting to discover your sound.
            </p>
            
            @auth
                @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                    <a href="{{ route('distribution.create') }}" 
                       class="inline-flex items-center px-8 py-3 distro-gradient text-white font-semibold rounded-full hover:scale-105 transition-transform">
                        <i class="fas fa-upload mr-2"></i>
                        Upload Your Music Now
                    </a>
                @else
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
                        Get Started Free
                    </a>
                    <a href="{{ route('distribution.pricing') }}" 
                       class="inline-flex items-center px-8 py-3 border-2 border-gray-600 text-gray-300 font-semibold rounded-full hover:bg-gray-800 transition-colors">
                        <i class="fas fa-dollar-sign mr-2"></i>
                        View Pricing
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection