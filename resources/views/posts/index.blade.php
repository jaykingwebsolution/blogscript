@extends('layouts.app')

@section('title', 'Blog & News - Latest Entertainment Updates')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Blog & News</h1>
                    <p class="text-gray-600 mt-2">Stay updated with the latest entertainment news and stories</p>
                </div>
                
                <!-- Search Form -->
                <form method="GET" class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-2">
                    <input type="text" 
                           name="search" 
                           placeholder="Search posts..." 
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
                    <label class="text-gray-700 font-medium">Filter by Category:</label>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('posts.index') }}" 
                       class="px-3 py-1 rounded-full text-sm {{ !request('category') ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        All Posts
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('posts.index', ['category' => $category->slug]) }}" 
                           class="px-3 py-1 rounded-full text-sm {{ request('category') === $category->slug ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No posts found</h3>
                <p class="mt-1 text-gray-500">No posts match your current search or filter criteria.</p>
                @if(request()->has('search') || request()->has('category'))
                    <a href="{{ route('posts.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection