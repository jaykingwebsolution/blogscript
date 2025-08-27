@extends('layouts.app')

@section('title', $playlist->title)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                    <!-- Cover Image -->
                    <div class="flex-shrink-0 mb-4 md:mb-0">
                        @if($playlist->cover_image)
                            <img src="{{ asset('storage/' . $playlist->cover_image) }}" 
                                 alt="{{ $playlist->title }}" 
                                 class="w-32 h-32 rounded-lg object-cover shadow-lg">
                        @else
                            <div class="w-32 h-32 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM15.657 6.343a1 1 0 011.414 0A9.972 9.972 0 0119 12a9.972 9.972 0 01-1.929 5.657 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 12c0-1.772-.579-3.409-1.564-4.657a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M13.828 8.172a1 1 0 011.414 0A5.983 5.983 0 0117 12a5.983 5.983 0 01-1.758 3.828 1 1 0 01-1.414-1.414A3.983 3.983 0 0015 12c0-.737-.268-1.411-.707-1.828a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Playlist Info -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $playlist->title }}</h1>
                        
                        @if($playlist->description)
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $playlist->description }}</p>
                        @endif
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                By {{ $playlist->user->name }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM15.657 6.343a1 1 0 011.414 0A9.972 9.972 0 0119 12a9.972 9.972 0 01-1.929 5.657 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 12c0-1.772-.579-3.409-1.564-4.657a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                {{ $playlist->music->count() }} songs
                            </div>
                            <div class="flex items-center">
                                @if($playlist->visibility === 'public')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414-1.414L9 7.586 7.707 6.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 000-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Public
                                    </span>
                                @elseif($playlist->visibility === 'unlisted')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
                                        </svg>
                                        Unlisted
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Private
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        @auth
                        @if($playlist->user_id === Auth::id())
                        <div class="flex flex-wrap gap-2 mt-4">
                            <a href="{{ route('playlists.edit', $playlist) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Playlist
                            </a>
                            <button onclick="confirmDelete()" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Music List -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Songs</h2>
            </div>
            
            @if($playlist->music->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($playlist->music->sortBy('pivot.order_in_playlist') as $index => $music)
                        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center space-x-4">
                                <!-- Track Number -->
                                <div class="flex-shrink-0 w-8 text-center">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $index + 1 }}</span>
                                </div>
                                
                                <!-- Album Art -->
                                <div class="flex-shrink-0">
                                    @if($music->artwork)
                                        <img src="{{ asset('storage/' . $music->artwork) }}" alt="{{ $music->title }}" class="w-12 h-12 rounded object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Song Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2">
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $music->title }}</h3>
                                        @if($music->explicit)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">E</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $music->artist->stage_name ?? 'Unknown Artist' }}</p>
                                </div>
                                
                                <!-- Duration -->
                                @if($music->duration)
                                <div class="flex-shrink-0">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ gmdate('i:s', $music->duration) }}</span>
                                </div>
                                @endif
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('music.show', $music->slug) }}" 
                                           class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-5.4-6.519a9 9 0 017.8 7.519C17.4 12 16.6 13 15 13H9c-1.6 0-2.4-1-2.4-1.5V5.481a9 9 0 017.8.019z"/>
                                            </svg>
                                        </a>
                                        
                                        @auth
                                        @if($playlist->user_id === Auth::id())
                                            <button onclick="removeSong({{ $music->id }})" 
                                                    class="text-red-400 hover:text-red-600 dark:hover:text-red-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No songs yet</h3>
                    <p class="text-gray-600 dark:text-gray-400">This playlist doesn't have any songs yet.</p>
                    @auth
                    @if($playlist->user_id === Auth::id())
                        <a href="{{ route('music.index') }}" 
                           class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Browse Music to Add
                        </a>
                    @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</div>

@auth
@if($playlist->user_id === Auth::id())
<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm mx-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Delete Playlist</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to delete this playlist? This action cannot be undone.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium">Cancel</button>
            <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

function removeSong(musicId) {
    if (!confirm('Remove this song from the playlist?')) return;
    
    fetch(`/playlists/{{ $playlist->id }}/music/${musicId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Failed to remove song');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>
@endif
@endauth
@endsection