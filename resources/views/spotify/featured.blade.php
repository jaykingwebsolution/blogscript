@extends('layouts.app')

@section('title', 'Featured Spotify Music')

@push('styles')
<style>
    .spotify-container {
        background: linear-gradient(135deg, #1DB954 0%, #1ed760 50%, #1DB954 100%);
    }
    
    .featured-card {
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .featured-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(29, 185, 84, 0.4);
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
                <div class="w-20 h-20 mx-auto mb-6 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h1 class="text-4xl lg:text-6xl font-bold mb-4">Featured Music</h1>
                <p class="text-xl lg:text-2xl opacity-90 max-w-3xl mx-auto">
                    Handpicked tracks and albums that are making waves on Spotify
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('spotify.index') }}" 
               class="text-gray-400 hover:text-white transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to All Music
            </a>
            <span class="text-gray-600">•</span>
            <span class="text-spotify-green font-medium">Featured ({{ $featuredPosts->total() }})</span>
        </div>

        <!-- Featured Music Grid -->
        @if($featuredPosts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
                @foreach($featuredPosts as $post)
                    <div class="featured-card group bg-gradient-to-br from-gray-800/60 to-gray-900/60 rounded-xl p-6 cursor-pointer border border-gray-700/50">
                        <div class="relative mb-6">
                            <img src="{{ $post->image_url_or_default }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full aspect-square object-cover rounded-lg shadow-xl">
                            
                            <!-- Featured Badge -->
                            <div class="absolute top-3 left-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black text-xs font-bold px-3 py-1 rounded-full">
                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                FEATURED
                            </div>
                            
                            @if($post->preview_url)
                                <button class="play-btn absolute bottom-3 right-3 w-14 h-14 rounded-full flex items-center justify-center text-white shadow-xl opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300"
                                        onclick="playPreview('{{ $post->preview_url }}', '{{ $post->title }}', '{{ $post->artist_names }}')">
                                    <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 5v10l7-5z"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                        
                        <div class="space-y-2">
                            <h3 class="font-bold text-white text-lg leading-tight">{{ $post->title }}</h3>
                            <p class="text-gray-300 font-medium">{{ $post->artist_names }}</p>
                            @if($post->album_name && $post->album_name !== $post->title)
                                <p class="text-gray-400 text-sm">From "{{ $post->album_name }}"</p>
                            @endif
                            
                            <!-- Metadata -->
                            <div class="flex items-center justify-between pt-2">
                                <div class="flex items-center space-x-2">
                                    @if($post->popularity)
                                        <div class="flex items-center space-x-1">
                                            <div class="w-2 h-2 bg-spotify-green rounded-full"></div>
                                            <span class="text-xs text-gray-400">{{ $post->popularity }}% popular</span>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($post->release_date)
                                    <span class="text-xs text-gray-500">{{ $post->release_date->format('M j, Y') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-4 flex items-center justify-between opacity-0 group-hover:opacity-100 transition-all">
                            @if($post->spotify_url)
                                <a href="{{ $post->spotify_url }}" target="_blank" 
                                   class="flex items-center text-spotify-green hover:text-spotify-green-light text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.48.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                                    </svg>
                                    Open in Spotify
                                </a>
                            @endif
                            
                            <a href="{{ route('spotify.show', $post) }}" 
                               class="text-gray-400 hover:text-white text-sm font-medium">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $featuredPosts->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No Featured Music Yet</h3>
                <p class="text-gray-400 mb-6">We haven't featured any Spotify content yet.</p>
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