@extends('layouts.app')

@section('title', 'Create Artist - Record Label - MusicStream')

@section('content')
<div class="min-h-screen bg-black text-white">
    <div class="max-w-4xl mx-auto px-8 py-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('dashboard.record-label') }}" class="inline-flex items-center text-gray-400 hover:text-green-400 transition-colors">
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
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-4">Create New Artist</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Add new artists to your record label and manage their profiles and releases.
            </p>
        </div>

        <!-- Benefits Information -->
        <div class="bg-gray-900 rounded-xl p-8 mb-12 border border-gray-800">
            <h2 class="text-2xl font-bold mb-6 text-center">Artist Management Benefits</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="bg-blue-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Complete Profiles</h3>
                    <p class="text-gray-400 text-sm">Build comprehensive artist profiles with bio, images, and social links</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Music Management</h3>
                    <p class="text-gray-400 text-sm">Upload and manage releases for each artist under your label</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Promotion Support</h3>
                    <p class="text-gray-400 text-sm">Access promotional opportunities and marketing tools</p>
                </div>
            </div>
        </div>

        <!-- Artist Creation Form -->
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

            <form action="{{ route('dashboard.record-label.create-artist.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Artist Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Artist Name*</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                           placeholder="Enter the artist's stage name or real name">
                </div>

                <!-- Genre -->
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-300 mb-2">Primary Genre*</label>
                    <select id="genre" name="genre" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        <option value="">Select Primary Genre</option>
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
                        <option value="World" {{ old('genre') == 'World' ? 'selected' : '' }}>World Music</option>
                        <option value="Other" {{ old('genre') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Profile Picture -->
                <div>
                    <label for="profile_picture" class="block text-sm font-medium text-gray-300 mb-2">Profile Picture (Max: 2MB)</label>
                    <div class="relative">
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/jpg"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <p class="text-gray-500 text-xs mt-1">Recommended: Square format (800x800px minimum), JPEG/PNG</p>
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">Artist Biography</label>
                    <textarea id="bio" name="bio" rows="6"
                              placeholder="Write a compelling artist bio including:&#10;• Background and career highlights&#10;• Musical style and influences&#10;• Notable achievements and awards&#10;• Discography highlights&#10;• Current projects and future plans"
                              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">{{ old('bio') }}</textarea>
                    <p class="text-gray-500 text-xs mt-1">A good bio helps fans connect with the artist and improves discoverability</p>
                </div>

                <!-- Social Media Links -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-4">Social Media Links</label>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Instagram -->
                        <div>
                            <label for="instagram" class="block text-xs font-medium text-gray-400 mb-1">Instagram</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                                <input type="url" name="social_links[instagram]" id="instagram" value="{{ old('social_links.instagram') }}"
                                       placeholder="https://instagram.com/username"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            </div>
                        </div>

                        <!-- Twitter -->
                        <div>
                            <label for="twitter" class="block text-xs font-medium text-gray-400 mb-1">Twitter</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </div>
                                <input type="url" name="social_links[twitter]" id="twitter" value="{{ old('social_links.twitter') }}"
                                       placeholder="https://twitter.com/username"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            </div>
                        </div>

                        <!-- Facebook -->
                        <div>
                            <label for="facebook" class="block text-xs font-medium text-gray-400 mb-1">Facebook</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                                <input type="url" name="social_links[facebook]" id="facebook" value="{{ old('social_links.facebook') }}"
                                       placeholder="https://facebook.com/username"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            </div>
                        </div>

                        <!-- YouTube -->
                        <div>
                            <label for="youtube" class="block text-xs font-medium text-gray-400 mb-1">YouTube</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </div>
                                <input type="url" name="social_links[youtube]" id="youtube" value="{{ old('social_links.youtube') }}"
                                       placeholder="https://youtube.com/channel/username"
                                       class="w-full bg-gray-800 border border-gray-700 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs mt-2">Add social media links to help fans discover and follow the artist</p>
                </div>

                <!-- Label Information -->
                <div class="bg-blue-900/20 rounded-lg p-6 border border-blue-700/50">
                    <h3 class="font-semibold mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                        </svg>
                        Artist Management Information
                    </h3>
                    <div class="text-sm text-gray-300 space-y-2">
                        <p>• Artist profiles require admin approval before going live</p>
                        <p>• Once approved, you can immediately start uploading music for this artist</p>
                        <p>• All artist content will be associated with your record label</p>
                        <p>• You retain full management rights over this artist's profile</p>
                        <p>• Artist analytics and performance data will be available in your dashboard</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-center pt-6">
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-4 px-8 rounded-full transition-all transform hover:scale-105 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        Create Artist Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection