@extends('layouts.app')

@section('title', $artist->name . ' - Artist Profile')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Artist Header -->
    <div class="bg-gradient-to-r from-primary/10 to-accent/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:flex lg:items-center lg:space-x-8">
                <div class="flex-shrink-0">
                    <img src="{{ $artist->image_url ?? '/images/default-artist.jpg' }}" 
                         alt="{{ $artist->name }}" 
                         class="w-64 h-64 object-cover rounded-full shadow-lg">
                </div>
                <div class="mt-6 lg:mt-0 lg:flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-4xl font-bold text-gray-900">{{ $artist->name }}</h1>
                        @if($artist->is_trending)
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">
                                🔥 Trending
                            </span>
                        @endif
                    </div>
                    
                    @if($artist->username)
                        <p class="text-lg text-gray-600 mb-2">@{{ $artist->username }}</p>
                    @endif
                    
                    <div class="flex flex-wrap items-center gap-2 mt-4">
                        @if($artist->genre)
                            <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $artist->genre }}
                            </span>
                        @endif
                        @if($artist->country)
                            <span class="bg-accent text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $artist->country }}
                            </span>
                        @endif
                        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm">
                            {{ $musicCount }} Track{{ $musicCount !== 1 ? 's' : '' }}
                        </span>
                    </div>

                    <!-- Social Links -->
                    @if($artist->social_links && count($artist->social_links) > 0)
                        <div class="mt-6 flex space-x-4">
                            @foreach($artist->social_links as $platform => $link)
                                <a href="{{ $link }}" target="_blank" 
                                   class="bg-white text-gray-700 hover:text-primary px-4 py-2 rounded-lg shadow hover:shadow-md transition-all">
                                    {{ ucfirst($platform) }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Artist Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Bio -->
                @if($artist->bio)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Biography</h2>
                        <div class="text-gray-700 prose max-w-none">
                            {!! nl2br(e($artist->bio)) !!}
                        </div>
                    </div>
                @endif

                <!-- Music -->
                @if($artist->music && $artist->music->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Music</h2>
                            @if($musicCount > 6)
                                <a href="{{ route('music.index', ['search' => $artist->name]) }}" 
                                   class="text-primary hover:text-primary/80 font-medium">
                                    View All ({{ $musicCount }}) →
                                </a>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($artist->music->take(6) as $music)
                                <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                    <img src="{{ $music->image_url ?? '/images/default-music.jpg' }}" 
                                         alt="{{ $music->title }}" 
                                         class="w-16 h-16 rounded object-cover">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">
                                            <a href="{{ route('music.show', $music->slug) }}" class="hover:text-primary">
                                                {{ $music->title }}
                                            </a>
                                        </h4>
                                        @if($music->genre)
                                            <p class="text-sm text-gray-600">{{ $music->genre }}</p>
                                        @endif
                                        @if($music->category)
                                            <p class="text-xs text-gray-500">{{ $music->category->name }}</p>
                                        @endif
                                    </div>
                                    @if($music->audio_url)
                                        <button onclick="playMusic(@json($music->audio_url))" 
                                                class="bg-primary text-white p-2 rounded-full hover:bg-primary/90 transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="mt-8 lg:mt-0 space-y-6">
                <!-- Stats -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Artist Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Tracks</span>
                            <span class="font-semibold text-gray-900">{{ $musicCount }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="font-semibold {{ $artist->is_trending ? 'text-red-600' : 'text-green-600' }}">
                                {{ $artist->is_trending ? 'Trending' : 'Active' }}
                            </span>
                        </div>
                        @if($artist->country)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Country</span>
                                <span class="font-semibold text-gray-900">{{ $artist->country }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                @if($artist->music && $artist->music->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Latest Release</h3>
                        @php $latestTrack = $artist->music->first(); @endphp
                        <div class="flex items-center space-x-3">
                            <img src="{{ $latestTrack->image_url ?? '/images/default-music.jpg' }}" 
                                 alt="{{ $latestTrack->title }}" 
                                 class="w-12 h-12 rounded object-cover">
                            <div>
                                <h4 class="font-medium text-gray-900">
                                    <a href="{{ route('music.show', $latestTrack->slug) }}" class="hover:text-primary">
                                        {{ $latestTrack->title }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600">{{ $latestTrack->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function playMusic(audioUrl) {
    // You can implement a global audio player here
    const audio = new Audio(audioUrl);
    audio.play();
}
</script>
@endsection