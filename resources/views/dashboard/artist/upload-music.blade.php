@extends('layouts.artist-dashboard')

@section('dashboard-content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Upload Music</h1>
        <p class="text-gray-300">Share your latest tracks with the world</p>
    </div>

    <!-- Upload Form -->
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('dashboard.artist.upload-music.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Track Information -->
            <div class="bg-gray-800 rounded-xl p-6">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                    </svg>
                    Track Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Track Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                               class="w-full bg-gray-700 border border-gray-600 text-white placeholder-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                               placeholder="Enter track title">
                        @error('title')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Genre *</label>
                        <select name="genre" required class="w-full bg-gray-700 border border-gray-600 text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Select Genre</option>
                            <option value="Afrobeats" {{ old('genre') == 'Afrobeats' ? 'selected' : '' }}>Afrobeats</option>
                            <option value="Hip Hop" {{ old('genre') == 'Hip Hop' ? 'selected' : '' }}>Hip Hop</option>
                            <option value="R&B" {{ old('genre') == 'R&B' ? 'selected' : '' }}>R&B</option>
                            <option value="Pop" {{ old('genre') == 'Pop' ? 'selected' : '' }}>Pop</option>
                            <option value="Reggae" {{ old('genre') == 'Reggae' ? 'selected' : '' }}>Reggae</option>
                            <option value="Dancehall" {{ old('genre') == 'Dancehall' ? 'selected' : '' }}>Dancehall</option>
                            <option value="Highlife" {{ old('genre') == 'Highlife' ? 'selected' : '' }}>Highlife</option>
                            <option value="Gospel" {{ old('genre') == 'Gospel' ? 'selected' : '' }}>Gospel</option>
                            <option value="Jazz" {{ old('genre') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                            <option value="Electronic" {{ old('genre') == 'Electronic' ? 'selected' : '' }}>Electronic</option>
                            <option value="Rock" {{ old('genre') == 'Rock' ? 'selected' : '' }}>Rock</option>
                            <option value="Alternative" {{ old('genre') == 'Alternative' ? 'selected' : '' }}>Alternative</option>
                            <option value="Other" {{ old('genre') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('genre')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full bg-gray-700 border border-gray-600 text-white placeholder-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                  placeholder="Tell us about your track...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Release Date</label>
                        <input type="date" name="release_date" value="{{ old('release_date', now()->format('Y-m-d')) }}"
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('release_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- File Uploads -->
            <div class="bg-gray-800 rounded-xl p-6">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    File Uploads
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Audio File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Audio File *</label>
                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-purple-500 transition-colors">
                            <input type="file" name="audio_file" accept=".mp3,.wav" required class="hidden" id="audio-upload">
                            <label for="audio-upload" class="cursor-pointer">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                                <p class="text-gray-300 font-medium">Upload Audio File</p>
                                <p class="text-gray-400 text-sm">MP3 or WAV (max 50MB)</p>
                            </label>
                        </div>
                        @error('audio_file')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Cover Image</label>
                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-purple-500 transition-colors">
                            <input type="file" name="cover_image" accept=".jpg,.jpeg,.png" class="hidden" id="cover-upload">
                            <label for="cover-upload" class="cursor-pointer">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-gray-300 font-medium">Upload Cover Image</p>
                                <p class="text-gray-400 text-sm">JPG, PNG (max 5MB)</p>
                            </label>
                        </div>
                        @error('cover_image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Upload Guidelines -->
            <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                <h3 class="font-semibold text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Upload Guidelines
                </h3>
                <div class="text-sm text-gray-300 space-y-2">
                    <p>• <strong>Audio Quality:</strong> Upload high-quality audio files (minimum 320kbps)</p>
                    <p>• <strong>Copyright:</strong> Only upload original music or music you have rights to</p>
                    <p>• <strong>Content:</strong> Ensure your music meets our community guidelines</p>
                    <p>• <strong>Review Process:</strong> All uploads are reviewed before going live (typically 1-3 business days)</p>
                    <p>• <strong>File Formats:</strong> MP3 (recommended) or WAV for audio, JPG or PNG for artwork</p>
                    <p>• <strong>Metadata:</strong> Accurate track information helps with discovery</p>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard.artist') }}" class="text-gray-400 hover:text-white font-medium">
                    ← Back to Dashboard
                </a>
                
                <div class="space-x-4">
                    <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-full transition-colors"
                            onclick="document.querySelector('form').reset()">
                        Clear Form
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-8 rounded-full transition-all transform hover:scale-105 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        Upload Track
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// File upload preview functionality
document.getElementById('audio-upload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const label = e.target.nextElementSibling;
        label.innerHTML = `
            <svg class="w-12 h-12 text-green-400 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
            </svg>
            <p class="text-green-400 font-medium">${file.name}</p>
            <p class="text-gray-400 text-sm">${(file.size / 1024 / 1024).toFixed(1)}MB</p>
        `;
    }
});

document.getElementById('cover-upload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const label = document.querySelector('[for="cover-upload"]');
            label.innerHTML = `
                <img src="${e.target.result}" class="w-24 h-24 object-cover rounded mx-auto mb-2">
                <p class="text-green-400 font-medium">${file.name}</p>
                <p class="text-gray-400 text-sm">${(file.size / 1024 / 1024).toFixed(1)}MB</p>
            `;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection