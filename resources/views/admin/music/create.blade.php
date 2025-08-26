@extends('admin.layout')

@section('title', 'Add New Music')
@section('header', 'Add New Music')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Create Music Track</h2>
        <a href="{{ route('admin.music.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Music
        </a>
    </div>

    <form method="POST" action="{{ route('admin.music.store') }}" enctype="multipart/form-data" class="bg-spotify-gray shadow rounded-lg border border-spotify-gray">
        @csrf
        
        <div class="px-6 py-4 border-b border-spotify-gray">
            <h3 class="text-lg leading-6 font-medium text-white">Music Information</h3>
            <p class="mt-1 text-sm text-spotify-light-gray">Add a new music track to your platform.</p>
        </div>

        <div class="px-6 py-4 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-white mb-2">Track Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="artist_name" class="block text-sm font-medium text-white mb-2">Artist Name *</label>
                    <input type="text" name="artist_name" id="artist_name" value="{{ old('artist_name') }}" required
                           class="w-full px-3 py-2 bg-spotify-dark-gray border border-spotify-light-gray text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green @error('artist_name') border-red-500 @enderror">
                    @error('artist_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('description') border-red-500 @enderror"
                          placeholder="Describe this music track...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Track Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
                    <select name="genre" id="genre"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('genre') border-red-500 @enderror">
                        <option value="">Select Genre</option>
                        <option value="Afrobeats" {{ old('genre') === 'Afrobeats' ? 'selected' : '' }}>Afrobeats</option>
                        <option value="Highlife" {{ old('genre') === 'Highlife' ? 'selected' : '' }}>Highlife</option>
                        <option value="Gospel" {{ old('genre') === 'Gospel' ? 'selected' : '' }}>Gospel</option>
                        <option value="Hip-Hop" {{ old('genre') === 'Hip-Hop' ? 'selected' : '' }}>Hip-Hop</option>
                        <option value="R&B" {{ old('genre') === 'R&B' ? 'selected' : '' }}>R&B</option>
                        <option value="Jazz" {{ old('genre') === 'Jazz' ? 'selected' : '' }}>Jazz</option>
                        <option value="Pop" {{ old('genre') === 'Pop' ? 'selected' : '' }}>Pop</option>
                        <option value="Reggae" {{ old('genre') === 'Reggae' ? 'selected' : '' }}>Reggae</option>
                        <option value="Folk" {{ old('genre') === 'Folk' ? 'selected' : '' }}>Folk</option>
                        <option value="Other" {{ old('genre') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('genre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('duration') border-red-500 @enderror"
                           placeholder="e.g. 3:45">
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Format: MM:SS (e.g. 3:45)</p>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" id="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('status') border-red-500 @enderror">
                        <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- File Upload Section -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-gray-800 mb-4">File Uploads</h4>
                
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('cover_image') border-red-500 @enderror">
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Accepted formats: JPEG, PNG, JPG, GIF, WEBP (Max: 5MB)</p>
                </div>

                <div>
                    <label for="audio_file" class="block text-sm font-medium text-gray-700 mb-2">Audio File *</label>
                    <input type="file" name="audio_file" id="audio_file" accept="audio/mp3,audio/wav,audio/ogg,audio/m4a" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('audio_file') border-red-500 @enderror">
                    @error('audio_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Accepted formats: MP3, WAV, OGG, M4A (Max: 50MB)</p>
                </div>
            </div>

            <!-- Alternative URL Section (Optional) -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-gray-800 mb-4">Alternative: External URLs (Optional)</h4>
                <p class="text-sm text-gray-600 mb-4">Use these fields if you prefer to use external URLs instead of uploading files.</p>
                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">Cover Image URL</label>
                    <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('image_url') border-red-500 @enderror"
                           placeholder="https://example.com/cover-image.jpg">
                    @error('image_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Direct URL to track's cover image</p>
                </div>

                <div>
                    <label for="music_url" class="block text-sm font-medium text-gray-700 mb-2">Music File URL</label>
                    <input type="url" name="music_url" id="music_url" value="{{ old('music_url') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('music_url') border-red-500 @enderror"
                           placeholder="https://example.com/music-file.mp3">
                    @error('music_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Direct URL to audio file (.mp3, .wav, etc.)</p>
                </div>

                <div>
                    <label for="download_url" class="block text-sm font-medium text-gray-700 mb-2">Download URL</label>
                    <input type="url" name="download_url" id="download_url" value="{{ old('download_url') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('download_url') border-red-500 @enderror"
                           placeholder="https://example.com/download-link">
                    @error('download_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Optional download link for users</p>
                </div>
            </div>

            <!-- Featured Option -->
            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                    Mark as featured track
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
                Create Music
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