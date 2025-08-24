<!-- News/Blog Card Component -->
@props(['post'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    @if($post->image_url)
        <div class="relative">
            <img src="{{ $post->image_url }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-48 object-cover">
        </div>
    @endif
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary transition-colors line-clamp-2">
                {{ $post->title }}
            </a>
        </h3>
        @if($post->excerpt)
            <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                {{ $post->excerpt }}
            </p>
        @endif
        <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
            @if($post->creator)
                <span>By {{ $post->creator->name }}</span>
            @endif
            @if($post->published_at)
                <span>{{ $post->published_at->format('M d, Y') }}</span>
            @endif
        </div>
        <div class="flex items-center justify-between">
            <div>
                @if($post->category)
                    <span class="inline-block bg-primary/10 text-primary px-2 py-1 rounded text-sm">
                        {{ $post->category->name }}
                    </span>
                @endif
            </div>
            @if($post->is_featured)
                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-medium">
                    Featured
                </span>
            @endif
        </div>
        @if($post->tags->count() > 0)
            <div class="mt-2">
                @foreach($post->tags->take(3) as $tag)
                    <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs mr-1">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</div>