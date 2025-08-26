@extends('layouts.listener-dashboard')

@section('dashboard-content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Search Results</h1>
        <p class="text-gray-300">
            @if($query)
                Showing results for "<span class="text-green-400 font-semibold">{{ $query }}</span>"
            @else
                Enter a search term to find music
            @endif
        </p>
    </div>

    <!-- Search Results -->
    @if($music->count() > 0)
        <div class="mb-6">
            <p class="text-gray-400 text-sm">Found {{ $music->total() }} {{ Str::plural('track', $music->total()) }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6 mb-8">
            @foreach($music as $track)
            <div class="bg-gray-800 hover:bg-gray-700 rounded-lg p-4 transition-colors group">
                <div class="relative aspect-square bg-gray-600 rounded-lg mb-4 overflow-hidden">
                    @if($track->cover_image)
                        <img src="{{ Storage::url($track->cover_image) }}" 
                             alt="{{ $track->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                        <button class="bg-green-600 hover:bg-green-700 text-white rounded-full p-3 transform scale-75 group-hover:scale-100 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <h3 class="text-white font-medium text-sm truncate mb-1">{{ $track->title }}</h3>
                <p class="text-gray-400 text-xs truncate mb-2">{{ $track->artists->first()->name ?? $track->artist_name ?? 'Unknown Artist' }}</p>
                
                <div class="flex items-center justify-between">
                    @if($track->genre)
                        <span class="text-xs text-gray-500 bg-gray-700 px-2 py-1 rounded">{{ $track->genre }}</span>
                    @endif
                    
                    <div class="flex items-center space-x-2">
                        <button class="text-gray-400 hover:text-red-400 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <div class="relative">
                            <button class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($music->hasPages())
            <div class="flex justify-center">
                <nav class="bg-gray-800 rounded-lg p-2">
                    {{ $music->appends(['q' => $query])->links() }}
                </nav>
            </div>
        @endif
    @else
        <!-- No Results -->
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
            </svg>
            <h3 class="text-gray-400 text-xl mb-2">No results found</h3>
            @if($query)
                <p class="text-gray-500 mb-6">Try searching for something different or check the spelling</p>
                <div class="space-y-2 text-sm text-gray-400">
                    <p>Search suggestions:</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-500">
                        <li>Try more general terms</li>
                        <li>Check your spelling</li>
                        <li>Try searching by artist name</li>
                        <li>Try searching by genre</li>
                    </ul>
                </div>
            @else
                <p class="text-gray-500">Use the search bar above to find music</p>
            @endif
            
            <a href="{{ route('dashboard.listener.browse') }}" class="inline-block mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-medium transition-colors">
                Browse All Music
            </a>
        </div>
    @endif
</div>
@endsection