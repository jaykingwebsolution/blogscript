@extends('layouts.app')

@section('title', 'Videos - Latest Music Videos and Content')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Videos</h1>
                    <p class="text-gray-600 mt-2">Watch the latest music videos and exclusive content</p>
                </div>
                
                <!-- Search Form -->
                <form method="GET" class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-2">
                    <input type="text" 
                           name="search" 
                           placeholder="Search videos..." 
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
                    <a href="{{ route('videos.index') }}" 
                       class="px-3 py-1 rounded-full text-sm {{ !request('category') ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        All Videos
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('videos.index', ['category' => $category->slug]) }}" 
                           class="px-3 py-1 rounded-full text-sm {{ request('category') === $category->slug ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Videos Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($videos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($videos as $video)
                    <x-video-card :video="$video" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $videos->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No videos found</h3>
                <p class="mt-1 text-gray-500">No videos match your current search or filter criteria.</p>
                @if(request()->has('search') || request()->has('category'))
                    <a href="{{ route('videos.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection