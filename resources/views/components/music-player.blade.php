<!-- Sticky Audio Player Component -->
<div id="music-player" class="fixed bottom-0 left-0 right-0 z-50 bg-gradient-to-r from-purple-600 via-pink-600 to-indigo-600 backdrop-filter backdrop-blur-lg bg-opacity-95 border-t border-white/10 hidden">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <!-- Desktop Layout -->
        <div class="hidden md:flex items-center justify-between">
            <!-- Currently Playing Info -->
            <div class="flex items-center space-x-4 min-w-0 flex-1">
                <img id="current-track-cover" 
                     src="{{ asset("images/default-music.svg") }}" 
                     alt="Current Track" 
                     class="w-14 h-14 rounded-lg object-cover shadow-lg">
                <div class="min-w-0 flex-1">
                    <h4 id="current-track-title" class="text-white font-medium truncate">Select a track to play</h4>
                    <p id="current-track-artist" class="text-white/80 text-sm truncate">No artist</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="like-btn" class="text-white/80 hover:text-red-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    <button id="add-to-playlist-btn" class="text-white/80 hover:text-green-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Player Controls -->
            <div class="flex items-center space-x-6 flex-1 justify-center">
                <button id="shuffle-btn" class="text-white/60 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
                <button id="prev-btn" class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.445 14.832A1 1 0 0010 14v-2.798l5.445 3.63A1 1 0 0017 14V6a1 1 0 00-1.555-.832L10 8.798V6a1 1 0 00-1.555-.832l-6 4a1 1 0 000 1.664l6 4z"/>
                    </svg>
                </button>
                <button id="play-pause-main" class="w-12 h-12 bg-white text-gray-900 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors shadow-lg">
                    <svg id="play-icon" class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 5v10l7-5z"/>
                    </svg>
                    <svg id="pause-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zM11 8a1 1 0 012 0v4a1 1 0 11-2 0V8z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <button id="next-btn" class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4.555 5.168A1 1 0 003 6v8a1 1 0 001.555.832L10 11.202V14a1 1 0 001.555.832l6-4a1 1 0 000-1.664l-6-4A1 1 0 0010 6v2.798L4.555 5.168z"/>
                    </svg>
                </button>
                <button id="repeat-btn" class="text-white/60 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>

            <!-- Volume and Options -->
            <div class="flex items-center space-x-4 flex-1 justify-end">
                <div class="flex items-center space-x-3">
                    <span id="current-time" class="text-white/80 text-sm font-mono">0:00</span>
                    <div class="w-24 bg-white/20 rounded-full h-1 relative group cursor-pointer">
                        <div id="progress-bar" class="bg-white rounded-full h-1 w-0 relative transition-all">
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                    </div>
                    <span id="total-time" class="text-white/80 text-sm font-mono">0:00</span>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="volume-btn" class="text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.775L4.72 14.087a.5.5 0 00-.393-.17 2 2 0 01-2-2V8.083a2 2 0 012-2 .5.5 0 00.393-.17l3.663-2.688a1 1 0 01.617-.224zM13 5.5a1 1 0 011-1c2.452 0 4.441 1.89 4.441 4.221a1 1 0 11-2 0c0-1.24-.974-2.221-2.441-2.221a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div class="w-20 bg-white/20 rounded-full h-1 relative group cursor-pointer">
                        <div id="volume-bar" class="bg-white rounded-full h-1 w-3/4 relative">
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                    </div>
                </div>
                <button id="queue-btn" class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Layout -->
        <div class="md:hidden">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-3 min-w-0 flex-1">
                    <img id="current-track-cover-mobile" 
                         src="{{ asset("images/default-music.svg") }}" 
                         alt="Current Track" 
                         class="w-12 h-12 rounded-lg object-cover">
                    <div class="min-w-0 flex-1">
                        <h4 id="current-track-title-mobile" class="text-white font-medium text-sm truncate">Select a track</h4>
                        <p id="current-track-artist-mobile" class="text-white/80 text-xs truncate">No artist</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="prev-btn-mobile" class="text-white/80 hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.445 14.832A1 1 0 0010 14v-2.798l5.445 3.63A1 1 0 0017 14V6a1 1 0 00-1.555-.832L10 8.798V6a1 1 0 00-1.555-.832l-6 4a1 1 0 000 1.664l6 4z"/>
                        </svg>
                    </button>
                    <button id="play-pause-mobile" class="w-10 h-10 bg-white text-gray-900 rounded-full flex items-center justify-center">
                        <svg id="play-icon-mobile" class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 5v10l7-5z"/>
                        </svg>
                        <svg id="pause-icon-mobile" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zM11 8a1 1 0 012 0v4a1 1 0 11-2 0V8z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <button id="next-btn-mobile" class="text-white/80 hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4.555 5.168A1 1 0 003 6v8a1 1 0 001.555.832L10 11.202V14a1 1 0 001.555.832l6-4a1 1 0 000-1.664l-6-4A1 1 0 0010 6v2.798L4.555 5.168z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Progress Bar -->
            <div class="flex items-center space-x-2">
                <span id="current-time-mobile" class="text-white/80 text-xs font-mono">0:00</span>
                <div class="flex-1 bg-white/20 rounded-full h-1 relative">
                    <div id="progress-bar-mobile" class="bg-white rounded-full h-1 w-0 transition-all"></div>
                </div>
                <span id="total-time-mobile" class="text-white/80 text-xs font-mono">0:00</span>
            </div>
        </div>
    </div>

    <!-- Hidden Audio Element -->
    <audio id="audio-element" preload="metadata" class="hidden"></audio>
</div>

<!-- Add to Playlist Modal -->
<div id="add-to-playlist-modal" class="fixed inset-0 bg-black bg-opacity-50 z-60 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Add to Playlist</h3>
        <div class="space-y-2 max-h-60 overflow-y-auto">
            @auth
            @if(Auth::user()->playlists->count() > 0)
                @foreach(Auth::user()->playlists as $playlist)
                <button class="add-to-playlist-item w-full text-left p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center"
                        data-playlist-id="{{ $playlist->id }}">
                    <img src="{{ $playlist->cover_image_url }}" 
                         alt="{{ $playlist->title }}" 
                         class="w-12 h-12 rounded object-cover mr-3">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $playlist->title }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $playlist->music->count() }} songs</p>
                    </div>
                </button>
                @endforeach
            @else
                <p class="text-gray-600 dark:text-gray-400 text-center py-4">No playlists yet. Create one first!</p>
            @endif
            @endauth
        </div>
        <div class="flex justify-end space-x-3 mt-6">
            <button id="close-playlist-modal" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                Cancel
            </button>
            <a href="{{ route('playlists.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Create New Playlist
            </a>
        </div>
    </div>
</div>

<script>
class MusicPlayer {
    constructor() {
        this.audio = document.getElementById('audio-element');
        this.playerContainer = document.getElementById('music-player');
        this.isPlaying = false;
        this.currentTrack = null;
        this.playlist = [];
        this.currentIndex = 0;
        this.isShuffled = false;
        this.repeatMode = 'off'; // off, one, all
        this.volume = 0.75;
        
        this.initializePlayer();
        this.bindEvents();
    }

    initializePlayer() {
        this.audio.volume = this.volume;
        
        // Update volume bar
        const volumeBar = document.getElementById('volume-bar');
        if (volumeBar) {
            volumeBar.style.width = `${this.volume * 100}%`;
        }
    }

    bindEvents() {
        // Play/Pause buttons
        const playPauseButtons = ['play-pause-main', 'play-pause-mobile'];
        playPauseButtons.forEach(id => {
            const btn = document.getElementById(id);
            if (btn) {
                btn.addEventListener('click', () => this.togglePlayPause());
            }
        });

        // Previous/Next buttons
        const prevButtons = ['prev-btn', 'prev-btn-mobile'];
        const nextButtons = ['next-btn', 'next-btn-mobile'];
        
        prevButtons.forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.addEventListener('click', () => this.previousTrack());
        });
        
        nextButtons.forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.addEventListener('click', () => this.nextTrack());
        });

        // Audio events
        this.audio.addEventListener('timeupdate', () => this.updateProgress());
        this.audio.addEventListener('ended', () => this.handleTrackEnd());
        this.audio.addEventListener('loadedmetadata', () => this.updateDuration());

        // Progress bar clicks
        const progressBars = ['progress-bar', 'progress-bar-mobile'];
        progressBars.forEach(id => {
            const progressContainer = document.getElementById(id)?.parentElement;
            if (progressContainer) {
                progressContainer.addEventListener('click', (e) => this.seekTrack(e, progressContainer));
            }
        });

        // Volume control
        const volumeContainer = document.getElementById('volume-bar')?.parentElement;
        if (volumeContainer) {
            volumeContainer.addEventListener('click', (e) => this.adjustVolume(e, volumeContainer));
        }

        // Control buttons
        const shuffleBtn = document.getElementById('shuffle-btn');
        if (shuffleBtn) shuffleBtn.addEventListener('click', () => this.toggleShuffle());
        
        const repeatBtn = document.getElementById('repeat-btn');
        if (repeatBtn) repeatBtn.addEventListener('click', () => this.toggleRepeat());

        // Like button
        const likeBtn = document.getElementById('like-btn');
        if (likeBtn) likeBtn.addEventListener('click', () => this.toggleLike());

        // Add to playlist
        const addToPlaylistBtn = document.getElementById('add-to-playlist-btn');
        if (addToPlaylistBtn) addToPlaylistBtn.addEventListener('click', () => this.showAddToPlaylistModal());

        // Modal events
        const closeModalBtn = document.getElementById('close-playlist-modal');
        if (closeModalBtn) closeModalBtn.addEventListener('click', () => this.hideAddToPlaylistModal());

        // Global play buttons
        document.addEventListener('click', (e) => {
            if (e.target.matches('.play-track-btn') || e.target.closest('.play-track-btn')) {
                e.preventDefault();
                const btn = e.target.matches('.play-track-btn') ? e.target : e.target.closest('.play-track-btn');
                const trackData = {
                    id: btn.dataset.id,
                    title: btn.dataset.title,
                    artist: btn.dataset.artist,
                    cover: btn.dataset.cover,
                    url: btn.dataset.url || 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3'
                };
                this.playTrack(trackData);
            }
        });
    }

    playTrack(track) {
        this.currentTrack = track;
        this.audio.src = track.url;
        
        // Show player
        this.playerContainer.classList.remove('hidden');
        
        // Update UI
        this.updateTrackInfo();
        this.updateLikeButtonState();
        
        // Play audio
        this.audio.play().then(() => {
            this.isPlaying = true;
            this.updatePlayButton();
        }).catch(e => console.log('Auto-play prevented:', e));
    }

    togglePlayPause() {
        if (!this.currentTrack) return;
        
        if (this.isPlaying) {
            this.audio.pause();
            this.isPlaying = false;
        } else {
            this.audio.play().then(() => {
                this.isPlaying = true;
            }).catch(e => console.log('Play prevented:', e));
        }
        
        this.updatePlayButton();
    }

    updatePlayButton() {
        const playIcons = ['play-icon', 'play-icon-mobile'];
        const pauseIcons = ['pause-icon', 'pause-icon-mobile'];
        
        playIcons.forEach(id => {
            const icon = document.getElementById(id);
            if (icon) icon.classList.toggle('hidden', this.isPlaying);
        });
        
        pauseIcons.forEach(id => {
            const icon = document.getElementById(id);
            if (icon) icon.classList.toggle('hidden', !this.isPlaying);
        });
    }

    updateTrackInfo() {
        if (!this.currentTrack) return;
        
        // Update desktop info
        const titleEl = document.getElementById('current-track-title');
        const artistEl = document.getElementById('current-track-artist');
        const coverEl = document.getElementById('current-track-cover');
        
        if (titleEl) titleEl.textContent = this.currentTrack.title;
        if (artistEl) artistEl.textContent = this.currentTrack.artist;
        if (coverEl) coverEl.src = this.currentTrack.cover;
        
        // Update mobile info
        const titleMobileEl = document.getElementById('current-track-title-mobile');
        const artistMobileEl = document.getElementById('current-track-artist-mobile');
        const coverMobileEl = document.getElementById('current-track-cover-mobile');
        
        if (titleMobileEl) titleMobileEl.textContent = this.currentTrack.title;
        if (artistMobileEl) artistMobileEl.textContent = this.currentTrack.artist;
        if (coverMobileEl) coverMobileEl.src = this.currentTrack.cover;
    }

    updateProgress() {
        if (!this.audio.duration) return;
        
        const progress = (this.audio.currentTime / this.audio.duration) * 100;
        
        const progressBars = ['progress-bar', 'progress-bar-mobile'];
        progressBars.forEach(id => {
            const bar = document.getElementById(id);
            if (bar) bar.style.width = `${progress}%`;
        });
        
        // Update time displays
        const currentTimeEls = ['current-time', 'current-time-mobile'];
        currentTimeEls.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = this.formatTime(this.audio.currentTime);
        });
    }

    updateDuration() {
        const totalTimeEls = ['total-time', 'total-time-mobile'];
        totalTimeEls.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = this.formatTime(this.audio.duration);
        });
    }

    formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${minutes}:${secs.toString().padStart(2, '0')}`;
    }

    seekTrack(event, container) {
        if (!this.audio.duration) return;
        
        const rect = container.getBoundingClientRect();
        const clickX = event.clientX - rect.left;
        const percentage = clickX / rect.width;
        const newTime = percentage * this.audio.duration;
        
        this.audio.currentTime = newTime;
    }

    adjustVolume(event, container) {
        const rect = container.getBoundingClientRect();
        const clickX = event.clientX - rect.left;
        const volume = Math.max(0, Math.min(1, clickX / rect.width));
        
        this.audio.volume = volume;
        this.volume = volume;
        
        const volumeBar = document.getElementById('volume-bar');
        if (volumeBar) volumeBar.style.width = `${volume * 100}%`;
    }

    previousTrack() {
        // Implementation for previous track
        console.log('Previous track');
    }

    nextTrack() {
        // Implementation for next track
        console.log('Next track');
    }

    handleTrackEnd() {
        console.log('Track ended');
        this.isPlaying = false;
        this.updatePlayButton();
    }

    toggleShuffle() {
        this.isShuffled = !this.isShuffled;
        const shuffleBtn = document.getElementById('shuffle-btn');
        if (shuffleBtn) {
            shuffleBtn.classList.toggle('text-blue-400', this.isShuffled);
            shuffleBtn.classList.toggle('text-white/60', !this.isShuffled);
        }
    }

    toggleRepeat() {
        const modes = ['off', 'all', 'one'];
        const currentIndex = modes.indexOf(this.repeatMode);
        this.repeatMode = modes[(currentIndex + 1) % modes.length];
        
        const repeatBtn = document.getElementById('repeat-btn');
        if (repeatBtn) {
            repeatBtn.classList.toggle('text-blue-400', this.repeatMode !== 'off');
            repeatBtn.classList.toggle('text-white/60', this.repeatMode === 'off');
        }
    }

    async updateLikeButtonState() {
        if (!this.currentTrack || !this.currentTrack.id) return;

        const likeBtn = document.getElementById('like-btn');
        if (!likeBtn) return;

        try {
            // Check if current track is liked
            const response = await fetch(`/music/${this.currentTrack.id}/like-status`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const result = await response.json();
                
                // Update UI based on like status
                if (result.liked) {
                    likeBtn.classList.add('text-red-400');
                    likeBtn.classList.remove('text-white/80');
                } else {
                    likeBtn.classList.remove('text-red-400');
                    likeBtn.classList.add('text-white/80');
                }
            }
        } catch (error) {
            console.error('Error checking like status:', error);
        }
    }

    async toggleLike() {
        if (!this.currentTrack || !this.currentTrack.id) {
            console.log('No track selected or missing track ID');
            return;
        }

        const likeBtn = document.getElementById('like-btn');
        if (!likeBtn) return;

        try {
            // Send request to backend
            const response = await fetch(`/music/${this.currentTrack.id}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const result = await response.json();
                
                // Update UI based on response
                if (result.liked) {
                    likeBtn.classList.add('text-red-400');
                    likeBtn.classList.remove('text-white/80');
                } else {
                    likeBtn.classList.remove('text-red-400');
                    likeBtn.classList.add('text-white/80');
                }
                
                console.log('Like toggled successfully');
            } else {
                console.error('Failed to toggle like');
            }
        } catch (error) {
            console.error('Error toggling like:', error);
        }
    }

    showAddToPlaylistModal() {
        const modal = document.getElementById('add-to-playlist-modal');
        if (modal) modal.classList.remove('hidden');
    }

    hideAddToPlaylistModal() {
        const modal = document.getElementById('add-to-playlist-modal');
        if (modal) modal.classList.add('hidden');
    }
}

// Initialize player when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.musicPlayer = new MusicPlayer();
});
</script>