@extends('layouts.app')

@section('title', 'Music Platform - Home')

@section('content')
<!-- Hero Section with Slider -->
<section class="relative bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">Welcome to Music Platform</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Your ultimate destination for music, entertainment, and trending artists. Discover the latest hits, trending content, and breaking news all in one place.</p>
            <div class="space-x-4">
                <a href="{{ route('music.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">Explore Music</a>
                <a href="{{ route('artists.index') }}" class="border-2 border-white text-white hover:bg-white hover:text-purple-600 px-8 py-3 rounded-lg font-semibold transition-colors">Browse Artists</a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Grid - 3 Columns -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Latest Music Column -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Latest Music</h2>
                        <a href="{{ route('music.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">View All</a>
                    </div>
                    
                    @forelse($latestMusic ?? [] as $music)
                        <x-music-card :music="$music" class="mb-4" />
                    @empty
                        <!-- Demo Content -->
                        @for($i = 1; $i <= 3; $i++)
                        <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors mb-4">
                            <img src="https://via.placeholder.com/80x80/3B82F6/FFFFFF?text=Music" alt="Music Cover" class="w-16 h-16 rounded-lg object-cover">
                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-900">Amazing Afrobeats Hit {{ $i }}</h3>
                                <p class="text-sm text-gray-600">Artist Name {{ $i }}</p>
                                <div class="flex items-center mt-1">
                                    <button class="text-purple-600 hover:text-purple-800 mr-4">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 5v10l7-5z"/>
                                        </svg>
                                    </button>
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 17a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endfor
                    @endforelse
                </div>
            </div>

            <!-- News/Gist Column -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Latest News & Gist</h2>
                        <a href="{{ route('posts.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">View All</a>
                    </div>
                    
                    @forelse($latestPosts ?? [] as $post)
                        <x-news-card :post="$post" class="mb-4" />
                    @empty
                        <!-- Demo Content -->
                        @for($i = 1; $i <= 3; $i++)
                        <div class="mb-6">
                            <img src="https://via.placeholder.com/300x150/10B981/FFFFFF?text=News+{{ $i }}" alt="News" class="w-full h-32 object-cover rounded-lg mb-3">
                            <h3 class="font-semibold text-gray-900 mb-2">Breaking: New Music Industry Trends in {{ date('Y') }}</h3>
                            <p class="text-sm text-gray-600 mb-2">Discover the latest trends shaping the music industry and how artists are adapting to new technologies...</p>
                            <div class="text-xs text-gray-500">{{ now()->subHours($i)->format('M j, Y') }}</div>
                        </div>
                        @endfor
                    @endforelse
                </div>
            </div>

            <!-- Trending Artists Column -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Trending Artists</h2>
                        <a href="{{ route('artists.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">View All</a>
                    </div>
                    
                    @forelse($featuredArtists ?? [] as $artist)
                        <x-artist-card :artist="$artist" class="mb-4" />
                    @empty
                        <!-- Demo Content -->
                        @for($i = 1; $i <= 4; $i++)
                        <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors mb-4">
                            <img src="https://via.placeholder.com/60x60/F59E0B/FFFFFF?text=Artist" alt="Artist" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center">
                                    <h3 class="font-semibold text-gray-900">Trending Artist {{ $i }}</h3>
                                    @if($i <= 2)
                                        <svg class="w-4 h-4 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">Afrobeats, Pop</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-purple-600 bg-purple-100 px-2 py-1 rounded-full">Trending</span>
                                </div>
                            </div>
                        </div>
                        @endfor
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Videos & Mixtapes Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Videos & Mixtapes</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Watch the latest music videos and listen to exclusive mixtapes</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @for($i = 1; $i <= 3; $i++)
            <div class="bg-gray-100 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="https://via.placeholder.com/400x225/EF4444/FFFFFF?text=Video+{{ $i }}" alt="Video" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-white bg-opacity-90 rounded-full p-4 hover:bg-opacity-100 transition-colors cursor-pointer">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 5v10l7-5z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Amazing Music Video {{ $i }}</h3>
                    <p class="text-sm text-gray-600">Artist Name {{ $i }}</p>
                    <div class="text-xs text-gray-500 mt-2">{{ now()->subDays($i)->format('M j, Y') }}</div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-gradient-to-r from-purple-600 to-pink-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Stay Updated</h2>
        <p class="text-xl mb-8">Get the latest music releases, artist news, and exclusive content delivered to your inbox</p>
        
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto" method="POST" action="{{ route('newsletter.subscribe') }}">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-semibold transition-colors">Subscribe</button>
        </form>
    </div>
</section>

@endsection
                        <p class="text-gray-600">No featured music available yet. Check back soon!</p>
                    </div>
                @endforelse
            @endif
        </div>
    </div>
</section>

<!-- Trending Artists Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Trending Artists</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Meet the artists making waves in the industry right now</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(isset($useDummyData) && $useDummyData)
                @for($i = 1; $i <= 4; $i++)
                    @include('components.card', [
                        'title' => 'Artist Name ' . $i,
                        'description' => 'Rising star in the music industry with multiple chart-topping hits. Known for their unique style and powerful vocals.',
                        'image' => 'https://via.placeholder.com/400x300/1E40AF/FFFFFF?text=Artist+' . $i,
                        'badge' => 'Trending',
                        'link' => '#'
                    ])
                @endfor
            @else
                @forelse($trendingArtists as $artist)
                    @include('components.card', [
                        'title' => $artist->name,
                        'description' => $artist->bio ?: 'Rising star in the music industry with multiple chart-topping hits.',
                        'image' => $artist->image_url ?: 'https://via.placeholder.com/400x300/1E40AF/FFFFFF?text=Artist',
                        'badge' => 'Trending',
                        'link' => '#'
                    ])
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-600">No trending artists available yet. Check back soon!</p>
                    </div>
                @endforelse
            @endif
        </div>
    </div>
</section>

<!-- Latest Blog Posts Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Latest Blog Posts</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Stay updated with the latest news, gossips, and entertainment stories</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(isset($useDummyData) && $useDummyData)
                @for($i = 1; $i <= 3; $i++)
                    @include('components.card', [
                        'title' => 'Breaking Entertainment News ' . $i,
                        'description' => 'Get the latest scoop on your favorite celebrities and entertainment industry updates. This story covers all the important details you need to know.',
                        'image' => 'https://via.placeholder.com/400x300/F59E0B/FFFFFF?text=News+' . $i,
                        'badge' => 'Latest',
                        'link' => '#'
                    ])
                @endfor
            @else
                @forelse($latestNews as $news)
                    @include('components.card', [
                        'title' => $news->title,
                        'description' => $news->excerpt ?: Str::limit($news->content, 150),
                        'image' => $news->image_url ?: 'https://via.placeholder.com/400x300/F59E0B/FFFFFF?text=News',
                        'badge' => 'Latest',
                        'link' => '#'
                    ])
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-600">No latest news available yet. Check back soon!</p>
                    </div>
                @endforelse
            @endif
        </div>
    </div>
</section>

<!-- Recent Videos Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Recent Videos</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Watch the latest music videos, interviews, and exclusive content</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(isset($useDummyData) && $useDummyData)
                @for($i = 1; $i <= 4; $i++)
                    @include('components.card', [
                        'title' => 'Music Video ' . $i,
                        'description' => 'Watch this amazing music video featuring stunning visuals and incredible performances from top artists.',
                        'image' => 'https://via.placeholder.com/400x300/EF4444/FFFFFF?text=Video+' . $i,
                        'badge' => 'HD Video',
                        'link' => '#'
                    ])
                @endfor
            @else
                @forelse($recentVideos as $video)
                    @include('components.card', [
                        'title' => $video->title,
                        'description' => $video->description ?: 'Watch this amazing video featuring stunning visuals and incredible performances.',
                        'image' => $video->thumbnail_url ?: 'https://via.placeholder.com/400x300/EF4444/FFFFFF?text=Video',
                        'badge' => 'HD Video',
                        'link' => '#'
                    ])
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-600">No recent videos available yet. Check back soon!</p>
                    </div>
                @endforelse
            @endif
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-primary text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Stay Updated</h2>
        <p class="text-xl mb-8">Subscribe to our newsletter and never miss the latest in music and entertainment</p>
        
        <form class="max-w-md mx-auto" method="POST" action="{{ route('newsletter.subscribe') }}">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="email" name="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-accent" required>
                <button type="submit" class="bg-accent hover:bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors">Subscribe</button>
            </div>
        </form>
    </div>
</section>
@endsection