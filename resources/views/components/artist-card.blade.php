<!-- Artist Card Component -->
@props(['artist'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <div class="relative">
        <img src="{{ $artist->image_url ?? '/images/default-artist.jpg' }}" 
             alt="{{ $artist->name }}" 
             class="w-full h-48 object-cover">
        @if($artist->is_trending)
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-medium">
                    🔥 Trending
                </span>
            </div>
        @endif
    </div>
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">
            <a href="{{ route('artists.show', $artist->username ?? $artist->slug) }}" class="hover:text-primary transition-colors">
                {{ $artist->name }}
            </a>
        </h3>
        @if($artist->genre)
            <p class="text-gray-600 mb-2">{{ $artist->genre }}</p>
        @endif
        @if($artist->country)
            <p class="text-gray-500 text-sm mb-2">{{ $artist->country }}</p>
        @endif
        @if($artist->bio)
            <p class="text-gray-700 text-sm mb-3 line-clamp-2">
                {{ Str::limit($artist->bio, 100) }}
            </p>
        @endif
        @if(isset($artist->music) && $artist->music->count() > 0)
            <div class="border-t pt-2">
                <p class="text-gray-600 text-sm mb-1">Latest Tracks:</p>
                @foreach($artist->music->take(2) as $music)
                    <a href="{{ route('music.show', $music->slug) }}" class="block text-sm text-primary hover:underline">
                        {{ $music->title }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>