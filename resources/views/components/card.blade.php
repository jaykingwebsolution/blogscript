@props(['title', 'description', 'image', 'link' => '#', 'badge' => null])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    @if($image)
        <div class="relative">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
            @if($badge)
                <span class="absolute top-2 left-2 bg-primary text-white px-2 py-1 rounded-full text-xs font-medium">
                    {{ $badge }}
                </span>
            @endif
        </div>
    @endif
    
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $title }}</h3>
        @if($description)
            <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ $description }}</p>
        @endif
        <a href="{{ $link }}" class="inline-flex items-center text-primary hover:text-secondary font-medium text-sm transition-colors">
            Read More
            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>