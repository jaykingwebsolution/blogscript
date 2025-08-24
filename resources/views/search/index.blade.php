@extends('layouts.app')

@section('title', $query ? 'Search results for "' . $query . '"' : 'Search')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Search Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">
                    @if($query)
                        Search Results
                    @else
                        Search BlogScript
                    @endif
                </h1>
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('search') }}" class="max-w-2xl mx-auto">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="text" 
                               name="q" 
                               placeholder="Search music, artists, videos, or posts..." 
                               value="{{ $query }}"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-lg">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary/90 transition-colors font-semibold">
                            <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search
                        </button>
                    </div>
                </form>
                
                @if($query)
                    <p class="text-gray-600 mt-4">
                        Showing results for "<strong>{{ $query }}</strong>"
                        @if($counts['total'] > 0)
                            ({{ number_format($counts['total']) }} {{ $counts['total'] === 1 ? 'result' : 'results' }})
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>

    @if($query)
        <!-- Filter Tabs -->
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap gap-1">
                    <a href="{{ route('search', ['q' => $query, 'type' => 'all']) }}" 
                       class="px-4 py-3 text-sm font-medium border-b-2 {{ $type === 'all' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        All ({{ number_format($counts['total']) }})
                    </a>
                    <a href="{{ route('search', ['q' => $query, 'type' => 'music']) }}" 
                       class="px-4 py-3 text-sm font-medium border-b-2 {{ $type === 'music' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Music ({{ number_format($counts['music']) }})
                    </a>
                    <a href="{{ route('search', ['q' => $query, 'type' => 'artists']) }}" 
                       class="px-4 py-3 text-sm font-medium border-b-2 {{ $type === 'artists' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Artists ({{ number_format($counts['artists']) }})
                    </a>
                    <a href="{{ route('search', ['q' => $query, 'type' => 'videos']) }}" 
                       class="px-4 py-3 text-sm font-medium border-b-2 {{ $type === 'videos' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Videos ({{ number_format($counts['videos']) }})
                    </a>
                    <a href="{{ route('search', ['q' => $query, 'type' => 'posts']) }}" 
                       class="px-4 py-3 text-sm font-medium border-b-2 {{ $type === 'posts' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        Posts ({{ number_format($counts['posts']) }})
                    </a>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if($results->count() > 0)
                <div class="space-y-6">
                    @foreach($results as $result)
                        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start space-x-4">
                                @if($result->type === 'music')
                                    <img src="{{ $result->image_url ?? '/images/default-music.jpg' }}" 
                                         alt="{{ $result->title }}" 
                                         class="w-16 h-16 rounded object-cover flex-shrink-0">
                                @elseif($result->type === 'artist')
                                    <img src="{{ $result->image_url ?? '/images/default-artist.jpg' }}" 
                                         alt="{{ $result->name }}" 
                                         class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                                @elseif($result->type === 'video')
                                    <img src="{{ $result->thumbnail_url ?? '/images/default-video.jpg' }}" 
                                         alt="{{ $result->title }}" 
                                         class="w-16 h-12 rounded object-cover flex-shrink-0">
                                @elseif($result->type === 'post')
                                    <img src="{{ $result->image_url ?? '/images/default-post.jpg' }}" 
                                         alt="{{ $result->title }}" 
                                         class="w-16 h-12 rounded object-cover flex-shrink-0">
                                @endif
                                
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="inline-block bg-{{ $result->type === 'music' ? 'blue' : ($result->type === 'artist' ? 'green' : ($result->type === 'video' ? 'red' : 'purple')) }}-100 text-{{ $result->type === 'music' ? 'blue' : ($result->type === 'artist' ? 'green' : ($result->type === 'video' ? 'red' : 'purple')) }}-800 px-2 py-1 rounded text-xs font-medium capitalize">
                                            {{ $result->type }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                        <a href="{{ $result->url }}" class="hover:text-primary transition-colors">
                                            @if($result->type === 'artist')
                                                {{ $result->name }}
                                            @else
                                                {{ $result->title }}
                                            @endif
                                        </a>
                                    </h3>
                                    
                                    @if($result->type === 'music')
                                        <p class="text-gray-600 text-sm mb-1">
                                            by {{ $result->artist->name ?? $result->artist_name }}
                                            @if($result->genre)
                                                • {{ $result->genre }}
                                            @endif
                                        </p>
                                        @if($result->description)
                                            <p class="text-gray-700 text-sm">{{ Str::limit($result->description, 120) }}</p>
                                        @endif
                                    @elseif($result->type === 'artist')
                                        <p class="text-gray-600 text-sm mb-1">
                                            @if($result->genre){{ $result->genre }}@endif
                                            @if($result->country) • {{ $result->country }}@endif
                                        </p>
                                        @if($result->bio)
                                            <p class="text-gray-700 text-sm">{{ Str::limit($result->bio, 120) }}</p>
                                        @endif
                                    @elseif($result->type === 'video')
                                        @if($result->category)
                                            <p class="text-gray-600 text-sm mb-1">{{ $result->category->name }}</p>
                                        @endif
                                        @if($result->description)
                                            <p class="text-gray-700 text-sm">{{ Str::limit($result->description, 120) }}</p>
                                        @endif
                                    @elseif($result->type === 'post')
                                        @if($result->creator)
                                            <p class="text-gray-600 text-sm mb-1">
                                                by {{ $result->creator->name }}
                                                @if($result->published_at)
                                                    • {{ $result->published_at->format('M d, Y') }}
                                                @endif
                                            </p>
                                        @endif
                                        @if($result->excerpt)
                                            <p class="text-gray-700 text-sm">{{ Str::limit($result->excerpt, 120) }}</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No results found</h3>
                    <p class="mt-1 text-gray-500">No content matches your search for "{{ $query }}". Try different keywords or browse our categories.</p>
                    <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('music.index') }}" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                            Browse Music
                        </a>
                        <a href="{{ route('artists.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            Browse Artists
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @else
        <!-- Search Suggestions -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Explore our content</h2>
                <p class="text-gray-600">Search through our extensive collection of music, artists, videos, and posts</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('music.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all group">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm12-3c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Music</h3>
                        <p class="text-gray-600 text-sm">Discover the latest songs and albums</p>
                    </div>
                </a>
                
                <a href="{{ route('artists.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all group">
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                            <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Artists</h3>
                        <p class="text-gray-600 text-sm">Explore talented artists and creators</p>
                    </div>
                </a>
                
                <a href="{{ route('videos.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all group">
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-red-200 transition-colors">
                            <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Videos</h3>
                        <p class="text-gray-600 text-sm">Watch music videos and exclusive content</p>
                    </div>
                </a>
                
                <a href="{{ route('posts.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all group">
                    <div class="text-center">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-colors">
                            <svg class="w-8 h-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Blog & News</h3>
                        <p class="text-gray-600 text-sm">Read the latest entertainment news</p>
                    </div>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection