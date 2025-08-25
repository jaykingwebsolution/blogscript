@extends('layouts.app')

@section('title', 'Playlists - Discover Amazing Playlists')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Playlists</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Discover curated playlists from the community</p>
            </div>
            @auth
            <a href="{{ route('playlists.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Playlist
            </a>
            @endauth
        </div>

        <!-- Featured Playlists -->
        @if($featuredPlaylists->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Featured Playlists</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredPlaylists as $playlist)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ $playlist->cover_image_url }}" 
                             alt="{{ $playlist->title }}" 
                             class="w-full h-48 object-cover rounded-t-xl">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $playlist->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($playlist->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-500">
                                <span>by {{ $playlist->user->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $playlist->music_count }} songs</span>
                            </div>
                            <a href="{{ route('playlists.show', $playlist) }}" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- All Playlists -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">All Playlists</h2>
            
            @if($playlists->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($playlists as $playlist)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="aspect-w-1 aspect-h-1">
                        <img src="{{ $playlist->cover_image_url }}" 
                             alt="{{ $playlist->title }}" 
                             class="w-full h-48 object-cover rounded-t-xl">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 truncate">{{ $playlist->title }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($playlist->description, 80) }}</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-500">{{ $playlist->music_count }} songs</span>
                            <a href="{{ route('playlists.show', $playlist) }}" class="text-blue-600 hover:text-blue-800 font-medium">Play</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $playlists->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No playlists</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new playlist.</p>
                @auth
                <div class="mt-6">
                    <a href="{{ route('playlists.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Create Playlist
                    </a>
                </div>
                @endauth
            </div>
            @endif
        </div>
    </div>
</div>
@endsection