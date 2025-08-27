@extends('admin.layout')

@section('title', 'Edit Music')
@section('header', 'Edit Music')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Edit Music Track</h2>
        <a href="{{ route('admin.music.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Music
        </a>
    </div>

    <form method="POST" action="{{ route('admin.music.update', $music) }}" enctype="multipart/form-data" class="bg-spotify-gray shadow rounded-lg border border-spotify-gray">
        @csrf
        @method('PUT')
        
        <div class="px-6 py-4 border-b border-spotify-gray">
            <h3 class="text-lg leading-6 font-medium text-white">Music Information</h3>
            <p class="mt-1 text-sm text-spotify-light-gray">Edit music track details.</p>
        </div>

        <div class="px-6 py-4 space-y-6">
            <!-- Basic Information -->
            <div class="form-grid grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-white mb-2">Track Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $music->title) }}" required
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="artist_name" class="block text-sm font-medium text-white mb-2">Artist Name *</label>
                    <input type="text" name="artist_name" id="artist_name" value="{{ old('artist_name', $music->artist_name) }}" required
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('artist_name') border-red-500 @enderror">
                    @error('artist_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-white mb-2">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('description') border-red-500 @enderror">{{ old('description', $music->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Additional Information -->
            <div class="form-grid grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="genre" class="block text-sm font-medium text-white mb-2">Genre</label>
                    <input type="text" name="genre" id="genre" value="{{ old('genre', $music->genre) }}"
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('genre') border-red-500 @enderror"
                           placeholder="e.g., Pop, Rock, Hip-Hop">
                    @error('genre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-medium text-white mb-2">Duration</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration', $music->duration) }}"
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('duration') border-red-500 @enderror"
                           placeholder="e.g., 3:45">
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-grid grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="release_date" class="block text-sm font-medium text-white mb-2">Release Date</label>
                    <input type="date" name="release_date" id="release_date" value="{{ old('release_date', $music->release_date ? $music->release_date->format('Y-m-d') : '') }}"
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('release_date') border-red-500 @enderror">
                    @error('release_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-white mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('status') border-red-500 @enderror">
                        <option value="draft" {{ old('status', $music->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $music->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="pending" {{ old('status', $music->status) == 'pending' ? 'selected' : '' }}>Pending Review</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Current Files Display -->
            @if($music->cover_image || $music->image_url)
            <div class="bg-spotify-dark-gray p-4 rounded-lg">
                <h4 class="text-md font-medium text-white mb-4">Current Cover Image</h4>
                <img src="{{ $music->cover_image ? Storage::url($music->cover_image) : $music->image_url }}" 
                     alt="{{ $music->title }}" class="w-32 h-32 object-cover rounded-lg">
            </div>
            @endif

            @if($music->audio_file || $music->music_url)
            <div class="bg-spotify-dark-gray p-4 rounded-lg">
                <h4 class="text-md font-medium text-white mb-4">Current Audio File</h4>
                <audio controls class="w-full">
                    <source src="{{ $music->audio_file ? Storage::url($music->audio_file) : $music->music_url }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>
            @endif

            <!-- File Upload Section -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-white mb-4">Update Files (Optional)</h4>
                <p class="text-sm text-spotify-light-gray mb-4">Leave empty to keep current files</p>
                
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-white mb-2">New Cover Image</label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('cover_image') border-red-500 @enderror">
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-spotify-light-gray">Accepted formats: JPEG, PNG, JPG, GIF, WEBP (Max: 5MB)</p>
                </div>

                <div>
                    <label for="audio_file" class="block text-sm font-medium text-white mb-2">New Audio File</label>
                    <input type="file" name="audio_file" id="audio_file" accept="audio/mp3,audio/wav,audio/ogg,audio/m4a"
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('audio_file') border-red-500 @enderror">
                    @error('audio_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-spotify-light-gray">Accepted formats: MP3, WAV, OGG, M4A (Max: 50MB)</p>
                </div>
            </div>

            <!-- Alternative URL Section (Optional) -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-white mb-4">Alternative: External URLs</h4>
                <p class="text-sm text-spotify-light-gray mb-4">Use these fields if you prefer to use external URLs instead of uploading files.</p>
                <div>
                    <label for="image_url" class="block text-sm font-medium text-white mb-2">Cover Image URL</label>
                    <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $music->image_url) }}"
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('image_url') border-red-500 @enderror"
                           placeholder="https://example.com/cover-image.jpg">
                    @error('image_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-spotify-light-gray">Direct URL to track's cover image</p>
                </div>

                <div>
                    <label for="music_url" class="block text-sm font-medium text-white mb-2">Music File URL</label>
                    <input type="url" name="music_url" id="music_url" value="{{ old('music_url', $music->music_url) }}"
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('music_url') border-red-500 @enderror"
                           placeholder="https://example.com/music-file.mp3">
                    @error('music_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-spotify-light-gray">Direct URL to the audio file</p>
                </div>

                <div>
                    <label for="download_url" class="block text-sm font-medium text-white mb-2">Download URL</label>
                    <input type="url" name="download_url" id="download_url" value="{{ old('download_url', $music->download_url) }}"
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('download_url') border-red-500 @enderror"
                           placeholder="https://example.com/download/music-file.mp3">
                    @error('download_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-spotify-light-gray">Download URL for the track (if different from stream URL)</p>
                </div>
            </div>

            <!-- Featured Option -->
            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                       {{ old('is_featured', $music->is_featured) ? 'checked' : '' }}
                       class="h-4 w-4 text-spotify-green focus:ring-spotify-green border-gray-300 rounded">
                <label for="is_featured" class="ml-2 block text-sm text-white">
                    Feature this music (will appear in featured section)
                </label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-spotify-gray border-t border-spotify-dark-gray flex justify-end space-x-3">
            <a href="{{ route('admin.music.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-spotify-green text-white px-6 py-2 rounded hover:bg-green-600 transition-colors">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Music
            </button>
        </div>
    </form>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function(e) {
    const title = e.target.value;
    // You can add slug preview functionality here if needed
});
</script>
@endsection