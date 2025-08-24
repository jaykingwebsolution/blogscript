@extends('layouts.app')

@section('title', 'BlogScript - Home')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary to-secondary text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Welcome to BlogScript</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Your ultimate destination for music, entertainment, and trending news. Discover the latest hits, trending artists, and breaking news all in one place.</p>
            <div class="space-x-4">
                <a href="#featured" class="bg-accent hover:bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors">Explore Now</a>
                <a href="#" class="border-2 border-white text-white hover:bg-white hover:text-primary px-8 py-3 rounded-lg font-semibold transition-colors">Learn More</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Music Section -->
<section id="featured" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Music</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover the hottest tracks and latest releases from your favorite artists</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(isset($useDummyData) && $useDummyData)
                @for($i = 1; $i <= 3; $i++)
                    @include('components.card', [
                        'title' => 'Amazing Song ' . $i,
                        'description' => 'This is an incredible track that has been trending across all music platforms. Experience the perfect blend of rhythm and melody.',
                        'image' => 'https://via.placeholder.com/400x300/3B82F6/FFFFFF?text=Music+' . $i,
                        'badge' => 'New Release',
                        'link' => '#'
                    ])
                @endfor
            @else
                @forelse($featuredMusic as $music)
                    @include('components.card', [
                        'title' => $music->title,
                        'description' => $music->description ?: 'Experience this amazing track from ' . $music->artist_name,
                        'image' => $music->image_url ?: 'https://via.placeholder.com/400x300/3B82F6/FFFFFF?text=Music',
                        'badge' => 'New Release',
                        'link' => '#'
                    ])
                @empty
                    <div class="col-span-full text-center py-8">
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