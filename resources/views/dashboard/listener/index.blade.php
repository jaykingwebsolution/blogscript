@extends('layouts.app')

@section('title', 'My Music Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Here's what's happening in your music world</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_playlists'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Playlists</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_songs'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Songs in Playlists</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['public_playlists'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Public Playlists</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['hours_listened'] }}h</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Hours Listened</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- My Playlists -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">My Playlists</h2>
                        <a href="{{ route('playlists.my-playlists') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
                    </div>
                </div>
                <div class="p-6">
                    @forelse($playlists as $playlist)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex items-center">
                            <img src="{{ $playlist->cover_image_url }}" 
                                 alt="{{ $playlist->title }}" 
                                 class="w-12 h-12 rounded-lg object-cover">
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $playlist->title }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $playlist->music_count }} songs</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $playlist->visibility === 'public' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                                   ($playlist->visibility === 'private' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 
                                   'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400') }}">
                                {{ ucfirst($playlist->visibility) }}
                            </span>
                            <a href="{{ route('playlists.show', $playlist) }}" class="text-blue-600 hover:text-blue-800 text-sm">Play</a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No playlists yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first playlist.</p>
                        <div class="mt-6">
                            <a href="{{ route('playlists.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Create Playlist
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Activity</h2>
                </div>
                <div class="p-6">
                    @forelse($recentActivity as $activity)
                    <div class="flex items-center py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                @if($activity['icon'] === 'music')
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $activity['title'] }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $activity['time']->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No recent activity</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('playlists.create') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white hover:from-blue-600 hover:to-purple-700 transition-all transform hover:scale-105">
                <div class="flex items-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Create Playlist</h3>
                        <p class="text-sm opacity-90">Start curating your music</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('music.index') }}" class="bg-gradient-to-r from-green-500 to-teal-600 rounded-xl p-6 text-white hover:from-green-600 hover:to-teal-700 transition-all transform hover:scale-105">
                <div class="flex items-center">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                    </svg>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Explore Music</h3>
                        <p class="text-sm opacity-90">Discover new tracks</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('artists.index') }}" class="bg-gradient-to-r from-orange-500 to-red-600 rounded-xl p-6 text-white hover:from-orange-600 hover:to-red-700 transition-all transform hover:scale-105">
                <div class="flex items-center">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Browse Artists</h3>
                        <p class="text-sm opacity-90">Follow your favorites</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection