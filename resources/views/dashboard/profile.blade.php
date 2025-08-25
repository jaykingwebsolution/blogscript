@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Profile</h1>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <textarea name="bio" id="bio" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                      placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                            @if($user->profile_picture)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current Profile Picture" class="w-20 h-20 rounded-full object-cover">
                                </div>
                            @endif
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            @error('profile_picture')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($user->isArtist() || $user->isRecordLabel())
                        <!-- Artist Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pt-6 border-t">Artist Information</h3>
                        </div>

                        <div>
                            <label for="artist_stage_name" class="block text-sm font-medium text-gray-700 mb-2">Stage Name</label>
                            <input type="text" name="artist_stage_name" id="artist_stage_name" value="{{ old('artist_stage_name', $user->artist_stage_name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            @error('artist_stage_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="artist_genre" class="block text-sm font-medium text-gray-700 mb-2">Primary Genre</label>
                            <select name="artist_genre" id="artist_genre" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Select Genre</option>
                                <option value="Afrobeats" {{ old('artist_genre', $user->artist_genre) == 'Afrobeats' ? 'selected' : '' }}>Afrobeats</option>
                                <option value="Hip-Hop" {{ old('artist_genre', $user->artist_genre) == 'Hip-Hop' ? 'selected' : '' }}>Hip-Hop</option>
                                <option value="R&B" {{ old('artist_genre', $user->artist_genre) == 'R&B' ? 'selected' : '' }}>R&B</option>
                                <option value="Pop" {{ old('artist_genre', $user->artist_genre) == 'Pop' ? 'selected' : '' }}>Pop</option>
                                <option value="Gospel" {{ old('artist_genre', $user->artist_genre) == 'Gospel' ? 'selected' : '' }}>Gospel</option>
                                <option value="Reggae" {{ old('artist_genre', $user->artist_genre) == 'Reggae' ? 'selected' : '' }}>Reggae</option>
                                <option value="Highlife" {{ old('artist_genre', $user->artist_genre) == 'Highlife' ? 'selected' : '' }}>Highlife</option>
                                <option value="Other" {{ old('artist_genre', $user->artist_genre) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('artist_genre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <!-- Social Links -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pt-6 border-t">Social Links</h3>
                        </div>

                        <div>
                            <label for="social_links_facebook" class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                            <input type="url" name="social_links[facebook]" id="social_links_facebook" 
                                   value="{{ old('social_links.facebook', $user->social_links['facebook'] ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="https://facebook.com/username">
                            @error('social_links.facebook')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="social_links_instagram" class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                            <input type="url" name="social_links[instagram]" id="social_links_instagram" 
                                   value="{{ old('social_links.instagram', $user->social_links['instagram'] ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="https://instagram.com/username">
                            @error('social_links.instagram')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="social_links_twitter" class="block text-sm font-medium text-gray-700 mb-2">Twitter</label>
                            <input type="url" name="social_links[twitter]" id="social_links_twitter" 
                                   value="{{ old('social_links.twitter', $user->social_links['twitter'] ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="https://twitter.com/username">
                            @error('social_links.twitter')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="social_links_youtube" class="block text-sm font-medium text-gray-700 mb-2">YouTube</label>
                            <input type="url" name="social_links[youtube]" id="social_links_youtube" 
                                   value="{{ old('social_links.youtube', $user->social_links['youtube'] ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="https://youtube.com/channel/username">
                            @error('social_links.youtube')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-md shadow-sm transition-colors">
                            Update Profile
                        </button>
                    </div>
                </form>

                <!-- Password Update Form -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Change Password</h3>
                    
                    <form method="POST" action="{{ route('dashboard.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" name="current_password" id="current_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" name="password" id="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-md shadow-sm transition-colors">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection