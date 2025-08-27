@extends('admin.layout')

@section('title', 'Create Playlist')

@section('header', 'Create Playlist')

@section('content')
<div class="flex-1 p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.playlists.index') }}" class="w-10 h-10 bg-spotify-gray rounded-full flex items-center justify-center hover:bg-spotify-light-gray transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-white">Create New Playlist</h1>
                    <p class="text-spotify-light-gray mt-1">Create an admin-curated playlist for the platform</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.playlists.store') }}" enctype="multipart/form-data" class="bg-spotify-gray rounded-xl border border-spotify-gray p-8">
            @csrf
            
            <!-- Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-6">Basic Information</h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Playlist Title -->
                    <div class="lg:col-span-2">
                        <label for="title" class="block text-sm font-medium text-spotify-light-gray mb-2">Playlist Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" 
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
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                            <option value="public" {{ old('visibility') === 'public' ? 'selected' : '' }}>Public</option>
                            <option value="unlisted" {{ old('visibility') === 'unlisted' ? 'selected' : '' }}>Unlisted</option>
                            <option value="private" {{ old('visibility') === 'private' ? 'selected' : '' }}>Private</option>
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
                                  placeholder="Describe this playlist...">{{ old('description') }}</textarea>
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
                        <label for="cover_image" class="block text-sm font-medium text-spotify-light-gray mb-2">Upload Cover Image</label>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent">
                        <p class="text-xs text-spotify-light-gray mt-1">Supported formats: JPEG, PNG, GIF. Max size: 5MB</p>
                        @error('cover_image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-32 h-32 bg-spotify-black border-2 border-dashed border-spotify-light-gray rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-spotify-light-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
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
                        @foreach($music as $track)
                            <div class="flex items-center space-x-4 p-3 hover:bg-spotify-gray rounded-lg transition-colors music-item">
                                <input type="checkbox" name="music_ids[]" value="{{ $track->id }}" 
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
                    
                    @if($music->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-spotify-light-gray mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                            <p class="text-spotify-light-gray">No published music available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Settings -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-6">Settings</h2>
                
                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="rounded bg-spotify-black border-spotify-light-gray text-spotify-green">
                    <label for="is_featured" class="text-white font-medium">Feature this playlist</label>
                </div>
                <p class="text-sm text-spotify-light-gray mt-1">Featured playlists appear in highlighted sections across the platform</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-spotify-light-gray">
                <a href="{{ route('admin.playlists.index') }}" 
                   class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-spotify-green text-white px-6 py-3 rounded-lg hover:bg-spotify-green-light transition-colors">
                    Create Playlist
                </button>
            </div>
        </form>
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
</script>
@endsection