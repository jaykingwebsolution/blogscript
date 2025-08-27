@extends('admin.layout')

@section('title', 'Playlist Details - ' . $playlist->title)

@section('header', 'Playlist Details')

@section('content')
<div class="flex-1 p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <a href="{{ route('admin.playlists.index') }}" class="w-10 h-10 bg-spotify-gray rounded-full flex items-center justify-center hover:bg-spotify-light-gray transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white">{{ $playlist->title }}</h1>
                    <p class="text-spotify-light-gray mt-1">Created by {{ $playlist->user->name }} • {{ $playlist->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.playlists.edit', $playlist) }}" 
                       class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    @if($playlist->is_featured)
                        <form method="POST" action="{{ route('admin.playlists.unfeature', $playlist) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="bg-spotify-green text-white px-4 py-2 rounded-lg hover:bg-spotify-green-light transition-colors">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Unfeature
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.playlists.feature', $playlist) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Feature
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Playlist Info -->
            <div class="lg:col-span-1">
                <div class="bg-spotify-gray rounded-xl border border-spotify-gray overflow-hidden">
                    <!-- Cover Image -->
                    <div class="aspect-square bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                        @if($playlist->cover_image)
                            <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->title }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        @endif
                    </div>
                    
                    <!-- Playlist Details -->
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Status Badges -->
                            <div class="flex flex-wrap gap-2">
                                @if($playlist->is_featured)
                                    <span class="px-3 py-1 text-xs font-medium bg-spotify-green bg-opacity-20 text-spotify-green rounded-full">
                                        ★ Featured
                                    </span>
                                @endif
                                <span class="px-3 py-1 text-xs font-medium bg-blue-500 bg-opacity-20 text-blue-400 rounded-full">
                                    {{ ucfirst($playlist->visibility) }}
                                </span>
                            </div>

                            <!-- Description -->
                            @if($playlist->description)
                                <div>
                                    <h3 class="text-white font-semibold mb-2">Description</h3>
                                    <p class="text-spotify-light-gray text-sm">{{ $playlist->description }}</p>
                                </div>
                            @endif

                            <!-- Statistics -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-spotify-black rounded-lg">
                                    <p class="text-2xl font-bold text-white">{{ $playlist->music->count() }}</p>
                                    <p class="text-xs text-spotify-light-gray">Tracks</p>
                                </div>
                                <div class="text-center p-3 bg-spotify-black rounded-lg">
                                    <p class="text-2xl font-bold text-white">{{ $playlist->formatted_duration }}</p>
                                    <p class="text-xs text-spotify-light-gray">Duration</p>
                                </div>
                            </div>

                            <!-- Creator Info -->
                            <div>
                                <h3 class="text-white font-semibold mb-2">Creator</h3>
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-spotify-green rounded-full flex items-center justify-center">
                                        <span class="text-sm font-bold text-white">{{ strtoupper(substr($playlist->user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">{{ $playlist->user->name }}</p>
                                        <p class="text-spotify-light-gray text-sm">{{ ucfirst($playlist->user->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="space-y-2 pt-4 border-t border-spotify-light-gray">
                                <div class="flex justify-between">
                                    <span class="text-spotify-light-gray text-sm">Created:</span>
                                    <span class="text-white text-sm">{{ $playlist->created_at->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-spotify-light-gray text-sm">Last Updated:</span>
                                    <span class="text-white text-sm">{{ $playlist->updated_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tracks List -->
            <div class="lg:col-span-2">
                <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
                    <div class="p-6 border-b border-spotify-light-gray">
                        <h2 class="text-xl font-semibold text-white">Tracks ({{ $playlist->music->count() }})</h2>
                    </div>
                    
                    <div class="p-6">
                        @if($playlist->music->count() > 0)
                            <div class="space-y-3">
                                @foreach($playlist->music as $index => $track)
                                    <div class="flex items-center space-x-4 p-4 bg-spotify-black rounded-lg hover:bg-spotify-dark-gray transition-colors">
                                        <!-- Track Number -->
                                        <div class="w-8 text-center">
                                            <span class="text-spotify-light-gray text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        
                                        <!-- Track Info -->
                                        <div class="flex-1">
                                            <h4 class="text-white font-medium">{{ $track->title }}</h4>
                                            <p class="text-spotify-light-gray text-sm">{{ $track->artist_name }}</p>
                                        </div>
                                        
                                        <!-- Duration -->
                                        @if($track->duration)
                                            <div class="text-spotify-light-gray text-sm">
                                                {{ gmdate('i:s', $track->duration) }}
                                            </div>
                                        @endif
                                        
                                        <!-- Status -->
                                        <div>
                                            @if($track->status === 'published')
                                                <span class="px-2 py-1 text-xs font-medium bg-green-500 bg-opacity-20 text-green-400 rounded-full">
                                                    Published
                                                </span>
                                            @elseif($track->status === 'pending')
                                                <span class="px-2 py-1 text-xs font-medium bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-full">
                                                    Pending
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium bg-red-500 bg-opacity-20 text-red-400 rounded-full">
                                                    {{ ucfirst($track->status) }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="flex space-x-1">
                                            <a href="{{ route('admin.music.show', $track) }}" 
                                               class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors"
                                               title="View Track">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.music.edit', $track) }}" 
                                               class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center hover:bg-yellow-700 transition-colors"
                                               title="Edit Track">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-spotify-light-gray mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                                <h3 class="text-white text-xl font-semibold mb-2">No tracks in playlist</h3>
                                <p class="text-spotify-light-gray mb-4">This playlist doesn't contain any music tracks yet.</p>
                                <a href="{{ route('admin.playlists.edit', $playlist) }}" 
                                   class="bg-spotify-green text-white px-6 py-3 rounded-lg hover:bg-spotify-green-light transition-colors">
                                    Add Tracks
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="mt-8">
            <div class="bg-red-900 bg-opacity-20 border border-red-500 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-red-400 mb-4">Danger Zone</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-medium">Delete Playlist</h3>
                        <p class="text-spotify-light-gray text-sm">This action cannot be undone. This will permanently delete the playlist and remove all track associations.</p>
                    </div>
                    <button onclick="confirmDelete()" 
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        Delete Playlist
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="bg-spotify-gray rounded-xl border border-spotify-light-gray p-8 max-w-md mx-4">
        <h3 class="text-xl font-semibold text-white mb-4">Confirm Deletion</h3>
        <p class="text-spotify-light-gray mb-6">Are you sure you want to delete "{{ $playlist->title }}"? This action cannot be undone.</p>
        <div class="flex space-x-4">
            <button onclick="hideDeleteModal()" 
                    class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                Cancel
            </button>
            <form method="POST" action="{{ route('admin.playlists.destroy', $playlist) }}" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function hideDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDeleteModal();
    }
});
</script>
@endsection