@extends('layouts.app')

@section('title', 'Liked Songs - MusicStream')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-spotify-black to-gray-900">
    <!-- Header -->
    <div class="bg-gradient-to-b from-purple-800 to-spotify-black p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-end space-x-6">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-400 to-pink-600 rounded-lg flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-white/60 text-sm font-medium mb-2">PLAYLIST</p>
                    <h1 class="text-white font-bold text-5xl md:text-7xl mb-4">Liked Songs</h1>
                    <div class="flex items-center text-white/60 text-sm">
                        <span>{{ auth()->user()->getDisplayName() }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $likedSongs->total() }} songs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto p-8">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($likedSongs->count() > 0)
            <!-- Action Buttons -->
            <div class="flex items-center space-x-4 mb-8">
                <button onclick="playAllLikedSongs()" 
                        class="bg-spotify-green text-black rounded-full p-4 hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </button>
                
                <button onclick="shufflePlayLikedSongs()" 
                        class="text-white/60 hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 6l-10 6L2 6"/>
                    </svg>
                </button>

                <form method="POST" action="{{ route('music.liked.clear') }}" class="inline" 
                      onsubmit="return confirm('Are you sure you want to remove all liked songs?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="text-white/60 hover:text-red-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Songs List -->
            <div class="space-y-1">
                <!-- Header Row -->
                <div class="grid grid-cols-12 gap-4 px-4 py-2 text-white/60 text-sm font-medium border-b border-white/10">
                    <div class="col-span-1">#</div>
                    <div class="col-span-6">TITLE</div>
                    <div class="col-span-2">ALBUM</div>
                    <div class="col-span-2">DATE ADDED</div>
                    <div class="col-span-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Song Rows -->
                @foreach($likedSongs as $index => $song)
                    <div class="group grid grid-cols-12 gap-4 px-4 py-2 hover:bg-white/10 rounded-lg transition-colors">
                        <div class="col-span-1 flex items-center">
                            <span class="group-hover:hidden text-white/60">{{ $likedSongs->firstItem() + $index }}</span>
                            <button class="hidden group-hover:block text-white hover:text-spotify-green play-track-btn" 
                                    data-id="{{ $song->id }}"
                                    data-title="{{ $song->title }}"
                                    data-artist="{{ $song->artist_name ?? ($song->artist->name ?? 'Unknown Artist') }}"
                                    data-cover="{{ $song->cover_image ? asset('storage/' . $song->cover_image) : asset('images/default-music.svg') }}"
                                    data-url="{{ $song->audio_url ?? ($song->audio_file ? asset('storage/' . $song->audio_file) : '') }}"
                                    onclick="playSong({{ $song->id }})">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="col-span-6 flex items-center space-x-3">
                            <img src="{{ $song->cover_image ? asset('storage/' . $song->cover_image) : 'asset("images/default-music.svg")' }}" 
                                 alt="{{ $song->title }}" 
                                 class="w-10 h-10 rounded">
                            <div>
                                <div class="text-white font-medium">{{ $song->title }}</div>
                                <div class="text-white/60 text-sm">{{ $song->artist_name ?? ($song->artist->name ?? 'Unknown Artist') }}</div>
                            </div>
                        </div>

                        <div class="col-span-2 flex items-center">
                            <span class="text-white/60 text-sm">{{ $song->category->name ?? 'Unknown' }}</span>
                        </div>

                        <div class="col-span-2 flex items-center">
                            <span class="text-white/60 text-sm">{{ $song->pivot->created_at->format('M d, Y') }}</span>
                        </div>

                        <div class="col-span-1 flex items-center space-x-2">
                            <form method="POST" action="{{ route('music.like.toggle', $song) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="text-spotify-green hover:text-green-400 transition-colors"
                                        title="Remove from liked songs">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>
                            </form>
                            <span class="text-white/60 text-sm">{{ $song->duration && is_numeric($song->duration) ? gmdate('i:s', (int)$song->duration) : '0:00' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($likedSongs->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $likedSongs->links() }}
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-white/40" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-4">Songs you like will appear here</h2>
                <p class="text-white/60 mb-8 max-w-md mx-auto">
                    Save songs by tapping the heart icon. Start exploring music to find your favorites!
                </p>
                <a href="{{ route('music.index') }}" 
                   class="bg-white text-black font-semibold py-3 px-8 rounded-full hover:scale-105 transition-transform inline-block">
                    Browse Music
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function playSong(songId) {
    const songElement = document.querySelector(`[data-id="${songId}"]`);
    if (songElement && window.musicPlayer) {
        const trackData = {
            id: songElement.dataset.id,
            title: songElement.dataset.title,
            artist: songElement.dataset.artist,
            cover: songElement.dataset.cover,
            url: songElement.dataset.url || 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3'
        };
        window.musicPlayer.playTrack(trackData);
    } else {
        console.log('Playing song:', songId);
    }
}

function playAllLikedSongs() {
    const likedSongs = [];
    document.querySelectorAll('.play-track-btn').forEach(btn => {
        likedSongs.push({
            id: btn.dataset.id,
            title: btn.dataset.title,
            artist: btn.dataset.artist,
            cover: btn.dataset.cover,
            url: btn.dataset.url || 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3'
        });
    });
    
    if (likedSongs.length > 0 && window.musicPlayer) {
        window.musicPlayer.playTrack(likedSongs[0]);
        console.log('Playing all liked songs starting with:', likedSongs[0].title);
    }
}

function shufflePlayLikedSongs() {
    const likedSongs = [];
    document.querySelectorAll('.play-track-btn').forEach(btn => {
        likedSongs.push({
            id: btn.dataset.id,
            title: btn.dataset.title,
            artist: btn.dataset.artist,
            cover: btn.dataset.cover,
            url: btn.dataset.url || 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3'
        });
    });
    
    // Shuffle the array
    for (let i = likedSongs.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [likedSongs[i], likedSongs[j]] = [likedSongs[j], likedSongs[i]];
    }
    
    if (likedSongs.length > 0 && window.musicPlayer) {
        window.musicPlayer.playTrack(likedSongs[0]);
        console.log('Shuffle playing liked songs starting with:', likedSongs[0].title);
    }
}
</script>
@endsection