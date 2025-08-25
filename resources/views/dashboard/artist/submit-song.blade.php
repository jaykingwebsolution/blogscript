@extends('layouts.app')

@section('title', 'Submit Song for Distribution - MusicStream')

@section('content')
<div class="min-h-screen bg-black text-white">
    <div class="max-w-4xl mx-auto px-8 py-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('dashboard.artist') }}" class="inline-flex items-center text-gray-400 hover:text-green-400 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 12H5m7-7l-7 7 7 7"/>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Header -->
        <div class="text-center mb-12">
            <div class="bg-gradient-to-br from-green-400 to-green-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-4">Submit Song for Distribution</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Upload your music to distribute across major streaming platforms like Spotify, Apple Music, Boomplay, Audiomack, and more.
            </p>
        </div>

        <!-- Distribution Platforms -->
        <div class="bg-gray-900 rounded-xl p-8 mb-12 border border-gray-800">
            <h2 class="text-2xl font-bold mb-6 text-center">Distribution Platforms</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="flex flex-col items-center">
                    <div class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center mb-2">
                        <span class="text-white font-bold">S</span>
                    </div>
                    <span class="text-sm text-gray-300">Spotify</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-gray-800 w-12 h-12 rounded-full flex items-center justify-center mb-2">
                        <span class="text-white font-bold">A</span>
                    </div>
                    <span class="text-sm text-gray-300">Apple Music</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-orange-500 w-12 h-12 rounded-full flex items-center justify-center mb-2">
                        <span class="text-white font-bold">B</span>
                    </div>
                    <span class="text-sm text-gray-300">Boomplay</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="bg-red-500 w-12 h-12 rounded-full flex items-center justify-center mb-2">
                        <span class="text-white font-bold">A</span>
                    </div>
                    <span class="text-sm text-gray-300">Audiomack</span>
                </div>
            </div>
        </div>

        <!-- Submission Form -->
        <div class="bg-gray-900 rounded-xl p-8 border border-gray-800">
            @if($errors->any())
                <div class="bg-red-900/50 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dashboard.artist.submit-song.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Artist Name -->
                <div>
                    <label for="artist_name" class="block text-sm font-medium text-gray-300 mb-2">Artist Name*</label>
                    <input type="text" id="artist_name" name="artist_name" value="{{ old('artist_name', Auth::user()->getDisplayName()) }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors">
                </div>

                <!-- Song Title -->
                <div>
                    <label for="song_title" class="block text-sm font-medium text-gray-300 mb-2">Song Title*</label>
                    <input type="text" id="song_title" name="song_title" value="{{ old('song_title') }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors">
                </div>

                <!-- Genre -->
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-300 mb-2">Genre*</label>
                    <select id="genre" name="genre" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors">
                        <option value="">Select Genre</option>
                        <option value="Afrobeats" {{ old('genre') == 'Afrobeats' ? 'selected' : '' }}>Afrobeats</option>
                        <option value="Hip Hop" {{ old('genre') == 'Hip Hop' ? 'selected' : '' }}>Hip Hop</option>
                        <option value="R&B" {{ old('genre') == 'R&B' ? 'selected' : '' }}>R&B</option>
                        <option value="Gospel" {{ old('genre') == 'Gospel' ? 'selected' : '' }}>Gospel</option>
                        <option value="Pop" {{ old('genre') == 'Pop' ? 'selected' : '' }}>Pop</option>
                        <option value="Reggae" {{ old('genre') == 'Reggae' ? 'selected' : '' }}>Reggae</option>
                        <option value="Jazz" {{ old('genre') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                        <option value="Classical" {{ old('genre') == 'Classical' ? 'selected' : '' }}>Classical</option>
                        <option value="Electronic" {{ old('genre') == 'Electronic' ? 'selected' : '' }}>Electronic</option>
                        <option value="Country" {{ old('genre') == 'Country' ? 'selected' : '' }}>Country</option>
                        <option value="Rock" {{ old('genre') == 'Rock' ? 'selected' : '' }}>Rock</option>
                        <option value="Alternative" {{ old('genre') == 'Alternative' ? 'selected' : '' }}>Alternative</option>
                        <option value="Blues" {{ old('genre') == 'Blues' ? 'selected' : '' }}>Blues</option>
                        <option value="Folk" {{ old('genre') == 'Folk' ? 'selected' : '' }}>Folk</option>
                        <option value="Other" {{ old('genre') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Release Date -->
                <div>
                    <label for="release_date" class="block text-sm font-medium text-gray-300 mb-2">Release Date*</label>
                    <input type="date" id="release_date" name="release_date" value="{{ old('release_date') }}" min="{{ date('Y-m-d') }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors">
                </div>

                <!-- File Uploads -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cover Image -->
                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-gray-300 mb-2">Cover Image* (Max: 5MB)</label>
                        <div class="relative">
                            <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/jpg" required
                                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Recommended: Square format (1400x1400px), JPEG/PNG</p>
                    </div>

                    <!-- Audio File -->
                    <div>
                        <label for="audio_file" class="block text-sm font-medium text-gray-300 mb-2">Audio File* (Max: 50MB)</label>
                        <div class="relative">
                            <input type="file" id="audio_file" name="audio_file" accept="audio/mp3,audio/wav" required
                                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Supported: MP3, WAV. High quality recommended (320kbps)</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description / Additional Info</label>
                    <textarea id="description" name="description" rows="4" placeholder="Tell us about your song, inspiration, or any special requirements..."
                              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors">{{ old('description') }}</textarea>
                </div>

                <!-- Terms and Conditions -->
                <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                    <h3 class="font-semibold mb-3">Terms & Conditions</h3>
                    <div class="text-sm text-gray-400 space-y-2">
                        <p>• Your music will be reviewed by our team within 3-5 business days</p>
                        <p>• Ensure you own all rights to the submitted content</p>
                        <p>• Distribution typically takes 1-2 weeks after approval</p>
                        <p>• You retain ownership of your music</p>
                        <p>• Revenue sharing as per your subscription plan</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-center pt-6">
                    <button type="submit" 
                            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-4 px-8 rounded-full transition-all transform hover:scale-105 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        Submit Song for Distribution
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection