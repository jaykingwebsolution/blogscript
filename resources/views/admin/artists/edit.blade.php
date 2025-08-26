@extends('admin.layout')

@section('title', 'Edit Artist')
@section('header', 'Edit Artist')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Edit Artist: {{ $artist->name }}</h2>
        <a href="{{ route('admin.artists.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Artists
        </a>
    </div>

    <form method="POST" action="{{ route('admin.artists.update', $artist) }}" class="bg-white shadow rounded-lg">
        @csrf
        @method('PUT')
        
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Artist Information</h3>
            <p class="mt-1 text-sm text-gray-600">Update artist details and settings.</p>
        </div>

        <div class="px-6 py-4 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Artist Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $artist->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 py-2 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">@</span>
                        <input type="text" name="username" id="username" value="{{ old('username', $artist->username) }}" required
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-none rounded-r-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('username') border-red-500 @enderror">
                    </div>
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Unique username for artist profile URL</p>
                </div>
            </div>

            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Biography</label>
                <textarea name="bio" id="bio" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('bio') border-red-500 @enderror"
                          placeholder="Tell us about this artist...">{{ old('bio', $artist->bio) }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Artist Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
                    <select name="genre" id="genre"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('genre') border-red-500 @enderror">
                        <option value="">Select Genre</option>
                        <option value="Afrobeats" {{ old('genre', $artist->genre) === 'Afrobeats' ? 'selected' : '' }}>Afrobeats</option>
                        <option value="Highlife" {{ old('genre', $artist->genre) === 'Highlife' ? 'selected' : '' }}>Highlife</option>
                        <option value="Gospel" {{ old('genre', $artist->genre) === 'Gospel' ? 'selected' : '' }}>Gospel</option>
                        <option value="Hip-Hop" {{ old('genre', $artist->genre) === 'Hip-Hop' ? 'selected' : '' }}>Hip-Hop</option>
                        <option value="R&B" {{ old('genre', $artist->genre) === 'R&B' ? 'selected' : '' }}>R&B</option>
                        <option value="Jazz" {{ old('genre', $artist->genre) === 'Jazz' ? 'selected' : '' }}>Jazz</option>
                        <option value="Pop" {{ old('genre', $artist->genre) === 'Pop' ? 'selected' : '' }}>Pop</option>
                        <option value="Reggae" {{ old('genre', $artist->genre) === 'Reggae' ? 'selected' : '' }}>Reggae</option>
                        <option value="Folk" {{ old('genre', $artist->genre) === 'Folk' ? 'selected' : '' }}>Folk</option>
                        <option value="Other" {{ old('genre', $artist->genre) === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('genre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <select name="country" id="country"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('country') border-red-500 @enderror">
                        <option value="">Select Country</option>
                        <option value="Nigeria" {{ old('country', $artist->country) === 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                        <option value="Ghana" {{ old('country', $artist->country) === 'Ghana' ? 'selected' : '' }}>Ghana</option>
                        <option value="South Africa" {{ old('country', $artist->country) === 'South Africa' ? 'selected' : '' }}>South Africa</option>
                        <option value="Kenya" {{ old('country', $artist->country) === 'Kenya' ? 'selected' : '' }}>Kenya</option>
                        <option value="Uganda" {{ old('country', $artist->country) === 'Uganda' ? 'selected' : '' }}>Uganda</option>
                        <option value="Tanzania" {{ old('country', $artist->country) === 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                        <option value="Cameroon" {{ old('country', $artist->country) === 'Cameroon' ? 'selected' : '' }}>Cameroon</option>
                        <option value="Senegal" {{ old('country', $artist->country) === 'Senegal' ? 'selected' : '' }}>Senegal</option>
                        <option value="Mali" {{ old('country', $artist->country) === 'Mali' ? 'selected' : '' }}>Mali</option>
                        <option value="Other" {{ old('country', $artist->country) === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" id="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('status') border-red-500 @enderror">
                        <option value="draft" {{ old('status', $artist->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $artist->status) === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status', $artist->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image URL with Preview -->
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">Profile Image URL</label>
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $artist->image_url) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('image_url') border-red-500 @enderror"
                       placeholder="https://example.com/artist-image.jpg">
                @error('image_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if($artist->image_url)
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 mb-2">Current image:</p>
                        <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}" class="h-20 w-20 rounded-full object-cover border border-gray-300">
                    </div>
                @endif
                <p class="mt-1 text-xs text-gray-500">Direct URL to artist's profile image</p>
            </div>

            <!-- Trending Option -->
            <div class="flex items-center">
                <input type="checkbox" name="is_trending" id="is_trending" value="1" {{ old('is_trending', $artist->is_trending) ? 'checked' : '' }}
                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                <label for="is_trending" class="ml-2 block text-sm text-gray-900">
                    Mark as trending artist
                </label>
            </div>

            <!-- Stats Display -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Artist Statistics</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $artist->music_count ?? 0 }}</div>
                        <div class="text-xs text-gray-500">Music Tracks</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $artist->created_at->format('M Y') }}</div>
                        <div class="text-xs text-gray-500">Joined</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ ucfirst($artist->status) }}</div>
                        <div class="text-xs text-gray-500">Status</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $artist->is_trending ? 'Yes' : 'No' }}</div>
                        <div class="text-xs text-gray-500">Trending</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
            <div class="flex space-x-3">
                <a href="{{ route('admin.artists.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition-colors">
                    Cancel
                </a>
                <a href="{{ route('artists.show', $artist->username) }}" target="_blank"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    View Profile
                </a>
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Artist
            </button>
        </div>
    </form>
</div>
@endsection