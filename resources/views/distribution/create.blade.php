@extends('layouts.app')

@section('title', 'Submit Music for Distribution')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-spotify-green/10 rounded-full">
                    <i class="fas fa-music text-spotify-green text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Music Distribution Submission</h1>
                    <p class="text-gray-600 dark:text-gray-400">Submit your music to be distributed to major streaming platforms</p>
                </div>
            </div>
        </div>

        <!-- Distribution Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form action="{{ route('distribution.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="artist_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Artist Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="artist_name" name="artist_name" value="{{ old('artist_name', auth()->user()->getDisplayName()) }}" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                               required>
                        @error('artist_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="song_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Song Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="song_title" name="song_title" value="{{ old('song_title') }}" 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                               required>
                        @error('song_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Genre <span class="text-red-500">*</span>
                        </label>
                        <select id="genre" name="genre" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                required>
                            <option value="">Select a genre</option>
                            @foreach($genres as $key => $value)
                                <option value="{{ $key }}" {{ old('genre') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('genre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="release_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Release Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="release_date" name="release_date" value="{{ old('release_date') }}" 
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                               required>
                        @error('release_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Enhanced Metadata Fields -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-info-circle text-spotify-green mr-2"></i>
                        Release Metadata
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- ISRC -->
                        <div>
                            <label for="isrc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                ISRC Code
                                <span class="text-xs text-gray-500">(International Standard Recording Code)</span>
                            </label>
                            <input type="text" id="isrc" name="isrc" value="{{ old('isrc') }}" 
                                   placeholder="e.g., USRC17607839"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty if you don't have one - we'll generate it for you</p>
                            @error('isrc')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- UPC -->
                        <div>
                            <label for="upc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                UPC/Barcode
                                <span class="text-xs text-gray-500">(Universal Product Code)</span>
                            </label>
                            <input type="text" id="upc" name="upc" value="{{ old('upc') }}" 
                                   placeholder="e.g., 123456789012"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty if you don't have one - we'll generate it for you</p>
                            @error('upc')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Record Label -->
                    <div class="mt-6">
                        <label for="record_label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Record Label
                        </label>
                        <input type="text" id="record_label" name="record_label" value="{{ old('record_label') }}" 
                               placeholder="Enter record label name (optional)"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('record_label')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Explicit Content -->
                    <div class="mt-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="explicit_content" name="explicit_content" value="1" 
                                   {{ old('explicit_content') ? 'checked' : '' }}
                                   class="h-4 w-4 text-spotify-green focus:ring-spotify-green border-gray-300 rounded">
                            <label for="explicit_content" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                This release contains explicit content
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Check this if your release contains profanity, sexual content, or mature themes</p>
                        @error('explicit_content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lyrics (Optional) -->
                <div class="mt-6">
                    <label for="lyrics" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Lyrics <span class="text-xs text-gray-500">(Optional)</span>
                    </label>
                    <textarea id="lyrics" name="lyrics" rows="6" placeholder="Enter your lyrics here..."
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('lyrics') }}</textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Adding lyrics can help with music discovery and may be displayed on some streaming platforms</p>
                    @error('lyrics')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Uploads -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cover Image <span class="text-red-500">*</span>
                            <span class="text-xs text-gray-500">(Max: 5MB, Format: JPG, PNG, GIF)</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-spotify-green transition-colors">
                            <div class="space-y-1 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400">
                                    <i class="fas fa-image text-3xl"></i>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <label for="cover_image" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-spotify-green hover:text-spotify-green/80">
                                        <span>Upload cover image</span>
                                        <input id="cover_image" name="cover_image" type="file" class="sr-only" accept=".jpg,.jpeg,.png,.gif" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                            </div>
                        </div>
                        @error('cover_image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="audio_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Audio File <span class="text-red-500">*</span>
                            <span class="text-xs text-gray-500">(Max: 50MB, Format: MP3, WAV, M4A, AAC)</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-spotify-green transition-colors">
                            <div class="space-y-1 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400">
                                    <i class="fas fa-file-audio text-3xl"></i>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <label for="audio_file" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-spotify-green hover:text-spotify-green/80">
                                        <span>Upload audio file</span>
                                        <input id="audio_file" name="audio_file" type="file" class="sr-only" accept=".mp3,.wav,.m4a,.aac" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                            </div>
                        </div>
                        @error('audio_file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description / Additional Info
                        <span class="text-xs text-gray-500">(Optional)</span>
                    </label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                              placeholder="Tell us more about your music, inspirations, or any additional information...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Distribution Info -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Distribution Information</h4>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                                <p>Your music will be submitted to major streaming platforms including:</p>
                                <ul class="mt-2 list-disc list-inside space-y-1">
                                    <li>Spotify</li>
                                    <li>Apple Music</li>
                                    <li>Boomplay</li>
                                    <li>Audiomack</li>
                                    <li>YouTube Music</li>
                                    <li>Amazon Music</li>
                                    <li>Deezer</li>
                                </ul>
                                <p class="mt-3">Review process typically takes 3-5 business days.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('distribution.my-submissions') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-400">
                        View My Submissions
                    </a>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-spotify-green text-white font-medium rounded-lg hover:bg-spotify-green/90 focus:ring-2 focus:ring-spotify-green focus:ring-offset-2 transition-colors">
                            Submit for Distribution
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let contributorIndex = @json(is_array(old('contributors')) ? count(old('contributors')) : 1);

    // File upload preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const coverInput = document.getElementById('cover_image');
        const audioInput = document.getElementById('audio_file');
        
        coverInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const label = this.closest('.space-y-1').querySelector('span');
                label.textContent = file.name;
            }
        });
        
        audioInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const label = this.closest('.space-y-1').querySelector('span');
                label.textContent = file.name;
            }
        });
    });

    function addContributor() {
        const container = document.getElementById('contributors-container');
        const newContributor = document.createElement('div');
        newContributor.className = 'contributor-input-group mb-3';
        newContributor.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <input type="text" 
                       name="contributors[${contributorIndex}][name]" 
                       placeholder="Full Name"
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <select name="contributors[${contributorIndex}][role]" 
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Select Role</option>
                    <option value="artist">Artist</option>
                    <option value="producer">Producer</option>
                    <option value="songwriter">Songwriter</option>
                    <option value="composer">Composer</option>
                    <option value="featured">Featured Artist</option>
                    <option value="vocalist">Vocalist</option>
                    <option value="instrumentalist">Instrumentalist</option>
                </select>
                <div class="flex">
                    <input type="number" 
                           name="contributors[${contributorIndex}][percentage]" 
                           placeholder="Share %"
                           min="0" max="100" step="0.1"
                           class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <button type="button" onclick="removeContributor(this)" class="px-3 py-2 bg-red-500 text-white rounded-r-lg hover:bg-red-600 transition-colors">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newContributor);
        contributorIndex++;
    }

    function removeContributor(button) {
        const container = document.getElementById('contributors-container');
        if (container.children.length > 1) {
            button.closest('.contributor-input-group').remove();
        }
    }

    function toggleTerritories() {
        const selectedRadio = document.querySelector('input[name="territory_type"]:checked');
        const territorySelection = document.getElementById('territory-selection');
        
        if (selectedRadio && selectedRadio.value === 'selected') {
            territorySelection.classList.remove('hidden');
        } else {
            territorySelection.classList.add('hidden');
            // Uncheck all territory checkboxes when hiding
            document.querySelectorAll('input[name="territories[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleTerritories();
    });
</script>
@endsection