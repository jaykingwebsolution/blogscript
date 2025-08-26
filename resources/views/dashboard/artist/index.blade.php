@extends('layouts.app')

@section('title', 'Artist Dashboard - MusicStream')

@section('content')
<div class="min-h-screen bg-black text-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-900 via-purple-900 to-gray-900 px-8 py-12">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-full">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold">Welcome, {{ Auth::user()->getDisplayName() }}</h1>
                    <p class="text-gray-300 text-xl">Artist Dashboard</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Songs</p>
                        <p class="text-3xl font-bold text-green-400">{{ $stats['total_songs'] }}</p>
                    </div>
                    <div class="bg-green-400/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Approved Songs</p>
                        <p class="text-3xl font-bold text-blue-400">{{ $stats['approved_songs'] }}</p>
                    </div>
                    <div class="bg-blue-400/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Distribution Requests</p>
                        <p class="text-3xl font-bold text-purple-400">{{ $stats['distribution_requests'] }}</p>
                    </div>
                    <div class="bg-purple-400/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Active Trending</p>
                        <p class="text-3xl font-bold text-orange-400">{{ $stats['active_trending'] }}</p>
                    </div>
                    <div class="bg-orange-400/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-8 mb-12">
            <!-- Submit Song for Distribution -->
            <div class="bg-gradient-to-br from-green-900/50 to-green-700/50 rounded-xl p-8 border border-green-700/50">
                <div class="text-center">
                    <div class="bg-green-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Submit Song for Distribution</h3>
                    <p class="text-gray-300 text-sm mb-6">Upload your music to distribute across major streaming platforms like Spotify, Apple Music, and more.</p>
                    <a href="{{ route('dashboard.artist.submit-song') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                        Submit Song
                    </a>
                </div>
            </div>

            <!-- Submit Trending Songs -->
            <div class="bg-gradient-to-br from-purple-900/50 to-purple-700/50 rounded-xl p-8 border border-purple-700/50">
                <div class="text-center">
                    <div class="bg-purple-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Submit Trending Songs</h3>
                    <p class="text-gray-300 text-sm mb-6">Request to feature your songs in trending sections for increased visibility and reach.</p>
                    <a href="{{ route('dashboard.artist.submit-trending-song') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                        Submit Trending
                    </a>
                </div>
            </div>

            <!-- Submit Trending Mixtape -->
            <div class="bg-gradient-to-br from-orange-900/50 to-orange-700/50 rounded-xl p-8 border border-orange-700/50">
                <div class="text-center">
                    <div class="bg-orange-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 7h-3V6a4 4 0 00-8 0v1H5a1 1 0 000 2h1v9a3 3 0 003 3h6a3 3 0 003-3V9h1a1 1 0 000-2zM10 6a2 2 0 014 0v1h-4V6zm5 13a1 1 0 01-1 1H9a1 1 0 01-1-1V9h7v10z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Submit Trending Mixtape</h3>
                    <p class="text-gray-300 text-sm mb-6">Submit your complete mixtape for trending consideration and promotional opportunities.</p>
                    <a href="{{ route('dashboard.artist.submit-trending-mixtape') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                        Submit Mixtape
                    </a>
                </div>
            </div>

            <!-- Artist Verification Request -->
            <div class="bg-gradient-to-br from-blue-900/50 to-blue-700/50 rounded-xl p-8 border border-blue-700/50">
                <div class="text-center">
                    <div class="bg-blue-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        @php 
                            $currentVerificationRequest = Auth::user()->verificationRequests()->where('status', 'pending')->first();
                            $hasApprovedVerification = Auth::user()->verificationRequests()->where('status', 'approved')->exists();
                        @endphp
                        
                        @if($hasApprovedVerification)
                            <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m5.414-4.414a2 2 0 00-2.828 0L10 11.172l-2.586-2.586a2 2 0 00-2.828 2.828l4 4a2 2 0 002.828 0l8-8a2 2 0 000-2.828z"/>
                            </svg>
                        @endif
                    </div>
                    
                    @if($hasApprovedVerification)
                        <h3 class="text-xl font-bold mb-2 text-blue-400">✓ Verified Artist</h3>
                        <p class="text-gray-300 text-sm mb-6">Your artist account has been verified! Enjoy enhanced features and credibility.</p>
                        <div class="bg-blue-500/20 text-blue-400 font-semibold py-3 px-6 rounded-full inline-block">
                            Verified Status
                        </div>
                    @elseif($currentVerificationRequest)
                        <h3 class="text-xl font-bold mb-2">Verification Pending</h3>
                        <p class="text-gray-300 text-sm mb-6">Your verification request is currently being reviewed. You'll be notified once processed.</p>
                        <div class="bg-yellow-500/20 text-yellow-400 font-semibold py-3 px-6 rounded-full inline-block">
                            Request Pending
                        </div>
                    @else
                        <h3 class="text-xl font-bold mb-2">Request Verification</h3>
                        <p class="text-gray-300 text-sm mb-6">Get your artist profile verified to gain credibility and access to exclusive features.</p>
                        <a href="{{ route('dashboard.verification') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                            Request Verification
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Distribution Requests -->
            <div class="bg-gray-900 rounded-xl border border-gray-800">
                <div class="p-6 border-b border-gray-800">
                    <h3 class="text-xl font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Recent Distribution Requests
                    </h3>
                </div>
                <div class="p-6">
                    @if($recentDistributions->count() > 0)
                        @foreach($recentDistributions as $request)
                        <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg mb-3 last:mb-0">
                            <div class="flex items-center space-x-4">
                                @if($request->cover_image)
                                    <img src="{{ Storage::url($request->cover_image) }}" alt="{{ $request->song_title }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold">{{ $request->song_title }}</p>
                                    <p class="text-gray-400 text-sm">{{ $request->artist_name }}</p>
                                    <p class="text-gray-500 text-xs">{{ $request->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $request->status === 'approved' ? 'bg-green-400/20 text-green-400' : 
                                   ($request->status === 'declined' ? 'bg-red-400/20 text-red-400' : 'bg-yellow-400/20 text-yellow-400') }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                        @endforeach
                        <a href="{{ route('distribution.my-submissions') }}" class="text-green-400 hover:text-green-300 text-sm font-medium inline-block mt-4">
                            View All Submissions →
                        </a>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-400">No distribution requests yet</p>
                            <p class="text-gray-500 text-sm">Submit your first song to get started</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Music -->
            <div class="bg-gray-900 rounded-xl border border-gray-800">
                <div class="p-6 border-b border-gray-800">
                    <h3 class="text-xl font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                        </svg>
                        Recent Music
                    </h3>
                </div>
                <div class="p-6">
                    @if($recentMusic->count() > 0)
                        @foreach($recentMusic as $music)
                        <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg mb-3 last:mb-0">
                            <div class="flex items-center space-x-4">
                                @if($music->cover_image)
                                    <img src="{{ Storage::url($music->cover_image) }}" alt="{{ $music->title }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold">{{ $music->title }}</p>
                                    <p class="text-gray-400 text-sm">{{ $music->genre }}</p>
                                    <p class="text-gray-500 text-xs">{{ $music->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $music->status === 'approved' ? 'bg-green-400/20 text-green-400' : 
                                   ($music->status === 'rejected' ? 'bg-red-400/20 text-red-400' : 'bg-yellow-400/20 text-yellow-400') }}">
                                {{ ucfirst($music->status ?? 'pending') }}
                            </span>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                            </svg>
                            <p class="text-gray-400">No music uploaded yet</p>
                            <p class="text-gray-500 text-sm">Upload your first song to get started</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection