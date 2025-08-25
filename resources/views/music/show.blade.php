@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('title', $music->title . ' - ' . ($music->artist->name ?? $music->artist_name))

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Music Header -->
    <div class="bg-gradient-to-r from-primary/10 to-accent/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:flex lg:items-center lg:space-x-8">
                <div class="flex-shrink-0">
                    <img src="{{ $music->image_url ?? '/images/default-music.jpg' }}" 
                         alt="{{ $music->title }}" 
                         class="w-64 h-64 object-cover rounded-lg shadow-lg">
                </div>
                <div class="mt-6 lg:mt-0 lg:flex-1">
                    <h1 class="text-4xl font-bold text-gray-900">{{ $music->title }}</h1>
                    <p class="text-2xl text-gray-700 mt-2">
                        @if($music->artist)
                            <a href="{{ route('artists.show', $music->artist->username) }}" class="hover:text-primary transition-colors">
                                {{ $music->artist->name }}
                            </a>
                        @else
                            {{ $music->artist_name }}
                        @endif
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-2 mt-4">
                        @if($music->category)
                            <span class="bg-white text-primary px-3 py-1 rounded-full text-sm font-medium">
                                {{ $music->category->name }}
                            </span>
                        @endif
                        @if($music->genre)
                            <span class="bg-accent text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $music->genre }}
                            </span>
                        @endif
                        @if($music->duration)
                            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm">
                                {{ $music->duration }}
                            </span>
                        @endif
                    </div>

                    @if($music->tags->count() > 0)
                        <div class="mt-4">
                            @foreach($music->tags as $tag)
                                <span class="inline-block bg-gray-700 text-white px-2 py-1 rounded-full text-xs mr-1 mb-1">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center space-x-4">
                        @auth
                            <!-- Like Button -->
                            <form method="POST" action="{{ route('music.like.toggle', $music) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center space-x-2 px-4 py-2 rounded-lg transition-colors {{ auth()->user()->hasLikedSong($music->id) ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    <svg class="w-5 h-5 {{ auth()->user()->hasLikedSong($music->id) ? 'fill-current' : '' }}" fill="{{ auth()->user()->hasLikedSong($music->id) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span>{{ auth()->user()->hasLikedSong($music->id) ? 'Liked' : 'Like' }}</span>
                                </button>
                            </form>

                            <!-- Add to Playlist Button -->
                            <button onclick="showPlaylistModal()" 
                                    class="flex items-center space-x-2 px-4 py-2 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Add to Playlist</span>
                            </button>

                            <!-- Share Button -->
                            <button onclick="shareMusic()" 
                                    class="flex items-center space-x-2 px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                </svg>
                                <span>Share</span>
                            </button>
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex items-center space-x-2 px-4 py-2 bg-spotify-green text-white hover:bg-green-600 rounded-lg transition-colors">
                                <span>Login to Like & Save</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Music Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Audio Player -->
                <x-audio-player :music="$music" />

                <!-- Music Description -->
                @if($music->description)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">About This Track</h2>
                        <div class="text-gray-700 prose max-w-none">
                            {!! nl2br(e($music->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Artist Info -->
                @if($music->artist)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Artist Information</h2>
                        <div class="flex items-center space-x-4">
                            <img src="{{ $music->artist->image_url ?? '/images/default-artist.jpg' }}" 
                                 alt="{{ $music->artist->name }}" 
                                 class="w-16 h-16 rounded-full object-cover">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('artists.show', $music->artist->username) }}" class="hover:text-primary">
                                        {{ $music->artist->name }}
                                    </a>
                                </h3>
                                @if($music->artist->genre)
                                    <p class="text-gray-600">{{ $music->artist->genre }}</p>
                                @endif
                                @if($music->artist->bio)
                                    <p class="text-gray-700 text-sm mt-2">{{ Str::limit($music->artist->bio, 200) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="mt-8 lg:mt-0">
                <!-- Related Music -->
                @if($relatedMusic->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Related Tracks</h2>
                        <div class="space-y-4">
                            @foreach($relatedMusic as $related)
                                <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                    <img src="{{ $related->image_url ?? '/images/default-music.jpg' }}" 
                                         alt="{{ $related->title }}" 
                                         class="w-12 h-12 rounded object-cover">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">
                                            <a href="{{ route('music.show', $related->slug) }}" class="hover:text-primary">
                                                {{ $related->title }}
                                            </a>
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            @if($related->artist)
                                                {{ $related->artist->name }}
                                            @else
                                                {{ $related->artist_name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('music.index') }}" class="text-primary hover:text-primary/80 font-medium">
                                Browse All Music →
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add to Playlist Modal -->
@auth
<div id="playlist-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add to Playlist</h3>
            
            <div class="max-h-60 overflow-y-auto space-y-2">
                @if(auth()->user()->playlists->count() > 0)
                    @foreach(auth()->user()->playlists as $playlist)
                        <button onclick="addToPlaylist({{ $playlist->id }})" 
                                class="w-full text-left p-3 hover:bg-gray-50 rounded-lg transition-colors flex items-center space-x-3">
                            <img src="{{ $playlist->cover_image_url }}" 
                                 alt="{{ $playlist->title }}" 
                                 class="w-10 h-10 rounded">
                            <div>
                                <div class="font-medium text-gray-900">{{ $playlist->title }}</div>
                                <div class="text-sm text-gray-500">{{ $playlist->music_count }} songs</div>
                            </div>
                        </button>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 mb-4">You don't have any playlists yet.</p>
                        <a href="{{ route('playlists.create') }}" 
                           class="bg-spotify-green text-white px-4 py-2 rounded-lg hover:bg-green-600">
                            Create Playlist
                        </a>
                    </div>
                @endif
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button onclick="hidePlaylistModal()" 
                        class="px-4 py-2 text-gray-500 hover:text-gray-700">
                    Cancel
                </button>
                <a href="{{ route('playlists.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    New Playlist
                </a>
            </div>
        </div>
    </div>
</div>
@endauth

<script>
function showPlaylistModal() {
    document.getElementById('playlist-modal').classList.remove('hidden');
}

function hidePlaylistModal() {
    document.getElementById('playlist-modal').classList.add('hidden');
}

function addToPlaylist(playlistId) {
    fetch(`/playlists/${playlistId}/add-music`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            music_id: {{ $music->id }}
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            hidePlaylistModal();
        } else {
            alert(data.message || 'Failed to add to playlist');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add to playlist');
    });
}

function shareMusic() {
    if (navigator.share) {
        navigator.share({
            title: '{{ addslashes($music->title) }}',
            text: 'Check out this song by {{ addslashes($music->artist_name ?? ($music->artist->name ?? "Unknown Artist")) }}',
            url: window.location.href
        });
    } else {
        // Fallback to copy URL
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Song URL copied to clipboard!');
        });
    }
}

// Close modal when clicking outside
document.getElementById('playlist-modal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        hidePlaylistModal();
    }
});
</script>
@endsection