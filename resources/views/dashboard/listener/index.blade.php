@extends('layouts.listener-dashboard')

@section('dashboard-content')
<div class="p-6 space-y-8">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Good {{ $greeting }}, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-300">Welcome back to your music dashboard</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('playlists.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full font-medium transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Create Playlist
            </a>
            @if(!auth()->user()->hasActiveSubscription())
            <a href="{{ route('upgrade') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-full font-medium transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" clip-rule="evenodd"/>
                </svg>
                Upgrade Plan
            </a>
            @endif
        </div>
    </div>

    <!-- Current Plan Display -->
    @if(auth()->user()->hasActiveSubscription())
    <div class="bg-gradient-to-r from-green-900/50 to-green-700/50 border border-green-700/50 rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-green-500 p-2 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-green-300">Current Active Plan</h3>
                    <p class="text-sm text-green-200">{{ ucfirst(auth()->user()->subscription->plan_name) }} Plan</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-green-200">Expires</p>
                <p class="font-semibold text-green-300">{{ auth()->user()->subscription->expires_at->format('M j, Y') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Playlists</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_playlists'] }}</p>
                </div>
                <svg class="w-8 h-8 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                </svg>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Liked Songs</h3>
                    <p class="text-3xl font-bold">{{ $stats['liked_songs_count'] ?? 0 }}</p>
                </div>
                <svg class="w-8 h-8 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Following</h3>
                    <p class="text-3xl font-bold">{{ $stats['following_count'] ?? 0 }}</p>
                </div>
                <svg class="w-8 h-8 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                </svg>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Hours Listened</h3>
                    <p class="text-3xl font-bold">{{ $stats['hours_listened'] ?? 0 }}</p>
                </div>
                <svg class="w-8 h-8 text-orange-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.736 6.979C9.208 6.193 9.696 6 10 6s.792.193 1.264.979l1.26 2.095a1.125 1.125 0 01-.659 1.614L10 11.342 8.135 10.688a1.125 1.125 0 01-.659-1.614l1.26-2.095z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recently Played & Recommendations Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recently Played -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">Recently Played</h2>
                <a href="{{ route('dashboard.listener.history') }}" class="text-green-400 hover:text-green-300 text-sm font-medium">
                    View All
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentlyPlayed as $track)
                <div class="flex items-center p-4 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors cursor-pointer">
                    <div class="w-12 h-12 bg-gray-600 rounded flex-shrink-0 flex items-center justify-center">
                        @if($track->cover_image)
                            <img src="{{ Storage::url($track->cover_image) }}" alt="{{ $track->title }}" class="w-full h-full object-cover rounded">
                        @else
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <h4 class="text-white font-medium truncate">{{ $track->title }}</h4>
                        <p class="text-gray-400 text-sm truncate">{{ $track->artists->first()->name ?? 'Unknown Artist' }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="text-gray-400 hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <button class="text-gray-400 hover:text-red-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                    </svg>
                    <h3 class="text-gray-400 text-lg mb-2">No recent plays</h3>
                    <p class="text-gray-500">Start listening to see your activity here</p>
                    <a href="{{ route('dashboard.listener.browse') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-medium transition-colors">
                        Browse Music
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recommended for You -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">Recommended for You</h2>
                <a href="{{ route('dashboard.listener.browse') }}" class="text-green-400 hover:text-green-300 text-sm font-medium">
                    View All
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recommendations as $track)
                <div class="flex items-center p-4 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors cursor-pointer">
                    <div class="w-12 h-12 bg-gray-600 rounded flex-shrink-0 flex items-center justify-center">
                        @if($track->cover_image)
                            <img src="{{ Storage::url($track->cover_image) }}" alt="{{ $track->title }}" class="w-full h-full object-cover rounded">
                        @else
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <h4 class="text-white font-medium truncate">{{ $track->title }}</h4>
                        <p class="text-gray-400 text-sm truncate">{{ $track->artists->first()->name ?? 'Unknown Artist' }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="text-gray-400 hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <button class="text-gray-400 hover:text-red-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-gray-400 text-lg mb-2">Discovering your taste</h3>
                    <p class="text-gray-500">Like some songs to get personalized recommendations</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Your Playlists -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">Your Playlists</h2>
            <a href="{{ route('playlists.my-playlists') }}" class="text-green-400 hover:text-green-300 text-sm font-medium">
                View All
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($playlists as $playlist)
            <div class="bg-gray-800 hover:bg-gray-700 rounded-lg p-4 transition-colors cursor-pointer">
                <div class="aspect-square bg-gradient-to-br from-green-500 to-blue-600 rounded-lg mb-4 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                    </svg>
                </div>
                <h3 class="text-white font-medium text-lg mb-1 truncate">{{ $playlist->name }}</h3>
                <p class="text-gray-400 text-sm">{{ $playlist->music_count }} {{ Str::plural('song', $playlist->music_count) }}</p>
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-xs text-gray-500 capitalize">{{ $playlist->visibility }}</span>
                    <a href="{{ route('playlists.show', $playlist) }}" class="text-green-400 hover:text-green-300 text-sm">
                        View
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                </svg>
                <h3 class="text-gray-400 text-lg mb-2">No playlists yet</h3>
                <p class="text-gray-500">Create your first playlist to organize your favorite songs</p>
                <a href="{{ route('playlists.create') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-medium transition-colors">
                    Create Playlist
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Trending Now -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">Trending Now</h2>
            <a href="{{ route('dashboard.listener.trending') }}" class="text-green-400 hover:text-green-300 text-sm font-medium">
                View All
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            @forelse($trendingTracks->take(5) as $index => $track)
            <div class="bg-gray-800 hover:bg-gray-700 rounded-lg p-4 transition-colors cursor-pointer">
                <div class="relative aspect-square bg-gray-600 rounded-lg mb-3 flex items-center justify-center">
                    @if($track->cover_image)
                        <img src="{{ Storage::url($track->cover_image) }}" alt="{{ $track->title }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                        </svg>
                    @endif
                    <div class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full">
                        #{{ $index + 1 }}
                    </div>
                </div>
                <h3 class="text-white font-medium text-sm truncate">{{ $track->title }}</h3>
                <p class="text-gray-400 text-xs truncate">{{ $track->artists->first()->name ?? 'Unknown Artist' }}</p>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                </svg>
                <h3 class="text-gray-400 text-lg mb-2">No trending tracks yet</h3>
                <p class="text-gray-500">Check back later for the hottest tracks</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection