<!-- Music Card Component -->
@props(['music'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <div class="relative">
        <img src="{{ $music->image_url ?? '/images/default-music.jpg' }}" 
             alt="{{ $music->title }}" 
             class="w-full h-48 object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
            <button onclick="playMusic('{{ $music->audio_url }}')" class="bg-spotify-green text-white p-3 rounded-full opacity-0 hover:opacity-100 transition-all">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </button>
        </div>
        
        <!-- Like Button Overlay -->
        @auth
            <form method="POST" action="{{ route('music.like.toggle', $music) }}" class="absolute top-2 right-2">
                @csrf
                <button type="submit" 
                        class="p-2 rounded-full {{ auth()->user()->hasLikedSong($music->id) ? 'bg-red-500 text-white' : 'bg-black/50 text-white hover:bg-black/70' }} transition-colors">
                    <svg class="w-4 h-4 {{ auth()->user()->hasLikedSong($music->id) ? 'fill-current' : '' }}" 
                         fill="{{ auth()->user()->hasLikedSong($music->id) ? 'currentColor' : 'none' }}" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </form>
        @endauth
    </div>
    
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">
            <a href="{{ route('music.show', $music->slug) }}" class="hover:text-spotify-green transition-colors">
                {{ $music->title }}
            </a>
        </h3>
        <p class="text-gray-600 mb-2">
            @if($music->artist)
                <a href="{{ route('artists.show', $music->artist->username) }}" class="hover:text-spotify-green">
                    {{ $music->artist->name }}
                </a>
            @else
                {{ $music->artist_name }}
            @endif
        </p>
        
        <div class="flex items-center justify-between">
            <div class="flex flex-wrap gap-1">
                @if($music->category)
                    <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                        {{ $music->category->name }}
                    </span>
                @endif
                @if($music->genre)
                    <span class="inline-block bg-spotify-green/10 text-spotify-green px-2 py-1 rounded text-xs">
                        {{ $music->genre }}
                    </span>
                @endif
            </div>
            
            @auth
                <!-- Quick Actions -->
                <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button onclick="addToPlaylistQuick({{ $music->id }})" 
                            class="p-1 text-gray-400 hover:text-spotify-green transition-colors"
                            title="Add to playlist">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </div>
            @endauth
        </div>
        
        @if($music->tags->count() > 0)
            <div class="mt-2">
                @foreach($music->tags->take(2) as $tag)
                    <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs mr-1">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Like Count -->
        <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
            <div class="flex items-center space-x-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span>{{ $music->likes_count ?? 0 }}</span>
            </div>
            @if($music->duration)
                <span>{{ $music->duration }}</span>
            @endif
        </div>
    </div>
</div>