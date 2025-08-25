@extends('layouts.app')

@section('title', 'MusicStream - Discover Amazing Music')

@push('styles')
<style>
    /* Spotify-like styles */
    .audio-player {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        backdrop-filter: blur(10px);
        box-shadow: 0 -8px 32px rgba(0, 0, 0, 0.3);
    }
    
    .dark .audio-player {
        background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
    }
    
    .music-card {
        transition: all 0.3s ease;
    }
    
    .music-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .dark .music-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }
    
    .play-btn {
        background: rgba(29, 185, 84, 0.9);
        backdrop-filter: blur(10px);
    }
    
    .play-btn:hover {
        background: rgba(29, 185, 84, 1);
        transform: scale(1.05);
    }
    
    .sidebar-link {
        transition: all 0.3s ease;
    }
    
    .sidebar-link:hover {
        background: rgba(29, 185, 84, 0.1);
        border-left: 4px solid #1db954;
    }
    
    .sidebar-link.active {
        background: rgba(29, 185, 84, 0.1);
        border-left: 4px solid #1db954;
        color: #1db954;
    }
    
    /* Spotify green gradient */
    .spotify-gradient {
        background: linear-gradient(135deg, #1db954 0%, #1ed760 100%);
    }
    
    /* Enhanced hover effects */
    .group:hover .group-hover\:scale-105 {
        transform: scale(1.05);
    }
    
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 pb-24">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 py-3 flex items-center justify-between">
            <button id="mobile-menu-btn" class="text-gray-600 dark:text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Music Platform</h1>
            <button id="dark-mode-toggle" class="text-gray-600 dark:text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static lg:translate-x-0 -translate-x-full transition-transform duration-300 ease-in-out z-40 w-64 h-screen bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
            <div class="p-4">
                <div class="flex items-center space-x-2 mb-8">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">MusicStream</h1>
                </div>

                <nav class="space-y-2">
                    <a href="/" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-blue-600 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-4.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                        </svg>
                        <span class="font-medium">Home</span>
                    </a>

                    <a href="{{ route('music.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                        </svg>
                        <span>Browse Music</span>
                    </a>

                    <a href="{{ route('artists.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                        <span>Artists</span>
                    </a>

                    @auth
                    <a href="{{ route('playlists.my-playlists') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                        <span>My Playlists</span>
                    </a>
                    @endauth

                    <a href="{{ route('playlists.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        <span>Trending</span>
                    </a>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Categories</p>
                        <div class="mt-2 space-y-1">
                            <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 text-sm">
                                <span>Afrobeats</span>
                            </a>
                            <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 text-sm">
                                <span>Hip Hop</span>
                            </a>
                            <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 text-sm">
                                <span>R&B</span>
                            </a>
                            <a href="#" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 text-sm">
                                <span>Pop</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-0">
            <!-- Featured Banner -->
            <section class="relative h-96 bg-gradient-to-r from-purple-600 via-pink-600 to-indigo-600 overflow-hidden">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="relative h-full flex items-center px-4 sm:px-6 lg:px-8">
                    <div class="max-w-4xl">
                        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Discover Amazing Music</h1>
                        <p class="text-xl md:text-2xl text-white/90 mb-8">Stream millions of songs, create playlists, and discover new artists</p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button class="bg-white text-gray-900 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 5v10l7-5z"/>
                                </svg>
                                Play Now
                            </button>
                            @auth
                            <a href="{{ route('playlists.create') }}" class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-gray-900 transition-colors text-center">
                                Create Playlist
                            </a>
                            @else
                            <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-gray-900 transition-colors text-center">
                                Join Now
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>

            <!-- Featured Content -->
            <section class="py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Recently Played / Featured Music -->
                    <div class="mb-12">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Featured Tracks</h2>
                            <a href="{{ route('music.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">View All</a>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                            @for($i = 1; $i <= 5; $i++)
                            <div class="music-card bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer group">
                                <div class="relative mb-4">
                                    <img src="https://via.placeholder.com/200x200/{{ ['3B82F6', 'EF4444', '10B981', 'F59E0B', '8B5CF6'][($i-1)%5] }}/FFFFFF?text=Track+{{ $i }}" 
                                         alt="Track {{ $i }}" 
                                         class="w-full aspect-square object-cover rounded-lg">
                                    <button class="play-track-btn absolute bottom-2 right-2 w-10 h-10 bg-black/70 hover:bg-black/90 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-all transform scale-90 group-hover:scale-100"
                                            data-title="Amazing Track {{ $i }}"
                                            data-artist="Artist Name {{ $i }}"
                                            data-cover="https://via.placeholder.com/200x200/{{ ['3B82F6', 'EF4444', '10B981', 'F59E0B', '8B5CF6'][($i-1)%5] }}/FFFFFF?text=Track+{{ $i }}"
                                            data-url="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-{{ $i }}.mp3">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 5v10l7-5z"/>
                                        </svg>
                                    </button>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-1 truncate">Amazing Track {{ $i }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 truncate">Artist Name {{ $i }}</p>
                                <div class="flex items-center mt-2 space-x-2">
                                    <button class="text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <button class="text-gray-400 hover:text-blue-500 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Trending Artists -->
                    <div class="mb-12">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Trending Artists</h2>
                            <a href="{{ route('artists.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">View All</a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            @for($i = 1; $i <= 6; $i++)
                            <div class="text-center group cursor-pointer">
                                <div class="relative mx-auto w-24 h-24 mb-3">
                                    <img src="https://via.placeholder.com/150x150/{{ ['8B5CF6', '06B6D4', 'F59E0B', 'EF4444', '10B981', '3B82F6'][($i-1)%6] }}/FFFFFF?text=Artist" 
                                         alt="Artist {{ $i }}" 
                                         class="w-full h-full object-cover rounded-full border-4 border-transparent group-hover:border-blue-500 transition-all">
                                    @if($i <= 3)
                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Artist Name {{ $i }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ ['Afrobeats', 'Hip Hop', 'R&B', 'Pop', 'Reggae', 'Jazz'][($i-1)%6] }}</p>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Playlists -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Popular Playlists</h2>
                            <a href="{{ route('playlists.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">View All</a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @for($i = 1; $i <= 4; $i++)
                            <div class="music-card bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer">
                                <div class="relative mb-4">
                                    <img src="https://via.placeholder.com/300x200/{{ ['667eea', 'f093fb', '4facfe', 'ffecd2'][($i-1)%4] }}/FFFFFF?text=Playlist+{{ $i }}" 
                                         alt="Playlist {{ $i }}" 
                                         class="w-full h-32 object-cover rounded-lg">
                                    <div class="absolute bottom-2 right-2 bg-black/70 text-white px-2 py-1 rounded text-xs">
                                        {{ rand(15, 50) }} songs
                                    </div>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ ['Afrobeats Hits', 'Chill Vibes', 'Workout Mix', 'Late Night R&B'][$i-1] }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ ['The hottest Afrobeats tracks', 'Relax and unwind', 'High-energy workout songs', 'Smooth R&B for late nights'][$i-1] }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500 dark:text-gray-500">by Music Lover</span>
                                    <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Play</button>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<!-- Sticky Audio Player -->
<div id="audio-player" class="audio-player fixed bottom-0 left-0 right-0 z-50 px-4 py-3 hidden">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between">
            <!-- Currently Playing -->
            <div class="flex items-center space-x-4 flex-1 min-w-0">
                <img src="https://via.placeholder.com/60x60/3B82F6/FFFFFF?text=♪" 
                     alt="Current Track" 
                     class="w-12 h-12 rounded-lg object-cover">
                <div class="min-w-0 flex-1">
                    <h4 class="text-white font-medium truncate">Amazing Track Name</h4>
                    <p class="text-white/80 text-sm truncate">Artist Name</p>
                </div>
                <button class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <!-- Controls -->
            <div class="flex items-center space-x-6 flex-1 justify-center">
                <button class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.445 14.832A1 1 0 0010 14v-2.798l5.445 3.63A1 1 0 0017 14V6a1 1 0 00-1.555-.832L10 8.798V6a1 1 0 00-1.555-.832l-6 4a1 1 0 000 1.664l6 4z"/>
                    </svg>
                </button>
                <button id="play-pause-btn" class="w-10 h-10 bg-white text-gray-900 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 5v10l7-5z"/>
                    </svg>
                </button>
                <button class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4.555 5.168A1 1 0 003 6v8a1 1 0 001.555.832L10 11.202V14a1 1 0 001.555.832l6-4a1 1 0 000-1.664l-6-4A1 1 0 0010 6v2.798L4.555 5.168z"/>
                    </svg>
                </button>
                <button class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
                <button class="text-white/80 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4z"/>
                    </svg>
                </button>
            </div>

            <!-- Volume & Options -->
            <div class="flex items-center space-x-4 flex-1 justify-end">
                <div class="hidden sm:flex items-center space-x-2">
                    <span class="text-white/80 text-sm">2:34</span>
                    <div class="w-24 bg-white/20 rounded-full h-1">
                        <div class="bg-white rounded-full h-1 w-1/3"></div>
                    </div>
                    <span class="text-white/80 text-sm">4:12</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-white/80" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.775L4.72 14.087a.5.5 0 00-.393-.17 2 2 0 01-2-2V8.083a2 2 0 012-2 .5.5 0 00.393-.17l3.663-2.688a1 1 0 01.617-.224zM13 5.5a1 1 0 011-1c2.452 0 4.441 1.89 4.441 4.221a1 1 0 11-2 0c0-1.24-.974-2.221-2.441-2.221a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="w-16 bg-white/20 rounded-full h-1">
                        <div class="bg-white rounded-full h-1 w-2/3"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mt-2">
            <div class="w-full bg-white/20 rounded-full h-1">
                <div class="bg-white rounded-full h-1 w-1/3 transition-all duration-100"></div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    mobileMenuBtn.addEventListener('click', function() {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOverlay.classList.toggle('hidden');
    });

    sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    });

    // Dark mode toggle
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const html = document.documentElement;
    
    // Check for saved dark mode preference
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    }

    darkModeToggle.addEventListener('click', function() {
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            html.classList.add('dark');
            localStorage.theme = 'dark';
        }
    });

    // Audio player functionality
    const audioPlayer = document.getElementById('audio-player');
    const playPauseBtn = document.getElementById('play-pause-btn');
    let isPlaying = false;

    // Show audio player when play button is clicked
    document.addEventListener('click', function(e) {
        if (e.target.closest('.play-btn') || e.target.closest('button[contains(text(), "Play")]')) {
            audioPlayer.classList.remove('hidden');
            isPlaying = true;
            updatePlayPauseButton();
        }
    });

    playPauseBtn.addEventListener('click', function() {
        isPlaying = !isPlaying;
        updatePlayPauseButton();
    });

    function updatePlayPauseButton() {
        playPauseBtn.innerHTML = isPlaying 
            ? '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zM11 8a1 1 0 012 0v4a1 1 0 11-2 0V8z"/></svg>'
            : '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M8 5v10l7-5z"/></svg>';
    }
});
</script>
@endpush