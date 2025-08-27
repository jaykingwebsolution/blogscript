@extends('admin.layout')

@section('title', 'Edit Playlist - ' . $playlist->title)

@section('header', 'Edit Playlist')

@section('content')
<div class="flex-1 p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.playlists.show', $playlist) }}" class="w-10 h-10 bg-spotify-gray rounded-full flex items-center justify-center hover:bg-spotify-light-gray transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-white">Edit Playlist</h1>
                    <p class="text-spotify-light-gray mt-1">Update playlist information and track list</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.playlists.update', $playlist) }}" enctype="multipart/form-data" class="bg-spotify-gray rounded-xl border border-spotify-gray p-8">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-6">Basic Information</h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Playlist Title -->
                    <div class="lg:col-span-2">
                        <label for="title" class="block text-sm font-medium text-spotify-light-gray mb-2">Playlist Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $playlist->title) }}" 
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent"
                               placeholder="Enter playlist title">
                        @error('title')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Playlist Owner -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-spotify-light-gray mb-2">Playlist Owner *</label>
                        <select name="user_id" id="user_id" 
                                class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent">
                            <option value="">Select a user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $playlist->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visibility -->
                    <div>
                        <label for="visibility" class="block text-sm font-medium text-spotify-light-gray mb-2">Visibility *</label>
                        <select name="visibility" id="visibility" 
                                class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent">
                            <option value="public" {{ old('visibility', $playlist->visibility) === 'public' ? 'selected' : '' }}>Public</option>
                            <option value="unlisted" {{ old('visibility', $playlist->visibility) === 'unlisted' ? 'selected' : '' }}>Unlisted</option>
                            <option value="private" {{ old('visibility', $playlist->visibility) === 'private' ? 'selected' : '' }}>Private</option>
                        </select>
                        @error('visibility')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <label for="description" class="block text-sm font-medium text-spotify-light-gray mb-2">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent"
                                  placeholder="Describe this playlist...">{{ old('description', $playlist->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Cover Image -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-6">Cover Image</h2>
                
                <div class="flex items-start space-x-6">
                    <div class="flex-1">
                        <label for="cover_image" class="block text-sm font-medium text-spotify-light-gray mb-2">Upload New Cover Image</label>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent">
                        <p class="text-xs text-spotify-light-gray mt-1">Leave empty to keep current image. Supported formats: JPEG, PNG, GIF. Max size: 5MB</p>
                        @error('cover_image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-32 h-32 bg-spotify-black border-2 border-dashed border-spotify-light-gray rounded-lg flex items-center justify-center">
                        @if($playlist->cover_image)
                            <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="Current cover" class="w-full h-full object-cover rounded-lg" id="currentCover">
                        @else
                            <svg class="w-8 h-8 text-spotify-light-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Music Selection -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-6">Music Selection</h2>
                
                <div class="bg-spotify-black rounded-lg p-6 border border-spotify-light-gray">
                    <div class="mb-4">
                        <input type="text" id="musicSearch" placeholder="Search for music to add..."
                               class="w-full bg-spotify-dark-gray border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent">
                    </div>
                    
                    <div class="max-h-96 overflow-y-auto">
                        @foreach($availableMusic as $track)
                            <div class="flex items-center space-x-4 p-3 hover:bg-spotify-gray rounded-lg transition-colors music-item">
                                <input type="checkbox" name="music_ids[]" value="{{ $track->id }}" 
                                       {{ in_array($track->id, $selectedMusicIds) ? 'checked' : '' }}
                                       class="rounded bg-spotify-black border-spotify-light-gray text-spotify-green">
                                <div class="flex-1">
                                    <h4 class="text-white font-medium">{{ $track->title }}</h4>
                                    <p class="text-spotify-light-gray text-sm">{{ $track->artist_name }}</p>
                                </div>
                                <span class="text-xs text-spotify-light-gray bg-spotify-gray px-2 py-1 rounded">
                                    {{ ucfirst($track->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($availableMusic->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-spotify-light-gray mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                            <p class="text-spotify-light-gray">No published music available</p>
                        </div>
                    @endif
                </div>

                <!-- Current Tracks -->
                @if($playlist->music->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Current Tracks in Playlist</h3>
                        <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                            <div class="space-y-2">
                                @foreach($playlist->music as $index => $track)
                                    <div class="flex items-center space-x-4 p-3 bg-spotify-gray rounded-lg">
                                        <span class="text-spotify-light-gray text-sm w-6">{{ $index + 1 }}</span>
                                        <div class="flex-1">
                                            <h4 class="text-white font-medium">{{ $track->title }}</h4>
                                            <p class="text-spotify-light-gray text-sm">{{ $track->artist_name }}</p>
                                        </div>
                                        <span class="text-xs text-spotify-light-gray bg-spotify-black px-2 py-1 rounded">
                                            {{ ucfirst($track->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Settings -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-6">Settings</h2>
                
                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                           {{ old('is_featured', $playlist->is_featured) ? 'checked' : '' }}
                           class="rounded bg-spotify-black border-spotify-light-gray text-spotify-green">
                    <label for="is_featured" class="text-white font-medium">Feature this playlist</label>
                </div>
                <p class="text-sm text-spotify-light-gray mt-1">Featured playlists appear in highlighted sections across the platform</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-spotify-light-gray">
                <a href="{{ route('admin.playlists.show', $playlist) }}" 
                   class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <div class="flex space-x-3">
                    <button type="button" onclick="confirmDelete()" 
                            class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                    <button type="submit" 
                            class="bg-spotify-green text-white px-6 py-3 rounded-lg hover:bg-spotify-green-light transition-colors">
                        Update Playlist
                    </button>
                </div>
            </div>
        </form>
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
document.addEventListener('DOMContentLoaded', function() {
    // Music search functionality
    const searchInput = document.getElementById('musicSearch');
    const musicItems = document.querySelectorAll('.music-item');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        musicItems.forEach(item => {
            const title = item.querySelector('h4').textContent.toLowerCase();
            const artist = item.querySelector('p').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || artist.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Cover image preview
    const coverImageInput = document.getElementById('cover_image');
    const previewContainer = document.querySelector('.w-32.h-32');
    
    coverImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-lg">`;
            };
            reader.readAsDataURL(file);
        }
    });
});

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