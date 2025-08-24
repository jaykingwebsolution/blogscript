<!-- Video Card Component -->
@props(['video'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <div class="relative">
        <img src="{{ $video->thumbnail_url ?? '/images/default-video.jpg' }}" 
             alt="{{ $video->title }}" 
             class="w-full h-48 object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
            <a href="{{ route('videos.show', $video->slug) }}" class="bg-red-600 text-white p-3 rounded-full opacity-80 hover:opacity-100 transition-all">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </a>
        </div>
        @if($video->duration)
            <div class="absolute bottom-2 right-2 bg-black bg-opacity-75 text-white px-2 py-1 rounded text-xs">
                {{ $video->duration }}
            </div>
        @endif
    </div>
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">
            <a href="{{ route('videos.show', $video->slug) }}" class="hover:text-primary transition-colors line-clamp-2">
                {{ $video->title }}
            </a>
        </h3>
        @if($video->description)
            <p class="text-gray-600 text-sm mb-2 line-clamp-2">
                {{ Str::limit($video->description, 120) }}
            </p>
        @endif
        @if($video->category)
            <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm">
                {{ $video->category->name }}
            </span>
        @endif
        @if($video->tags->count() > 0)
            <div class="mt-2">
                @foreach($video->tags->take(3) as $tag)
                    <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs mr-1">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</div>