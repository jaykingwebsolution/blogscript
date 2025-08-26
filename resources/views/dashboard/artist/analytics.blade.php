@extends('layouts.artist-dashboard')

@section('dashboard-content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Analytics</h1>
        <p class="text-gray-300">Track your music performance and audience insights</p>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Total Plays</h3>
                    <p class="text-3xl font-bold">{{ number_format($analytics['plays_total']) }}</p>
                    <p class="text-sm opacity-80">{{ number_format($analytics['plays_this_month']) }} this month</p>
                </div>
                <div class="bg-green-500/30 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Total Likes</h3>
                    <p class="text-3xl font-bold">{{ number_format($analytics['likes_total']) }}</p>
                    <p class="text-sm opacity-80">{{ number_format($analytics['likes_this_month']) }} this month</p>
                </div>
                <div class="bg-purple-500/30 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Followers</h3>
                    <p class="text-3xl font-bold">0</p>
                    <p class="text-sm opacity-80">+0 this month</p>
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
                    <h3 class="text-lg font-semibold">Avg. Rating</h3>
                    <p class="text-3xl font-bold">0.0</p>
                    <p class="text-sm opacity-80">★ ★ ★ ★ ★</p>
                </div>
                <div class="bg-orange-500/30 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Plays Over Time -->
        <div class="bg-gray-800 rounded-xl p-6">
            <h2 class="text-xl font-bold text-white mb-6">Plays Over Time</h2>
            <div class="h-64 flex items-center justify-center border-2 border-dashed border-gray-600 rounded-lg">
                <div class="text-center">
                    <svg class="w-12 h-12 text-gray-500 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <p class="text-gray-400 font-medium">Chart Coming Soon</p>
                    <p class="text-gray-500 text-sm">Play analytics will appear here</p>
                </div>
            </div>
        </div>

        <!-- Top Locations -->
        <div class="bg-gray-800 rounded-xl p-6">
            <h2 class="text-xl font-bold text-white mb-6">Top Listening Locations</h2>
            <div class="h-64 flex items-center justify-center border-2 border-dashed border-gray-600 rounded-lg">
                <div class="text-center">
                    <svg class="w-12 h-12 text-gray-500 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-gray-400 font-medium">Geographic Data Coming Soon</p>
                    <p class="text-gray-500 text-sm">Location analytics will appear here</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Tracks -->
    <div class="bg-gray-800 rounded-xl p-6">
        <h2 class="text-xl font-bold text-white mb-6">Your Top Performing Tracks</h2>

        @if($analytics['top_tracks']->count() > 0)
            <div class="space-y-4">
                @foreach($analytics['top_tracks'] as $index => $track)
                <div class="flex items-center p-4 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                    <div class="flex items-center justify-center w-8 h-8 bg-purple-600 text-white text-sm font-bold rounded-full mr-4">
                        {{ $index + 1 }}
                    </div>
                    
                    <div class="w-12 h-12 bg-gray-600 rounded flex-shrink-0 flex items-center justify-center">
                        @if($track->cover_image)
                            <img src="{{ Storage::url($track->cover_image) }}" alt="{{ $track->title }}" class="w-full h-full object-cover rounded">
                        @else
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        @endif
                    </div>
                    
                    <div class="ml-4 flex-1">
                        <h3 class="text-white font-medium">{{ $track->title }}</h3>
                        <p class="text-gray-400 text-sm">{{ $track->genre }} • {{ $track->created_at->format('M Y') }}</p>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-white font-medium">{{ $track->likes_count }} likes</p>
                        <p class="text-gray-400 text-sm">0 plays</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                </svg>
                <h3 class="text-gray-400 text-lg mb-2">No tracks to analyze yet</h3>
                <p class="text-gray-500 mb-6">Upload some music to see your analytics</p>
                <a href="{{ route('dashboard.artist.upload-music') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full font-medium transition-colors">
                    Upload Music
                </a>
            </div>
        @endif
    </div>

    <!-- Coming Soon Features -->
    <div class="mt-8 bg-gradient-to-r from-gray-800 to-gray-700 rounded-xl p-6 border border-gray-600">
        <h2 class="text-xl font-bold text-white mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
            </svg>
            Advanced Analytics Coming Soon
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4">
                <div class="bg-blue-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                </div>
                <h3 class="text-white font-medium mb-2">Detailed Play Analytics</h3>
                <p class="text-gray-400 text-sm">Track plays by time, location, and demographics</p>
            </div>
            
            <div class="text-center p-4">
                <div class="bg-green-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-white font-medium mb-2">Revenue Tracking</h3>
                <p class="text-gray-400 text-sm">Monitor earnings from streams and downloads</p>
            </div>
            
            <div class="text-center p-4">
                <div class="bg-purple-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
                <h3 class="text-white font-medium mb-2">Audience Insights</h3>
                <p class="text-gray-400 text-sm">Understand your listeners and fanbase</p>
            </div>
        </div>
    </div>
</div>
@endsection