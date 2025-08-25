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
</style>
@endpush

@section('content')
<!-- Top Bar -->
<header class="bg-gradient-to-b from-black/20 to-transparent relative z-10">
    <div class="flex items-center justify-between px-4 lg:px-8 py-4">
        <!-- Mobile menu and back/forward buttons -->
        <div class="flex items-center space-x-4">
            <div class="hidden lg:flex items-center space-x-2">
                <button class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- User Actions for Authenticated Users -->
        @auth
        <div class="flex items-center space-x-4">
            <!-- Search -->
            <form method="GET" action="{{ route('search') }}" class="hidden md:flex items-center">
                <div class="relative">
                    <input type="text" 
                           name="q" 
                           placeholder="What do you want to listen to?" 
                           class="w-80 px-4 py-2 pl-10 pr-4 text-sm bg-white/10 text-white placeholder-white/70 border border-white/20 rounded-full focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </form>
            
            <!-- Dark mode toggle -->
            <button onclick="toggleDarkMode()" class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-gray-900 dark:text-white transition-colors">
                <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </button>
        </div>
        @else
        <!-- Dark mode toggle for non-authenticated users -->
        <button onclick="toggleDarkMode()" class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-gray-900 dark:text-white transition-colors">
            <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
            <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </button>
        @endauth
    </div>
</header>

<!-- Content Area -->
<div class="flex-1 overflow-y-auto bg-gradient-to-b from-purple-600/20 via-gray-50 to-gray-50 dark:from-purple-900/20 dark:via-spotify-dark dark:to-spotify-dark">
    <!-- Hero Section -->
    <section class="relative px-4 lg:px-8 py-8 lg:py-12">
        <div class="max-w-7xl mx-auto">
            <div class="text-center lg:text-left">
                <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                    Good {{ date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') }}
                    @auth, {{ auth()->user()->name }}@endauth
                </h1>
                <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-400 mb-8">
                    Discover amazing music from talented artists around the world
                </p>
            </div>
        </div>
    </section>

    <!-- Quick Access -->
    @auth
    <section class="px-4 lg:px-8 mb-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('dashboard.liked-songs') }}" class="group bg-gradient-to-r from-purple-600/20 to-purple-800/20 dark:from-purple-600/50 dark:to-purple-800/50 rounded-lg p-4 flex items-center space-x-4 cursor-pointer transition-all hover:scale-105">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded shadow-lg flex items-center justify-center">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 dark:text-white truncate">Liked Songs</h3>
                    </div>
                    <button class="w-10 h-10 bg-spotify-green rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transform scale-90 group-hover:scale-100 transition-all">
                        <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 5v10l7-5z"/>
                        </svg>
                    </button>
                </a>
                
                <a href="{{ route('music.index') }}" class="group bg-gradient-to-r from-green-600/20 to-green-800/20 dark:from-green-600/50 dark:to-green-800/50 rounded-lg p-4 flex items-center space-x-4 cursor-pointer transition-all hover:scale-105">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-green-600 to-green-800 rounded shadow-lg flex items-center justify-center">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 dark:text-white truncate">Recently Played</h3>
                    </div>
                    <button class="w-10 h-10 bg-spotify-green rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transform scale-90 group-hover:scale-100 transition-all">
                        <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 5v10l7-5z"/>
                        </svg>
                    </button>
                </a>
                
                <a href="{{ route('dashboard.library') }}" class="group bg-gradient-to-r from-blue-600/20 to-blue-800/20 dark:from-blue-600/50 dark:to-blue-800/50 rounded-lg p-4 flex items-center space-x-4 cursor-pointer transition-all hover:scale-105">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-600 to-blue-800 rounded shadow-lg flex items-center justify-center">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 dark:text-white truncate">Your Library</h3>
                    </div>
                    <button class="w-10 h-10 bg-spotify-green rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transform scale-90 group-hover:scale-100 transition-all">
                        <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 5v10l7-5z"/>
                        </svg>
                    </button>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Content Sections -->
    <div class="space-y-8 px-4 lg:px-8 pb-32">
        <div class="max-w-7xl mx-auto space-y-12">
            
            <!-- Recently Played -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Recently Played</h2>
                    <a href="{{ route('music.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium text-sm">Show all</a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    @for($i = 1; $i <= 6; $i++)
                    <div class="music-card group bg-white dark:bg-gray-800/50 rounded-lg p-4 shadow-sm hover:shadow-lg transition-all cursor-pointer">
                        <div class="relative mb-4">
                            <img src="https://via.placeholder.com/200x200/{{ ['3B82F6', 'EF4444', '10B981', 'F59E0B', '8B5CF6', '06B6D4'][($i-1)%6] }}/FFFFFF?text=Album" 
                                 alt="Album {{ $i }}" 
                                 class="w-full aspect-square object-cover rounded-lg shadow-md">
                            <button class="play-btn absolute bottom-2 right-2 w-12 h-12 bg-spotify-green rounded-full flex items-center justify-center text-white shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 5v10l7-5z"/>
                                </svg>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1 truncate">Amazing Track {{ $i }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">Artist Name {{ $i }}</p>
                    </div>
                    @endfor
                </div>
            </section>

            <!-- Popular Artists -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Popular Artists</h2>
                    <a href="{{ route('artists.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium text-sm">Show all</a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    @for($i = 1; $i <= 6; $i++)
                    <div class="group text-center cursor-pointer">
                        <div class="relative mx-auto w-32 h-32 mb-4">
                            <img src="https://via.placeholder.com/150x150/{{ ['8B5CF6', '06B6D4', 'F59E0B', 'EF4444', '10B981', '3B82F6'][($i-1)%6] }}/FFFFFF?text=Artist" 
                                 alt="Artist {{ $i }}" 
                                 class="w-full h-full object-cover rounded-full shadow-lg group-hover:shadow-xl transition-shadow">
                            <button class="play-btn absolute bottom-2 right-2 w-10 h-10 bg-spotify-green rounded-full flex items-center justify-center text-white shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                <svg class="w-4 h-4 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 5v10l7-5z"/>
                                </svg>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Artist {{ $i }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Artist</p>
                    </div>
                    @endfor
                </div>
            </section>

            <!-- Made for You -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Made for You</h2>
                    <a href="{{ route('playlists.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium text-sm">Show all</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="music-card group bg-white dark:bg-gray-800/50 rounded-lg p-4 shadow-sm hover:shadow-lg transition-all cursor-pointer">
                        <div class="relative mb-4">
                            <img src="https://via.placeholder.com/300x200/{{ ['667eea', 'f093fb', '4facfe', 'ffecd2'][($i-1)%4] }}/FFFFFF?text=Playlist" 
                                 alt="Playlist {{ $i }}" 
                                 class="w-full h-40 object-cover rounded-lg shadow-md">
                            <button class="play-btn absolute bottom-4 right-4 w-12 h-12 bg-spotify-green rounded-full flex items-center justify-center text-white shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 5v10l7-5z"/>
                                </svg>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ ['Daily Mix 1', 'Discover Weekly', 'Release Radar', 'Your Top Songs 2024'][$i-1] }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ ['Your daily mix of favorites', 'Your weekly mixtape of fresh music', 'New music from artists you follow', 'Your most played songs this year'][$i-1] }}</p>
                    </div>
                    @endfor
                </div>
            </section>

        </div>
    </div>
</div>

<!-- Sticky Audio Player -->
<div id="music-player" class="audio-player fixed bottom-0 left-0 right-0 z-50 px-4 py-3 border-t border-gray-200 dark:border-gray-700 hidden">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between">
            <!-- Currently Playing -->
            <div class="flex items-center space-x-4 flex-1 min-w-0">
                <img src="https://via.placeholder.com/60x60/1db954/FFFFFF?text=♪" 
                     alt="Current Track" 
                     class="w-14 h-14 rounded-lg object-cover shadow-lg">
                <div class="min-w-0 flex-1">
                    <h4 class="text-white font-medium truncate text-sm">Amazing Track Name</h4>
                    <p class="text-white/80 text-xs truncate">Artist Name</p>
                </div>
                <button class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <!-- Controls -->
            <div class="hidden md:flex items-center space-x-6 flex-1 justify-center">
                <button class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.445 14.832A1 1 0 0010 14v-2.798l5.445 3.63A1 1 0 0017 14V6a1 1 0 00-1.555-.832L10 8.798V6a1 1 0 00-1.555-.832l-6 4a1 1 0 000 1.664l6 4z"/>
                    </svg>
                </button>
                <button id="play-pause-btn" class="w-10 h-10 bg-white text-gray-900 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 5v10l7-5z"/>
                    </svg>
                </button>
                <button class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4.555 5.168A1 1 0 003 6v8a1 1 0 001.555.832L10 11.202V14a1 1 0 001.555.832l6-4a1 1 0 000-1.664l-6-4A1 1 0 0010 6v2.798L4.555 5.168z"/>
                    </svg>
                </button>
            </div>

            <!-- Volume & Options -->
            <div class="hidden lg:flex items-center space-x-4 flex-1 justify-end">
                <div class="flex items-center space-x-2">
                    <span class="text-white/80 text-sm">2:34</span>
                    <div class="w-24 bg-white/20 rounded-full h-1 cursor-pointer">
                        <div class="bg-white rounded-full h-1 w-1/3 transition-all"></div>
                    </div>
                    <span class="text-white/80 text-sm">4:12</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-white/80" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.775L4.72 14.087a.5.5 0 00-.393-.17 2 2 0 01-2-2V8.083a2 2 0 012-2 .5.5 0 00.393-.17l3.663-2.688a1 1 0 01.617-.224zM13 5.5a1 1 0 011-1c2.452 0 4.441 1.89 4.441 4.221a1 1 0 11-2 0c0-1.24-.974-2.221-2.441-2.221a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="w-16 bg-white/20 rounded-full h-1 cursor-pointer">
                        <div class="bg-white rounded-full h-1 w-2/3 transition-all"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize audio player functionality
    const musicPlayer = document.getElementById('music-player');
    const playPauseBtn = document.getElementById('play-pause-btn');
    let isPlaying = false;

    // Show music player when play button is clicked
    document.addEventListener('click', function(e) {
        if (e.target.closest('.play-btn')) {
            musicPlayer.classList.remove('hidden');
            isPlaying = true;
            updatePlayPauseButton();
        }
    });

    if (playPauseBtn) {
        playPauseBtn.addEventListener('click', function() {
            isPlaying = !isPlaying;
            updatePlayPauseButton();
        });
    }

    function updatePlayPauseButton() {
        if (playPauseBtn) {
            playPauseBtn.innerHTML = isPlaying 
                ? '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zM11 8a1 1 0 012 0v4a1 1 0 11-2 0V8z"/></svg>'
                : '<svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M8 5v10l7-5z"/></svg>';
        }
    }
});
</script>
@endpush