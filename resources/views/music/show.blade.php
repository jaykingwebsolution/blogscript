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
                            @include('components.add-to-playlist-button', ['musicId' => $music->id])

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
@include('components.add-to-playlist-modal', ['musicId' => $music->id])
@endauth

<script>
function shareMusic() {
    if (navigator.share) {
        navigator.share({
            title: @json($music->title),
            text: @json('Check out this song by ' . ($music->artist_name ?? ($music->artist->name ?? 'Unknown Artist'))),
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