@extends('layouts.app')

@section('title', 'Submit Trending Mixtape - MusicStream')

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
            <div class="bg-gradient-to-br from-orange-400 to-orange-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7h-3V6a4 4 0 00-8 0v1H5a1 1 0 000 2h1v9a3 3 0 003 3h6a3 3 0 003-3V9h1a1 1 0 000-2zM10 6a2 2 0 014 0v1h-4V6zm5 13a1 1 0 01-1 1H9a1 1 0 01-1-1V9h7v10z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-4">Submit Trending Mixtape</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Submit your complete mixtape for trending consideration and promotional opportunities.
            </p>
        </div>

        <!-- Mixtape Benefits -->
        <div class="bg-gray-900 rounded-xl p-8 mb-12 border border-gray-800">
            <h2 class="text-2xl font-bold mb-6 text-center">Mixtape Promotion Benefits</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="bg-orange-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Featured Placement</h3>
                    <p class="text-gray-400 text-sm">Get your mixtape featured on homepage and trending sections</p>
                </div>
                <div class="text-center">
                    <div class="bg-orange-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 4V2C7 1.45 7.45 1 8 1S9 1.45 9 2V4H15V2C15 1.45 15.45 1 16 1S17 1.45 17 2V4H20C21.1 4 22 4.9 22 6V20C22 21.1 21.1 22 20 22H4C2.9 22 2 21.1 2 20V6C2 4.9 2.9 4 4 4H7M4 8H20V20H4V8Z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Extended Promotion</h3>
                    <p class="text-gray-400 text-sm">30-day promotional campaign with social media support</p>
                </div>
                <div class="text-center">
                    <div class="bg-orange-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Playlist Addition</h3>
                    <p class="text-gray-400 text-sm">Inclusion in curated playlists and mixtape collections</p>
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

            <form action="{{ route('dashboard.artist.submit-trending-mixtape.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Mixtape Title -->
                <div>
                    <label for="mixtape_title" class="block text-sm font-medium text-gray-300 mb-2">Mixtape Title*</label>
                    <input type="text" id="mixtape_title" name="mixtape_title" value="{{ old('mixtape_title') }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors">
                </div>

                <!-- Number of Tracks -->
                <div>
                    <label for="tracks_count" class="block text-sm font-medium text-gray-300 mb-2">Number of Tracks*</label>
                    <input type="number" id="tracks_count" name="tracks_count" value="{{ old('tracks_count') }}" min="3" max="50" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors">
                    <p class="text-gray-500 text-xs mt-1">Minimum 3 tracks, maximum 50 tracks</p>
                </div>

                <!-- Release Date -->
                <div>
                    <label for="release_date" class="block text-sm font-medium text-gray-300 mb-2">Release Date*</label>
                    <input type="date" id="release_date" name="release_date" value="{{ old('release_date') }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors">
                </div>

                <!-- Cover Image -->
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-300 mb-2">Mixtape Cover Image (Max: 5MB)</label>
                    <div class="relative">
                        <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/jpg"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    </div>
                    <p class="text-gray-500 text-xs mt-1">Optional: Upload a cover image for your mixtape</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Mixtape Description*</label>
                    <textarea id="description" name="description" rows="6" required
                              placeholder="Describe your mixtape, including:&#10;• Theme and concept&#10;• Featured artists or collaborations&#10;• Production details&#10;• Target audience&#10;• What makes this mixtape special&#10;• Marketing plans or campaigns"
                              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors">{{ old('description') }}</textarea>
                </div>

                <!-- Mixtape Details -->
                <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                    <h3 class="font-semibold mb-4">Mixtape Requirements</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-400">
                        <div>
                            <h4 class="text-white font-medium mb-2">Content Requirements:</h4>
                            <ul class="space-y-1">
                                <li>• Minimum 3 tracks</li>
                                <li>• High-quality audio files</li>
                                <li>• Professional cover art</li>
                                <li>• Complete tracklist</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-white font-medium mb-2">Promotion Criteria:</h4>
                            <ul class="space-y-1">
                                <li>• Original content</li>
                                <li>• Good streaming metrics</li>
                                <li>• Social media presence</li>
                                <li>• Marketing strategy</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Agreement Checklist -->
                <div class="bg-orange-900/20 rounded-lg p-6 border border-orange-700/50">
                    <h3 class="font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Agreement & Requirements
                    </h3>
                    <div class="space-y-2 text-sm text-gray-300">
                        <label class="flex items-center">
                            <input type="checkbox" required class="form-checkbox h-4 w-4 text-orange-500 bg-gray-800 border-gray-600 rounded focus:ring-orange-500">
                            <span class="ml-2">All tracks in the mixtape are uploaded and approved on the platform</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" required class="form-checkbox h-4 w-4 text-orange-500 bg-gray-800 border-gray-600 rounded focus:ring-orange-500">
                            <span class="ml-2">I own all rights to the content or have proper licensing</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" required class="form-checkbox h-4 w-4 text-orange-500 bg-gray-800 border-gray-600 rounded focus:ring-orange-500">
                            <span class="ml-2">The mixtape has a cohesive theme and professional quality</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" required class="form-checkbox h-4 w-4 text-orange-500 bg-gray-800 border-gray-600 rounded focus:ring-orange-500">
                            <span class="ml-2">I agree to promotional terms and understand selection is competitive</span>
                        </label>
                    </div>
                </div>

                <!-- Review Process -->
                <div class="bg-gray-800/30 rounded-lg p-6 border border-gray-700/50">
                    <h3 class="font-semibold mb-3">Review Process</h3>
                    <div class="text-sm text-gray-400 space-y-2">
                        <p>• Mixtape submissions are reviewed within 7-10 business days</p>
                        <p>• Our team evaluates content quality, originality, and promotional potential</p>
                        <p>• If approved, promotional campaign begins immediately</p>
                        <p>• Featured mixtapes receive 30 days of active promotion</p>
                        <p>• You'll be notified of the decision via email and dashboard</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-center pt-6">
                    <button type="submit" 
                            class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-4 px-8 rounded-full transition-all transform hover:scale-105 focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        Submit Mixtape for Trending
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection