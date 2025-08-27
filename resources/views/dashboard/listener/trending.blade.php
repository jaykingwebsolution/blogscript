@extends('layouts.listener-dashboard')

@section('dashboard-content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Trending Now</h1>
        <p class="text-gray-300">Discover what's hot in the music world</p>
    </div>

    <!-- Trending Sections -->
    <div class="space-y-12">
        <!-- This Week -->
        @if($weeklyTrending->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                    This Week
                </h2>
                <span class="text-sm text-gray-400">{{ $weeklyTrending->count() }} tracks</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($weeklyTrending as $index => $track)
                <div class="bg-gray-800 hover:bg-gray-700 rounded-lg p-4 transition-colors cursor-pointer group">
                    <div class="relative aspect-square bg-gray-600 rounded-lg mb-3 overflow-hidden">
                        @if($track->cover_image)
                            <img src="{{ Storage::url($track->cover_image) }}" alt="{{ $track->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Ranking Badge -->
                        <div class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full font-bold">
                            #{{ $index + 1 }}
                        </div>
                        
                        <!-- Play Button Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                            <button class="bg-green-600 hover:bg-green-700 text-white rounded-full p-3 transform scale-75 group-hover:scale-100 transition-transform">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <h3 class="text-white font-medium text-sm truncate">{{ $track->title }}</h3>
                    <p class="text-gray-400 text-xs truncate">{{ $track->artists->first()->name ?? $track->artist_name ?? 'Unknown Artist' }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- This Month -->
        @if($monthlyTrending->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 text-purple-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                    </svg>
                    This Month
                </h2>
                <span class="text-sm text-gray-400">{{ $monthlyTrending->count() }} tracks</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($monthlyTrending as $index => $track)
                <div class="bg-gray-800 hover:bg-gray-700 rounded-lg p-4 transition-colors cursor-pointer group">
                    <div class="relative aspect-square bg-gray-600 rounded-lg mb-3 overflow-hidden">
                        @if($track->cover_image)
                            <img src="{{ Storage::url($track->cover_image) }}" alt="{{ $track->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Ranking Badge -->
                        <div class="absolute top-2 left-2 bg-purple-600 text-white text-xs px-2 py-1 rounded-full font-bold">
                            #{{ $index + 1 }}
                        </div>
                        
                        <!-- Play Button Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                            <button class="bg-green-600 hover:bg-green-700 text-white rounded-full p-3 transform scale-75 group-hover:scale-100 transition-transform">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <h3 class="text-white font-medium text-sm truncate">{{ $track->title }}</h3>
                    <p class="text-gray-400 text-xs truncate">{{ $track->artists->first()->name ?? $track->artist_name ?? 'Unknown Artist' }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- All Time -->
        @if($allTimeTrending->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 text-orange-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    All Time Favorites
                </h2>
                <span class="text-sm text-gray-400">{{ $allTimeTrending->count() }} tracks</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($allTimeTrending as $index => $track)
                <div class="bg-gray-800 hover:bg-gray-700 rounded-lg p-4 transition-colors cursor-pointer group">
                    <div class="relative aspect-square bg-gray-600 rounded-lg mb-3 overflow-hidden">
                        @if($track->cover_image)
                            <img src="{{ Storage::url($track->cover_image) }}" alt="{{ $track->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Ranking Badge -->
                        <div class="absolute top-2 left-2 bg-orange-600 text-white text-xs px-2 py-1 rounded-full font-bold">
                            #{{ $index + 1 }}
                        </div>
                        
                        <!-- Play Button Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                            <button class="bg-green-600 hover:bg-green-700 text-white rounded-full p-3 transform scale-75 group-hover:scale-100 transition-transform">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <h3 class="text-white font-medium text-sm truncate">{{ $track->title }}</h3>
                    <p class="text-gray-400 text-xs truncate">{{ $track->artists->first()->name ?? $track->artist_name ?? 'Unknown Artist' }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Empty State -->
        @if($weeklyTrending->count() === 0 && $monthlyTrending->count() === 0 && $allTimeTrending->count() === 0)
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
            </svg>
            <h3 class="text-gray-400 text-xl mb-2">No trending tracks yet</h3>
            <p class="text-gray-500">Check back later for the hottest tracks</p>
            <a href="{{ route('dashboard.listener.browse') }}" class="inline-block mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-medium transition-colors">
                Explore Music
            </a>
        </div>
        @endif
    </div>
</div>
@endsection