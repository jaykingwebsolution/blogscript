@extends('layouts.app')

@section('title', 'Your Library - MusicStream')

@push('styles')
<style>
    .play-btn {
        background: rgba(29, 185, 84, 0.9);
        backdrop-filter: blur(10px);
    }
    
    .play-btn:hover {
        background: rgba(29, 185, 84, 1);
        transform: scale(1.05);
    }
    
    .music-card {
        transition: all 0.3s ease;
    }
    
    .music-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .dark .music-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }
</style>
@endpush

@section('content')
<!-- Top Bar -->
<header class="bg-gradient-to-b from-purple-600/20 to-transparent relative z-10">
    <div class="flex items-center justify-between px-4 lg:px-8 py-4">
        <!-- Mobile menu and back/forward buttons -->
        <div class="flex items-center space-x-4">
            <div class="hidden lg:flex items-center space-x-2">
                <button onclick="history.back()" class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="history.forward()" class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Your Library</h1>
        </div>

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
</header>

<div class="flex-1 overflow-y-auto bg-gradient-to-b from-purple-600/10 via-gray-50 to-gray-50 dark:from-purple-900/10 dark:via-spotify-dark dark:to-spotify-dark">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        
        <!-- Quick Actions -->
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('dashboard.liked-songs') }}" class="group bg-gradient-to-r from-purple-600 to-purple-800 rounded-lg p-6 text-white hover:shadow-lg transition-all">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Liked Songs</h3>
                            <p class="text-white/80">{{ $likedSongs->count() }} songs</p>
                        </div>
                    </div>
                </a>
                
                @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                <a href="{{ route('artist.music.index') }}" class="group bg-gradient-to-r from-green-600 to-green-800 rounded-lg p-6 text-white hover:shadow-lg transition-all">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">My Music</h3>
                            <p class="text-white/80">{{ $uploadedMusic->count() }} tracks</p>
                        </div>
                    </div>
                </a>
                @endif
                
                <a href="{{ route('playlists.index') }}" class="group bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-6 text-white hover:shadow-lg transition-all">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Playlists</h3>
                            <p class="text-white/80">{{ $playlists->count() }} playlists</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Recently Liked Songs -->
        @if($likedSongs->count() > 0)
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Recently Liked</h2>
                <a href="{{ route('dashboard.liked-songs') }}" class="text-spotify-green hover:text-green-600 font-medium text-sm">View all</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @foreach($likedSongs->take(6) as $song)
                <div class="music-card group bg-white dark:bg-gray-800/50 rounded-lg p-4 shadow-sm hover:shadow-lg transition-all cursor-pointer">
                    <div class="relative mb-4">
                        <img src="{{ $song->cover_image ? asset('storage/' . $song->cover_image) : 'https://via.placeholder.com/200x200/3B82F6/FFFFFF?text=♪' }}" 
                             alt="{{ $song->title }}" 
                             class="w-full aspect-square object-cover rounded-lg shadow-md">
                        <button class="play-btn absolute bottom-2 right-2 w-12 h-12 bg-spotify-green rounded-full flex items-center justify-center text-white shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 5v10l7-5z"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1 truncate">{{ $song->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $song->artist->name ?? $song->user->name }}</p>
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        <!-- My Playlists -->
        @if($playlists->count() > 0)
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Playlists</h2>
                <a href="{{ route('playlists.index') }}" class="text-spotify-green hover:text-green-600 font-medium text-sm">View all</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($playlists as $playlist)
                <div class="music-card group bg-white dark:bg-gray-800/50 rounded-lg p-4 shadow-sm hover:shadow-lg transition-all cursor-pointer">
                    <div class="relative mb-4">
                        <img src="{{ $playlist->cover_image ? asset('storage/' . $playlist->cover_image) : 'https://via.placeholder.com/300x200/667eea/FFFFFF?text=Playlist' }}" 
                             alt="{{ $playlist->name }}" 
                             class="w-full h-40 object-cover rounded-lg shadow-md">
                        <button class="play-btn absolute bottom-4 right-4 w-12 h-12 bg-spotify-green rounded-full flex items-center justify-center text-white shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 5v10l7-5z"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $playlist->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ $playlist->description ?? 'Personal playlist' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">{{ $playlist->tracks->count() }} songs</p>
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        <!-- My Uploaded Music (for artists/labels) -->
        @if($uploadedMusic->count() > 0)
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Your Music</h2>
                <a href="{{ route('artist.music.index') }}" class="text-spotify-green hover:text-green-600 font-medium text-sm">Manage all</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @foreach($uploadedMusic->take(6) as $track)
                <div class="music-card group bg-white dark:bg-gray-800/50 rounded-lg p-4 shadow-sm hover:shadow-lg transition-all cursor-pointer">
                    <div class="relative mb-4">
                        <img src="{{ $track->cover_image ? asset('storage/' . $track->cover_image) : 'https://via.placeholder.com/200x200/10B981/FFFFFF?text=♪' }}" 
                             alt="{{ $track->title }}" 
                             class="w-full aspect-square object-cover rounded-lg shadow-md">
                        <button class="play-btn absolute bottom-2 right-2 w-12 h-12 bg-spotify-green rounded-full flex items-center justify-center text-white shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 5v10l7-5z"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1 truncate">{{ $track->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $track->artist->name ?? 'Your Track' }}</p>
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        <!-- Empty State -->
        @if($playlists->count() == 0 && $likedSongs->count() == 0 && $uploadedMusic->count() == 0)
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Your library is empty</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Start by exploring music, creating playlists, and liking songs you enjoy!</p>
            <div class="space-x-4">
                <a href="{{ route('music.index') }}" class="inline-flex items-center px-6 py-3 bg-spotify-green text-white font-semibold rounded-full hover:bg-green-600 transition-colors">
                    Discover Music
                </a>
                @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                <a href="{{ route('artist.music.create') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    Upload Music
                </a>
                @endif
            </div>
        </div>
        @endif
        
    </div>
</div>
@endsection