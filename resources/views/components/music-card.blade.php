<!-- Music Card Component -->
@props(['music'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <div class="relative">
        <img src="{{ $music->image_url ?? '/images/default-music.jpg' }}" 
             alt="{{ $music->title }}" 
             class="w-full h-48 object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
            <button onclick="playMusic('{{ $music->audio_url }}')" class="bg-primary text-white p-3 rounded-full opacity-0 hover:opacity-100 transition-all">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">
            <a href="{{ route('music.show', $music->slug) }}" class="hover:text-primary transition-colors">
                {{ $music->title }}
            </a>
        </h3>
        <p class="text-gray-600 mb-2">
            @if($music->artist)
                <a href="{{ route('artists.show', $music->artist->username) }}" class="hover:text-primary">
                    {{ $music->artist->name }}
                </a>
            @else
                {{ $music->artist_name }}
            @endif
        </p>
        @if($music->category)
            <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm">
                {{ $music->category->name }}
            </span>
        @endif
        @if($music->genre)
            <span class="inline-block bg-primary/10 text-primary px-2 py-1 rounded text-sm ml-1">
                {{ $music->genre }}
            </span>
        @endif
        @if($music->tags->count() > 0)
            <div class="mt-2">
                @foreach($music->tags->take(3) as $tag)
                    <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs mr-1">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</div>