@extends('layouts.app')

@section('title', 'Edit Playlist - ' . $playlist->title)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Playlist</h1>
                    <a href="{{ route('playlists.show', $playlist) }}" 
                       class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
            </div>

            <form action="{{ route('playlists.update', $playlist) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
                <!-- Current Cover Image -->
                @if($playlist->cover_image)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Cover</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $playlist->cover_image) }}" 
                             alt="Current cover" 
                             class="w-20 h-20 rounded-lg object-cover">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Upload a new image to replace this cover</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Cover Image -->
                <div class="mb-6">
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cover Image {{ $playlist->cover_image ? '(Replace)' : '' }}
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="cover_image" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('cover_image')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Playlist Title *
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $playlist->title) }}"
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                           placeholder="Enter playlist title"
                           required>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                              placeholder="Describe your playlist (optional)">{{ old('description', $playlist->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Visibility -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Visibility *
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="visibility" 
                                   value="public" 
                                   {{ old('visibility', $playlist->visibility) === 'public' ? 'checked' : '' }}
                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Public</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Anyone can search for and view this playlist</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="visibility" 
                                   value="unlisted" 
                                   {{ old('visibility', $playlist->visibility) === 'unlisted' ? 'checked' : '' }}
                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Unlisted</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Only people with the link can view this playlist</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="visibility" 
                                   value="private" 
                                   {{ old('visibility', $playlist->visibility) === 'private' ? 'checked' : '' }}
                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Private</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Only you can view this playlist</p>
                            </div>
                        </label>
                    </div>
                    @error('visibility')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0">
                    <a href="{{ route('playlists.show', $playlist) }}" 
                       class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Playlist
                    </button>
                </div>
            </form>
        </div>

        <!-- Current Songs (if any) -->
        @if($playlist->music->count() > 0)
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg mt-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Current Songs ({{ $playlist->music->count() }})</h2>
            </div>
            
            <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-80 overflow-y-auto">
                @foreach($playlist->music->sortBy('pivot.order_in_playlist') as $index => $music)
                    <div class="px-6 py-3 flex items-center space-x-3">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-6">{{ $index + 1 }}</span>
                        
                        @if($music->artwork)
                            <img src="{{ asset('storage/' . $music->artwork) }}" alt="{{ $music->title }}" class="w-8 h-8 rounded object-cover">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $music->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $music->artist->stage_name ?? 'Unknown Artist' }}</p>
                        </div>
                        
                        <button onclick="removeSong({{ $music->id }})" 
                                class="text-red-400 hover:text-red-600 dark:hover:text-red-300 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
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

// Handle file input change
document.getElementById('cover_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add preview functionality here if desired
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection