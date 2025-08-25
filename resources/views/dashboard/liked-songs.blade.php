@extends('layouts.app')

@section('title', 'Liked Songs - MusicStream')

@push('styles')
<style>
    .play-btn {
        background: rgba(29, 185, 84, 0.9);
        backdrop-filter: blur(10px);
    }
    
    .play-btn:hover {
        background: rgba(29, 185, 84, 1);
        transform: scale(1.05);
    }
    
    .like-btn.liked {
        color: #1db954;
    }
    
    .track-row:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>
@endpush

@section('content')
<!-- Top Bar -->
<header class="bg-gradient-to-b from-purple-600/30 to-transparent relative z-10">
    <div class="flex items-center justify-between px-4 lg:px-8 py-8">
        <div class="flex items-center space-x-6">
            <div class="hidden lg:flex items-center space-x-2">
                <button onclick="history.back()" class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="history.forward()" class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Liked Songs Cover -->
                <div class="w-48 h-48 bg-gradient-to-br from-purple-600 to-purple-800 rounded-lg shadow-2xl flex items-center justify-center">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </div>
                
                <div class="text-white">
                    <p class="text-sm font-medium uppercase tracking-wider">Playlist</p>
                    <h1 class="text-4xl lg:text-6xl font-bold mb-4">Liked Songs</h1>
                    <div class="flex items-center text-sm">
                        <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://via.placeholder.com/24x24/3b82f6/FFFFFF?text=' . substr(auth()->user()->name, 0, 1) }}" alt="Profile" class="w-6 h-6 rounded-full mr-2">
                        <span class="font-semibold">{{ auth()->user()->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $likedSongs->total() }} songs</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dark mode toggle -->
        <button onclick="toggleDarkMode()" class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
            <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
            <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </button>
    </div>
</header>

<div class="flex-1 overflow-y-auto bg-gradient-to-b from-purple-600/10 via-gray-50 to-gray-50 dark:from-purple-900/10 dark:via-spotify-dark dark:to-spotify-dark">
    @if($likedSongs->count() > 0)
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <!-- Controls -->
        <div class="py-8 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-6">
                <button class="w-14 h-14 bg-spotify-green rounded-full flex items-center justify-center text-white shadow-lg hover:bg-green-600 hover:scale-105 transition-all">
                    <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 5v10l7-5z"/>
                    </svg>
                </button>
                
                <button class="w-8 h-8 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </button>
                
                <button class="w-8 h-8 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Songs List -->
        <div class="py-4">
            <!-- Header -->
            <div class="grid grid-cols-12 gap-4 px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 mb-2">
                <div class="col-span-1 text-center">#</div>
                <div class="col-span-6">TITLE</div>
                <div class="col-span-3 hidden lg:block">ARTIST</div>
                <div class="col-span-1 hidden lg:block">DATE ADDED</div>
                <div class="col-span-1 text-center">
                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Song rows -->
            @foreach($likedSongs as $index => $song)
            <div class="track-row grid grid-cols-12 gap-4 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-colors group">
                <div class="col-span-1 flex items-center justify-center">
                    <span class="text-gray-500 dark:text-gray-400 group-hover:hidden">{{ $likedSongs->firstItem() + $index }}</span>
                    <button class="w-4 h-4 text-gray-600 dark:text-gray-400 hover:text-white hidden group-hover:block">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 5v10l7-5z"/>
                        </svg>
                    </button>
                </div>
                
                <div class="col-span-6 flex items-center space-x-3">
                    <img src="{{ $song->cover_image ? asset('storage/' . $song->cover_image) : 'https://via.placeholder.com/48x48/3B82F6/FFFFFF?text=♪' }}" 
                         alt="{{ $song->title }}" 
                         class="w-12 h-12 rounded object-cover">
                    <div class="min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white truncate">{{ $song->title }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $song->artist->name ?? $song->user->name }}</p>
                    </div>
                </div>
                
                <div class="col-span-3 hidden lg:flex items-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $song->artist->name ?? $song->user->name }}</p>
                </div>
                
                <div class="col-span-1 hidden lg:flex items-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $song->pivot->created_at->diffForHumans() }}</p>
                </div>
                
                <div class="col-span-1 flex items-center justify-center space-x-2">
                    <button class="like-btn liked w-5 h-5 text-spotify-green hover:scale-110 transition-transform" 
                            onclick="toggleLike({{ $song->id }})"
                            title="Remove from liked songs">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <span class="text-sm text-gray-500 dark:text-gray-400 hidden lg:block">{{ $song->duration ?? '3:24' }}</span>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="py-8">
            {{ $likedSongs->links() }}
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="flex-1 flex items-center justify-center">
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Songs you like will appear here</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Save songs by tapping the heart.</p>
            <a href="{{ route('music.index') }}" class="inline-flex items-center px-6 py-3 bg-spotify-green text-white font-semibold rounded-full hover:bg-green-600 transition-colors">
                Find Music
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
async function toggleLike(musicId) {
    try {
        const response = await fetch('/music/toggle-like', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
            },
            body: JSON.stringify({ music_id: musicId })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Remove the row from liked songs page since it was unliked
            if (data.action === 'unliked') {
                location.reload();
            }
        }
    } catch (error) {
        console.error('Error toggling like:', error);
    }
}
</script>
@endpush