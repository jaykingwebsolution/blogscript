@extends('layouts.app')

@section('title', $spotifyPost->title . ' - ' . $spotifyPost->artist_names)

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(135deg, #1DB954 0%, #1ed760 50%, #1DB954 100%);
    }
    
    .play-btn {
        background: rgba(29, 185, 84, 0.9);
        backdrop-filter: blur(10px);
    }
    
    .play-btn:hover {
        background: rgba(29, 185, 84, 1);
        transform: scale(1.05);
    }
    
    .artist-tag {
        background: rgba(29, 185, 84, 0.1);
        border: 1px solid rgba(29, 185, 84, 0.3);
    }
    
    .genre-tag {
        background: rgba(147, 51, 234, 0.1);
        border: 1px solid rgba(147, 51, 234, 0.3);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-b from-spotify-dark via-gray-900 to-black">
    <!-- Hero Section -->
    <div class="hero-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/60"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 py-12 lg:py-20">
            <div class="grid lg:grid-cols-5 gap-8 lg:gap-12 items-end">
                <!-- Album Art -->
                <div class="lg:col-span-2">
                    <div class="relative group">
                        <img src="{{ $spotifyPost->image_url_or_default }}" 
                             alt="{{ $spotifyPost->title }}" 
                             class="w-full max-w-sm mx-auto lg:max-w-none aspect-square object-cover rounded-lg shadow-2xl">
                        
                        @if($spotifyPost->preview_url)
                            <button class="play-btn absolute bottom-4 right-4 w-16 h-16 rounded-full flex items-center justify-center text-white shadow-xl opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300"
                                    onclick="playPreview('{{ $spotifyPost->preview_url }}', '{{ $spotifyPost->title }}', '{{ $spotifyPost->artist_names }}')">
                                <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 5v10l7-5z"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
                
                <!-- Track Info -->
                <div class="lg:col-span-3 text-white">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="bg-black/30 text-spotify-green text-sm font-bold px-3 py-1 rounded-full backdrop-blur-sm">
                            {{ strtoupper($spotifyPost->type) }}
                        </span>
                        @if($spotifyPost->is_featured)
                            <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black text-sm font-bold px-3 py-1 rounded-full">
                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                FEATURED
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl lg:text-5xl font-bold mb-4 leading-tight">{{ $spotifyPost->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-lg mb-6">
                        <span class="font-semibold">{{ $spotifyPost->artist_names }}</span>
                        @if($spotifyPost->album_name && $spotifyPost->album_name !== $spotifyPost->title)
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-300">{{ $spotifyPost->album_name }}</span>
                        @endif
                        @if($spotifyPost->release_date)
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-300">{{ $spotifyPost->release_date->format('Y') }}</span>
                        @endif
                    </div>
                    
                    @if($spotifyPost->popularity)
                        <div class="flex items-center space-x-2 mb-6">
                            <div class="flex items-center space-x-1">
                                <div class="w-3 h-3 bg-spotify-green rounded-full"></div>
                                <span class="text-gray-300">{{ $spotifyPost->popularity }}% popularity on Spotify</span>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4">
                        @if($spotifyPost->preview_url)
                            <button onclick="playPreview('{{ $spotifyPost->preview_url }}', '{{ $spotifyPost->title }}', '{{ $spotifyPost->artist_names }}')" 
                                    class="bg-spotify-green text-white px-8 py-3 rounded-full font-semibold hover:bg-spotify-green-light transition-colors flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 5v10l7-5z"/>
                                </svg>
                                Play Preview
                            </button>
                        @endif
                        
                        @if($spotifyPost->spotify_url)
                            <a href="{{ $spotifyPost->spotify_url }}" target="_blank" 
                               class="border-2 border-white/30 text-white px-8 py-3 rounded-full font-semibold hover:border-white hover:bg-white/10 transition-all flex items-center backdrop-blur-sm">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.48.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                                </svg>
                                Open in Spotify
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Track Details -->
                @if($spotifyPost->description)
                    <div class="bg-gray-800/60 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4">About</h2>
                        <p class="text-gray-300 leading-relaxed">{{ $spotifyPost->description }}</p>
                    </div>
                @endif
                
                <!-- Artists -->
                @if($spotifyPost->artists && count($spotifyPost->artists) > 0)
                    <div class="bg-gray-800/60 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Artists</h2>
                        <div class="flex flex-wrap gap-3">
                            @foreach($spotifyPost->artists as $artist)
                                <span class="artist-tag text-spotify-green px-4 py-2 rounded-full text-sm font-medium">
                                    {{ $artist['name'] ?? 'Unknown Artist' }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Genres -->
                @if($spotifyPost->genres && count($spotifyPost->genres) > 0)
                    <div class="bg-gray-800/60 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-white mb-4">Genres</h2>
                        <div class="flex flex-wrap gap-3">
                            @foreach($spotifyPost->genres as $genre)
                                <span class="genre-tag text-purple-400 px-4 py-2 rounded-full text-sm font-medium">
                                    {{ ucfirst($genre) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Track Stats -->
                <div class="bg-gray-800/60 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Track Information</h3>
                    <div class="space-y-3">
                        @if($spotifyPost->release_date)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Release Date</span>
                                <span class="text-white">{{ $spotifyPost->release_date->format('M j, Y') }}</span>
                            </div>
                        @endif
                        
                        @if($spotifyPost->popularity)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Popularity</span>
                                <span class="text-white">{{ $spotifyPost->popularity }}%</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-gray-400">Type</span>
                            <span class="text-white">{{ ucfirst($spotifyPost->type) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-400">Source</span>
                            <span class="text-spotify-green">Spotify</span>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="bg-gray-800/60 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Explore More</h3>
                    <div class="space-y-2">
                        <a href="{{ route('spotify.index') }}" 
                           class="block text-gray-300 hover:text-spotify-green transition-colors">
                            ← Back to All Music
                        </a>
                        <a href="{{ route('spotify.featured') }}" 
                           class="block text-gray-300 hover:text-spotify-green transition-colors">
                            Browse Featured
                        </a>
                        <a href="{{ route('spotify.index', ['type' => 'track']) }}" 
                           class="block text-gray-300 hover:text-spotify-green transition-colors">
                            More Tracks
                        </a>
                    </div>
                </div>
            </div>
        </div>
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