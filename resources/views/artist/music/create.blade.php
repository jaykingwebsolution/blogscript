@extends('layouts.app')

@section('title', 'Upload Music')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Upload New Music</h1>

                <form method="POST" action="{{ route('artist.music.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Track Information</h3>
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Track Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="artist_name" class="block text-sm font-medium text-gray-700 mb-2">Artist Name *</label>
                            <input type="text" name="artist_name" id="artist_name" value="{{ old('artist_name', auth()->user()->getDisplayName()) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                            @error('artist_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
                            <select name="genre" id="genre" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Select Genre</option>
                                <option value="Afrobeats" {{ old('genre') == 'Afrobeats' ? 'selected' : '' }}>Afrobeats</option>
                                <option value="Hip-Hop" {{ old('genre') == 'Hip-Hop' ? 'selected' : '' }}>Hip-Hop</option>
                                <option value="R&B" {{ old('genre') == 'R&B' ? 'selected' : '' }}>R&B</option>
                                <option value="Pop" {{ old('genre') == 'Pop' ? 'selected' : '' }}>Pop</option>
                                <option value="Gospel" {{ old('genre') == 'Gospel' ? 'selected' : '' }}>Gospel</option>
                                <option value="Reggae" {{ old('genre') == 'Reggae' ? 'selected' : '' }}>Reggae</option>
                                <option value="Highlife" {{ old('genre') == 'Highlife' ? 'selected' : '' }}>Highlife</option>
                                <option value="Jazz" {{ old('genre') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                                <option value="Rock" {{ old('genre') == 'Rock' ? 'selected' : '' }}>Rock</option>
                                <option value="Electronic" {{ old('genre') == 'Electronic' ? 'selected' : '' }}>Electronic</option>
                                <option value="Country" {{ old('genre') == 'Country' ? 'selected' : '' }}>Country</option>
                                <option value="Other" {{ old('genre') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('genre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select name="category_id" id="category_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                            <input type="text" name="duration" id="duration" value="{{ old('duration') }}" 
                                   placeholder="e.g., 3:45"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            @error('duration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="release_date" class="block text-sm font-medium text-gray-700 mb-2">Release Date</label>
                            <input type="date" name="release_date" id="release_date" value="{{ old('release_date') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            @error('release_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                      placeholder="Tell us about your track...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Uploads -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pt-6 border-t">Files</h3>
                        </div>

                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">Cover Image *</label>
                            <input type="file" name="cover_image" id="cover_image" accept="image/*" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            <p class="mt-1 text-sm text-gray-500">JPG, PNG, GIF up to 2MB</p>
                            @error('cover_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="audio_file" class="block text-sm font-medium text-gray-700 mb-2">Audio File *</label>
                            <input type="file" name="audio_file" id="audio_file" accept=".mp3,.wav,.aac,.ogg" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            <p class="mt-1 text-sm text-gray-500">MP3, WAV, AAC, OGG up to 20MB</p>
                            @error('audio_file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($tags as $tag)
                                <label class="flex items-center">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                           {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-8 pt-6 border-t">
                        <a href="{{ route('artist.music.index') }}" class="text-gray-600 hover:text-gray-800">
                            ← Back to My Music
                        </a>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-md shadow-sm transition-colors">
                            Upload Music
                        </button>
                    </div>
                </form>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Review Process</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Your uploaded music will be reviewed by our admin team before being published. You'll receive a notification once the review is complete.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection