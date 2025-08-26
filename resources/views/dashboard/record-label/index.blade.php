@extends('layouts.app')

@section('title', 'Record Label Dashboard - MusicStream')

@section('content')
<div class="min-h-screen bg-black text-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-900 via-blue-900 to-gray-900 px-8 py-12">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-4 rounded-full">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold">Welcome, {{ Auth::user()->getDisplayName() }}</h1>
                    <p class="text-gray-300 text-xl">Record Label Dashboard</p>
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
                        <p class="text-gray-400 text-sm">Total Artists</p>
                        <p class="text-3xl font-bold text-blue-400">{{ $stats['total_artists'] }}</p>
                    </div>
                    <div class="bg-blue-400/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

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
                        <p class="text-gray-400 text-sm">Approved Distribution</p>
                        <p class="text-3xl font-bold text-orange-400">{{ $stats['approved_distribution'] }}</p>
                    </div>
                    <div class="bg-orange-400/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Submit Song -->
            <div class="bg-gradient-to-br from-green-900/50 to-green-700/50 rounded-xl p-8 border border-green-700/50">
                <div class="text-center">
                    <div class="bg-green-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Submit Song</h3>
                    <p class="text-gray-300 text-sm mb-6">Upload and distribute songs for your artists across major streaming platforms worldwide.</p>
                    <a href="{{ route('dashboard.record-label.submit-song') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                        Submit Song
                    </a>
                </div>
            </div>

            <!-- Create Artist -->
            <div class="bg-gradient-to-br from-blue-900/50 to-blue-700/50 rounded-xl p-8 border border-blue-700/50">
                <div class="text-center">
                    <div class="bg-blue-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Create Artist</h3>
                    <p class="text-gray-300 text-sm mb-6">Add new artists to your record label and manage their profiles and releases.</p>
                    <a href="{{ route('dashboard.record-label.create-artist') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                        Create Artist
                    </a>
                </div>
            </div>

            <!-- Record Label Verification Request -->
            <div class="bg-gradient-to-br from-purple-900/50 to-purple-700/50 rounded-xl p-8 border border-purple-700/50">
                <div class="text-center">
                    <div class="bg-purple-400/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        @php 
                            $currentVerificationRequest = Auth::user()->verificationRequests()->where('status', 'pending')->first();
                            $hasApprovedVerification = Auth::user()->verificationRequests()->where('status', 'approved')->exists();
                        @endphp
                        
                        @if($hasApprovedVerification)
                            <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/>
                            </svg>
                        @endif
                    </div>
                    
                    @if($hasApprovedVerification)
                        <h3 class="text-xl font-bold mb-2 text-purple-400">✓ Verified Label</h3>
                        <p class="text-gray-300 text-sm mb-6">Your record label has been verified! Enjoy enhanced credibility and exclusive features.</p>
                        <div class="bg-purple-500/20 text-purple-400 font-semibold py-3 px-6 rounded-full inline-block">
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
                        <p class="text-gray-300 text-sm mb-6">Get your record label verified to gain credibility and access to enhanced distribution features.</p>
                        <a href="{{ route('dashboard.verification') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block">
                            Request Verification
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Distribution Requests -->
            <div class="bg-gray-900 rounded-xl border border-gray-800">
                <div class="p-6 border-b border-gray-800">
                    <h3 class="text-xl font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Recent Distributions
                    </h3>
                </div>
                <div class="p-6">
                    @if($recentDistributions->count() > 0)
                        @foreach($recentDistributions as $request)
                        <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg mb-3 last:mb-0">
                            <div class="flex items-center space-x-4">
                                @if($request->cover_image)
                                    <img src="{{ Storage::url($request->cover_image) }}" alt="{{ $request->song_title }}" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-sm">{{ Str::limit($request->song_title, 15) }}</p>
                                    <p class="text-gray-400 text-xs">{{ $request->artist_name }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $request->status === 'approved' ? 'bg-green-400/20 text-green-400' : 
                                   ($request->status === 'declined' ? 'bg-red-400/20 text-red-400' : 'bg-yellow-400/20 text-yellow-400') }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-400 text-sm">No distributions yet</p>
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
                                    <img src="{{ Storage::url($music->cover_image) }}" alt="{{ $music->title }}" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-sm">{{ Str::limit($music->title, 15) }}</p>
                                    <p class="text-gray-400 text-xs">{{ $music->genre }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $music->status === 'approved' ? 'bg-green-400/20 text-green-400' : 
                                   ($music->status === 'rejected' ? 'bg-red-400/20 text-red-400' : 'bg-yellow-400/20 text-yellow-400') }}">
                                {{ ucfirst($music->status ?? 'pending') }}
                            </span>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                            </svg>
                            <p class="text-gray-400 text-sm">No music yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Artists -->
            <div class="bg-gray-900 rounded-xl border border-gray-800">
                <div class="p-6 border-b border-gray-800">
                    <h3 class="text-xl font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Recent Artists
                    </h3>
                </div>
                <div class="p-6">
                    @if($recentArtists->count() > 0)
                        @foreach($recentArtists as $artist)
                        <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg mb-3 last:mb-0">
                            <div class="flex items-center space-x-4">
                                @if($artist->profile_picture)
                                    <img src="{{ Storage::url($artist->profile_picture) }}" alt="{{ $artist->name }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-sm">{{ Str::limit($artist->name, 15) }}</p>
                                    <p class="text-gray-400 text-xs">{{ $artist->genre }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $artist->status === 'approved' ? 'bg-green-400/20 text-green-400' : 
                                   ($artist->status === 'rejected' ? 'bg-red-400/20 text-red-400' : 'bg-yellow-400/20 text-yellow-400') }}">
                                {{ ucfirst($artist->status ?? 'pending') }}
                            </span>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <p class="text-gray-400 text-sm">No artists yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection