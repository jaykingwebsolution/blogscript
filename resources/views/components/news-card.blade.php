@props(['post'])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'asset("images/default-news.svg")' }}" 
         alt="{{ $post->title }}" 
         class="w-full h-32 object-cover rounded-lg mb-3">
    <h3 class="font-semibold text-gray-900 mb-2">
        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-purple-600">
            {{ $post->title }}
        </a>
    </h3>
    <p class="text-sm text-gray-600 mb-2">{{ Str::limit($post->excerpt ?? $post->content, 100) }}</p>
    <div class="text-xs text-gray-500">{{ $post->created_at->format('M j, Y') }}</div>
</div>