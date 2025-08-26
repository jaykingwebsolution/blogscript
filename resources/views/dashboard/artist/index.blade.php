@extends('layouts.artist-dashboard')

@section('dashboard-content')
<div class="p-6 space-y-8">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">
                Welcome back, {{ auth()->user()->artist_stage_name ?? auth()->user()->name }}!
            </h1>
            <p class="text-gray-300">Here's how your music is performing</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('dashboard.artist.upload-music') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-full font-medium transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                Upload Music
            </a>
            <a href="{{ route('dashboard.artist.submit-song') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full font-medium transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                Submit Distribution
            </a>
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Total Songs</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_songs'] }}</p>
                    <p class="text-sm opacity-80">{{ $stats['approved_songs'] }} approved</p>
                </div>
                <div class="bg-purple-500/30 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Distribution</h3>
                    <p class="text-3xl font-bold">{{ $stats['distribution_requests'] }}</p>
                    <p class="text-sm opacity-80">{{ $stats['pending_distribution'] }} pending</p>
                </div>
                <div class="bg-green-500/30 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Trending</h3>
                    <p class="text-3xl font-bold">{{ $stats['trending_requests'] }}</p>
                    <p class="text-sm opacity-80">{{ $stats['active_trending'] }} active</p>
                </div>
                <div class="bg-blue-500/30 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Total Plays</h3>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_plays'] ?? 0) }}</p>
                    <p class="text-sm opacity-80">This month</p>
                </div>
                <div class="bg-orange-500/30 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Upload Music -->
        <div class="bg-gradient-to-br from-purple-900/50 to-purple-700/50 rounded-xl p-8 border border-purple-700/50">
            <div class="text-center">
                <div class="bg-purple-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 3a1 1 0 011 1v8h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H8a1 1 0 110-2h3V4a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Upload New Music</h3>
                <p class="text-gray-300 text-sm mb-6">Share your latest tracks with the world and grow your fanbase.</p>
                <a href="{{ route('dashboard.artist.upload-music') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                    Upload Now
                </a>
            </div>
        </div>

        <!-- Submit for Distribution -->
        <div class="bg-gradient-to-br from-green-900/50 to-green-700/50 rounded-xl p-8 border border-green-700/50">
            <div class="text-center">
                <div class="bg-green-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Submit for Distribution</h3>
                <p class="text-gray-300 text-sm mb-6">Get your music on Spotify, Apple Music, and other major platforms.</p>
                <a href="{{ route('dashboard.artist.submit-song') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                    Submit Song
                </a>
            </div>
        </div>

        <!-- Submit Trending Songs -->
        <div class="bg-gradient-to-br from-blue-900/50 to-blue-700/50 rounded-xl p-8 border border-blue-700/50">
            <div class="text-center">
                <div class="bg-blue-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Submit Trending Songs</h3>
                <p class="text-gray-300 text-sm mb-6">Request to feature your songs in trending sections for increased visibility.</p>
                <a href="{{ route('dashboard.artist.submit-trending-song') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                    Submit Trending
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Distribution Requests -->
        <div class="bg-gray-800 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">Recent Distribution Requests</h2>
                <a href="{{ route('dashboard.artist.distribution-history') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                    View All
                </a>
            </div>

            @forelse($recentDistributions as $distribution)
            <div class="flex items-center justify-between py-3 border-b border-gray-700 last:border-0">
                <div class="flex-1">
                    <h3 class="text-white font-medium">{{ $distribution->song_title }}</h3>
                    <p class="text-gray-400 text-sm">{{ $distribution->artist_name }} • {{ $distribution->genre }}</p>
                    <p class="text-gray-500 text-xs">{{ $distribution->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $distribution->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                           ($distribution->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                           'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                        {{ ucfirst($distribution->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                <p class="text-gray-400 mb-2">No distribution requests yet</p>
                <p class="text-gray-500 text-sm">Submit your first song to get started</p>
            </div>
            @endforelse
        </div>

        <!-- Recent Music -->
        <div class="bg-gray-800 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">Your Recent Music</h2>
                <a href="{{ route('dashboard.artist.my-songs') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                    View All
                </a>
            </div>

            @forelse($recentMusic as $music)
            <div class="flex items-center py-3 border-b border-gray-700 last:border-0">
                <div class="w-12 h-12 bg-gray-600 rounded flex-shrink-0 flex items-center justify-center">
                    @if($music->cover_image)
                        <img src="{{ Storage::url($music->cover_image) }}" alt="{{ $music->title }}" class="w-full h-full object-cover rounded">
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                        </svg>
                    @endif
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-white font-medium">{{ $music->title }}</h3>
                    <p class="text-gray-400 text-sm">{{ $music->genre ?? 'No genre' }} • {{ $music->created_at->format('M j, Y') }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $music->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                           ($music->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                           'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                        {{ ucfirst($music->status) }}
                    </span>
                    <button class="text-gray-400 hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                    </button>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                </svg>
                <p class="text-gray-400 mb-2">No music uploaded yet</p>
                <p class="text-gray-500 text-sm">Start by uploading your first track</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Trending Requests -->
    @if($recentTrending->count() > 0)
    <div class="bg-gray-800 rounded-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-white">Recent Trending Requests</h2>
            <a href="{{ route('dashboard.trending') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                View All
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($recentTrending as $trending)
            <div class="bg-gray-700 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-purple-400 font-medium uppercase">{{ $trending->type }}</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                        {{ $trending->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                           ($trending->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                           'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                        {{ ucfirst($trending->status) }}
                    </span>
                </div>
                <p class="text-white text-sm mb-2">{{ Str::limit($trending->message, 100) }}</p>
                <p class="text-gray-400 text-xs">{{ $trending->created_at->diffForHumans() }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection