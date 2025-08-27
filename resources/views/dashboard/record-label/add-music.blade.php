@extends('layouts.app')

@section('title', 'Add Music - Record Label - MusicStream')

@section('content')
<div class="min-h-screen bg-black text-white">
    <div class="max-w-4xl mx-auto px-8 py-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('dashboard.record-label') }}" class="inline-flex items-center text-gray-400 hover:text-blue-400 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 12H5m7-7l-7 7 7 7"/>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Header -->
        <div class="text-center mb-12">
            <div class="bg-gradient-to-br from-blue-400 to-blue-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-4">Add Music</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Upload music for your artists to the platform.
            </p>
        </div>

        <!-- Upload Form -->
        <form action="{{ route('dashboard.record-label.add-music.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Track Information -->
            <div class="bg-gray-900 rounded-xl p-8 border border-gray-800">
                <h2 class="text-2xl font-bold mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                    </svg>
                    Track Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Track Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                               class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-400 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter track title">
                        @error('title')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Artist Name *</label>
                        <input type="text" name="artist_name" value="{{ old('artist_name') }}" required 
                               class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-400 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter artist name">
                        @error('artist_name')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Genre *</label>
                        <select name="genre" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Release Date</label>
                        <input type="date" name="release_date" value="{{ old('release_date', now()->format('Y-m-d')) }}"
                               class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('release_date')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-3">Description</label>
                        <textarea name="description" rows="4" class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-400 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Tell us about this track...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- File Uploads -->
            <div class="bg-gray-900 rounded-xl p-8 border border-gray-800">
                <h2 class="text-2xl font-bold mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    File Uploads
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Audio File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Audio File *</label>
                        <div class="border-2 border-dashed border-gray-700 rounded-xl p-8 text-center hover:border-blue-500 transition-all duration-200 bg-gray-800/50">
                            <input type="file" name="audio_file" accept=".mp3,.wav" required class="hidden" id="audio-upload">
                            <label for="audio-upload" class="cursor-pointer block">
                                <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                </svg>
                                <p class="text-white font-semibold mb-2">Upload Audio File</p>
                                <p class="text-gray-400 text-sm">MP3 or WAV format (max 50MB)</p>
                            </label>
                        </div>
                        @error('audio_file')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Cover Image</label>
                        <div class="border-2 border-dashed border-gray-700 rounded-xl p-8 text-center hover:border-blue-500 transition-all duration-200 bg-gray-800/50">
                            <input type="file" name="cover_image" accept=".jpg,.jpeg,.png" class="hidden" id="cover-upload">
                            <label for="cover-upload" class="cursor-pointer block">
                                <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-white font-semibold mb-2">Upload Cover Image</p>
                                <p class="text-gray-400 text-sm">JPG or PNG format (max 5MB)</p>
                            </label>
                        </div>
                        @error('cover_image')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Upload Guidelines -->
            <div class="bg-blue-900/20 border border-blue-700/50 rounded-xl p-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-400 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-400 mb-3">Upload Guidelines</h3>
                        <div class="text-sm text-gray-300 space-y-1">
                            <p>• <strong>Copyright:</strong> Only upload original music or music you have rights to</p>
                            <p>• <strong>Quality:</strong> High-quality audio files (320kbps MP3 or WAV preferred)</p>
                            <p>• <strong>Content:</strong> Ensure your music meets our community guidelines</p>
                            <p>• <strong>Review Process:</strong> All uploads are reviewed before going live (typically 1-3 business days)</p>
                            <p>• <strong>Metadata:</strong> Accurate track information helps with discovery</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('dashboard.record-label') }}" class="text-gray-400 hover:text-white font-medium transition-colors">
                    ← Back to Dashboard
                </a>
                
                <div class="space-x-4">
                    <button type="button" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-full transition-colors"
                            onclick="document.querySelector('form').reset()">
                        Clear Form
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-full transition-all transform hover:scale-105 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        Upload Music
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
            <svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
            </svg>
            <p class="text-blue-400 font-semibold">${file.name}</p>
            <p class="text-gray-400 text-sm">${(file.size / 1024 / 1024).toFixed(1)}MB</p>
        `;
    }
});

document.getElementById('cover-upload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
            const label = e.target.parentNode.nextElementSibling || e.target.parentNode.querySelector('label');
            label.innerHTML = `
                <img src="${e.target.result}" class="w-24 h-24 mx-auto rounded-lg object-cover mb-4">
                <p class="text-blue-400 font-semibold">${file.name}</p>
                <p class="text-gray-400 text-sm">${(file.size / 1024 / 1024).toFixed(1)}MB</p>
            `;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection