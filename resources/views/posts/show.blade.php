@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Post Header -->
    @if($post->image_url)
        <div class="relative h-64 md:h-96 bg-gray-900">
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover opacity-75">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-end">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 w-full">
                    <div class="max-w-4xl">
                        @if($post->category)
                            <span class="inline-block bg-primary text-white px-3 py-1 rounded-full text-sm font-medium mb-2">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">{{ $post->title }}</h1>
                        <div class="flex items-center text-white/90 text-sm space-x-4">
                            @if($post->creator)
                                <span>By {{ $post->creator->name }}</span>
                            @endif
                            @if($post->published_at)
                                <span>{{ $post->published_at->format('F d, Y') }}</span>
                            @endif
                            @if($post->is_featured)
                                <span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs font-medium">Featured</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Post Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <article class="bg-white rounded-lg shadow-md p-6 mb-8">
                    @if(!$post->image_url)
                        <!-- Title and meta for posts without header image -->
                        <div class="mb-6">
                            @if($post->category)
                                <span class="inline-block bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-2">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                            <div class="flex items-center text-gray-600 text-sm space-x-4 mb-4">
                                @if($post->creator)
                                    <span>By {{ $post->creator->name }}</span>
                                @endif
                                @if($post->published_at)
                                    <span>{{ $post->published_at->format('F d, Y') }}</span>
                                @endif
                                @if($post->is_featured)
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-medium">Featured</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($post->excerpt)
                        <div class="text-lg text-gray-700 mb-6 p-4 bg-gray-50 rounded-lg border-l-4 border-primary">
                            {{ $post->excerpt }}
                        </div>
                    @endif

                    <div class="prose max-w-none text-gray-800 leading-relaxed">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- Tags -->
                    @if($post->tags->count() > 0)
                        <div class="mt-8 pt-8 border-t">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}" 
                                       class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm transition-colors">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share -->
                    <div class="mt-8 pt-8 border-t">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Share this article</h3>
                        <div class="flex space-x-3">
                            <button onclick="sharePost(@json(route('posts.show', $post->slug)), @json($post->title))" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition-colors">
                                Share
                            </button>
                            <button onclick="copyLink(@json(route('posts.show', $post->slug)))" 
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition-colors">
                                Copy Link
                            </button>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="mt-8 lg:mt-0 space-y-6">
                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Related Posts</h2>
                        <div class="space-y-4">
                            @foreach($relatedPosts as $related)
                                <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                    @if($related->image_url)
                                        <div class="flex-shrink-0">
                                            <img src="{{ $related->image_url }}" 
                                                 alt="{{ $related->title }}" 
                                                 class="w-16 h-12 rounded object-cover">
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 text-sm line-clamp-2 mb-1">
                                            <a href="{{ route('posts.show', $related->slug) }}" class="hover:text-primary">
                                                {{ $related->title }}
                                            </a>
                                        </h4>
                                        <p class="text-xs text-gray-500">{{ $related->published_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('posts.index') }}" class="text-primary hover:text-primary/80 font-medium">
                                Read More Posts →
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Post Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Post Info</h3>
                    <div class="space-y-3 text-sm">
                        @if($post->published_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Published:</span>
                                <span class="font-medium text-gray-900">{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                        @endif
                        @if($post->creator)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Author:</span>
                                <span class="font-medium text-gray-900">{{ $post->creator->name }}</span>
                            </div>
                        @endif
                        @if($post->category)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium text-gray-900">{{ $post->category->name }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Reading time:</span>
                            <span class="font-medium text-gray-900">{{ ceil(str_word_count($post->content) / 200) }} min</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function sharePost(url, title) {
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        });
    } else {
        copyLink(url);
    }
}

function copyLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copied to clipboard!');
    });
}
</script>
@endsection