@extends('layouts.app')

@section('title', 'Spotify Music - Discover Latest Releases')

@push('styles')
<style>
    .spotify-container {
        background: linear-gradient(135deg, #1DB954 0%, #1ed760 50%, #1DB954 100%);
    }
    
    .music-card {
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .music-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(29, 185, 84, 0.3);
    }
    
    .play-btn {
        background: rgba(29, 185, 84, 0.9);
        backdrop-filter: blur(10px);
    }
    
    .play-btn:hover {
        background: rgba(29, 185, 84, 1);
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-b from-spotify-dark via-gray-900 to-black">
    <!-- Hero Section -->
    <div class="spotify-container relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-16 lg:py-24">
            <div class="text-center text-white">
                <div class="w-16 h-16 mx-auto mb-6 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.48.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                    </svg>
                </div>
                <h1 class="text-4xl lg:text-6xl font-bold mb-4">Discover Music from Spotify</h1>
                <p class="text-xl lg:text-2xl opacity-90 max-w-3xl mx-auto">
                    Explore curated tracks, albums, and artists imported directly from Spotify's extensive catalog
                </p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-wrap gap-4 items-center justify-between mb-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('spotify.index') }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                          {{ !request('type') ? 'bg-spotify-green text-white' : 'bg-gray-800 text-gray-300 hover:text-white' }}">
                    All
                </a>
                <a href="{{ route('spotify.index', ['type' => 'track']) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                          {{ request('type') === 'track' ? 'bg-spotify-green text-white' : 'bg-gray-800 text-gray-300 hover:text-white' }}">
                    Tracks
                </a>
                <a href="{{ route('spotify.index', ['type' => 'album']) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                          {{ request('type') === 'album' ? 'bg-spotify-green text-white' : 'bg-gray-800 text-gray-300 hover:text-white' }}">
                    Albums
                </a>
                <a href="{{ route('spotify.featured') }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors
                          {{ request()->routeIs('spotify.featured') ? 'bg-spotify-green text-white' : 'bg-gray-800 text-gray-300 hover:text-white' }}">
                    Featured
                </a>
            </div>
            
            <div class="text-gray-400 text-sm">
                {{ $spotifyPosts->total() }} tracks found
            </div>
        </div>

        <!-- Music Grid -->
        @if($spotifyPosts->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 lg:gap-6">
                @foreach($spotifyPosts as $post)
                    <div class="music-card group bg-gray-800/60 rounded-lg p-4 cursor-pointer">
                        <div class="relative mb-4">
                            <img src="{{ $post->image_url_or_default }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full aspect-square object-cover rounded-lg shadow-lg">
                            
                            @if($post->preview_url)
                                <button class="play-btn absolute bottom-2 right-2 w-12 h-12 rounded-full flex items-center justify-center text-white shadow-lg opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300"
                                        onclick="playPreview('{{ $post->preview_url }}', '{{ $post->title }}', '{{ $post->artist_names }}')">
                                    <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 5v10l7-5z"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-white mb-1 truncate text-sm">{{ $post->title }}</h3>
                            <p class="text-gray-400 text-xs truncate">{{ $post->artist_names }}</p>
                            @if($post->album_name)
                                <p class="text-gray-500 text-xs truncate mt-1">{{ $post->album_name }}</p>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-3 flex items-center justify-between opacity-0 group-hover:opacity-100 transition-opacity">
                            @if($post->spotify_url)
                                <a href="{{ $post->spotify_url }}" target="_blank" 
                                   class="text-spotify-green hover:text-spotify-green-light text-xs font-medium">
                                    Open in Spotify
                                </a>
                            @endif
                            
                            <div class="flex items-center space-x-1">
                                @if($post->popularity)
                                    <div class="text-xs text-gray-500">{{ $post->popularity }}% popular</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $spotifyPosts->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No Music Found</h3>
                <p class="text-gray-400 mb-6">We haven't imported any Spotify content yet.</p>
                @if(auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.spotify-import.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-spotify-green text-white rounded-lg font-medium hover:bg-spotify-green-light transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Import from Spotify
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Audio Preview Player -->
<div id="audio-player" class="fixed bottom-0 left-0 right-0 bg-gray-900 border-t border-gray-700 p-4 transform translate-y-full transition-transform duration-300 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <button id="play-pause-btn" class="w-10 h-10 bg-spotify-green rounded-full flex items-center justify-center text-white">
                <svg id="play-icon" class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 5v10l7-5z"/>
                </svg>
                <svg id="pause-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z"/>
                </svg>
            </button>
            <div>
                <div id="track-title" class="text-white font-medium text-sm"></div>
                <div id="track-artist" class="text-gray-400 text-xs"></div>
            </div>
        </div>
        
        <button onclick="closePlayer()" class="text-gray-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <audio id="preview-audio" preload="none"></audio>
</div>

@push('scripts')
<script>
let currentAudio = null;
let playerVisible = false;

function playPreview(url, title, artist) {
    const player = document.getElementById('audio-player');
    const audio = document.getElementById('preview-audio');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const playIcon = document.getElementById('play-icon');
    const pauseIcon = document.getElementById('pause-icon');
    const trackTitle = document.getElementById('track-title');
    const trackArtist = document.getElementById('track-artist');
    
    // Set track info
    trackTitle.textContent = title;
    trackArtist.textContent = artist;
    
    // Show player
    if (!playerVisible) {
        player.classList.remove('translate-y-full');
        playerVisible = true;
    }
    
    // Stop current audio if playing
    if (currentAudio) {
        currentAudio.pause();
    }
    
    // Set new audio
    audio.src = url;
    currentAudio = audio;
    
    // Play audio
    audio.play().then(() => {
        playIcon.classList.add('hidden');
        pauseIcon.classList.remove('hidden');
    }).catch(console.error);
    
    // Handle audio events
    audio.onended = () => {
        playIcon.classList.remove('hidden');
        pauseIcon.classList.add('hidden');
    };
    
    // Play/pause button
    playPauseBtn.onclick = () => {
        if (audio.paused) {
            audio.play();
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
        } else {
            audio.pause();
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        }
    };
}

function closePlayer() {
    const player = document.getElementById('audio-player');
    const audio = document.getElementById('preview-audio');
    
    if (currentAudio) {
        currentAudio.pause();
    }
    
    player.classList.add('translate-y-full');
    playerVisible = false;
}
</script>
@endpush
@endsection