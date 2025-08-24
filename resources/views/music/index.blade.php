@extends('layouts.app')

@section('title', 'Music - Browse Latest Songs and Albums')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Music</h1>
                    <p class="text-gray-600 mt-2">Discover the latest songs, albums, and mixtapes</p>
                </div>
                
                <!-- Search Form -->
                <form method="GET" class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-2">
                    <input type="text" 
                           name="search" 
                           placeholder="Search music or artist..." 
                           value="{{ request('search') }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-gray-700 font-medium">Filter by:</label>
                </div>
                
                <!-- Category Filter -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('music.index') }}" 
                       class="px-3 py-1 rounded-full text-sm {{ !request('category') && !request('genre') ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        All
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('music.index', ['category' => $category->slug]) }}" 
                           class="px-3 py-1 rounded-full text-sm {{ request('category') === $category->slug ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Genre Filter -->
                <div class="flex flex-wrap gap-2">
                    @foreach($genres as $genre)
                        <a href="{{ route('music.index', ['genre' => $genre]) }}" 
                           class="px-3 py-1 rounded-full text-sm {{ request('genre') === $genre ? 'bg-accent text-white' : 'bg-accent/20 text-accent hover:bg-accent/30' }} transition-colors">
                            {{ ucfirst($genre) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Music Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($music->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($music as $track)
                    <x-music-card :music="$track" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $music->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm12-3c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2z"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No music found</h3>
                <p class="mt-1 text-gray-500">No tracks match your current search or filter criteria.</p>
                @if(request()->has('search') || request()->has('category') || request()->has('genre'))
                    <a href="{{ route('music.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection