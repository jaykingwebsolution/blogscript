@extends('layouts.app')

@section('title', 'Submit Trending Song Request - MusicStream')

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
            <div class="bg-gradient-to-br from-purple-400 to-purple-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-4">Submit Trending Song Request</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Request to feature your songs in trending sections for increased visibility and reach.
            </p>
        </div>

        <!-- Trending Benefits -->
        <div class="bg-gray-900 rounded-xl p-8 mb-12 border border-gray-800">
            <h2 class="text-2xl font-bold mb-6 text-center">Trending Benefits</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="bg-purple-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L3.09 8.26L9 14.17V22l3-1.5L15 22V14.17l5.91-5.91L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Increased Visibility</h3>
                    <p class="text-gray-400 text-sm">Get featured in trending sections across the platform</p>
                </div>
                <div class="text-center">
                    <div class="bg-purple-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">More Listeners</h3>
                    <p class="text-gray-400 text-sm">Reach new audiences and grow your fanbase</p>
                </div>
                <div class="text-center">
                    <div class="bg-purple-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z"/>
                            <path d="M12 14c-3.866 0-7 1.79-7 4v4h14v-4c0-2.21-3.134-4-7-4z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Higher Rankings</h3>
                    <p class="text-gray-400 text-sm">Boost your position in charts and playlists</p>
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

            <form action="{{ route('dashboard.artist.submit-trending-song.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Trending Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-300 mb-2">Trending Type*</label>
                    <select id="type" name="type" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                        <option value="">Select Trending Type</option>
                        <option value="week" {{ old('type') == 'week' ? 'selected' : '' }}>Trending This Week</option>
                        <option value="month" {{ old('type') == 'month' ? 'selected' : '' }}>Trending This Month</option>
                        <option value="all-time" {{ old('type') == 'all-time' ? 'selected' : '' }}>All-Time Trending</option>
                    </select>
                    <p class="text-gray-500 text-xs mt-1">Choose the trending category you're applying for</p>
                </div>

                <!-- Request Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Request Message*</label>
                    <textarea id="message" name="message" rows="6" required
                              placeholder="Tell us about your song and why it deserves to be featured in trending. Include information about:&#10;• Song performance and metrics&#10;• Recent achievements&#10;• Unique qualities of the track&#10;• Marketing efforts or upcoming campaigns&#10;• Why you believe it will resonate with audiences"
                              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">{{ old('message') }}</textarea>
                    <p class="text-gray-500 text-xs mt-1">Be specific about your song's performance and why it should be trending</p>
                </div>

                <!-- Guidelines -->
                <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                    <h3 class="font-semibold mb-3">Trending Guidelines</h3>
                    <div class="text-sm text-gray-400 space-y-2">
                        <p>• Only one active trending request per artist at a time</p>
                        <p>• Requests are reviewed within 5-7 business days</p>
                        <p>• Trending placement lasts for 30 days if approved</p>
                        <p>• Songs must have good engagement metrics</p>
                        <p>• Quality music with proper metadata required</p>
                        <p>• Trending spots are limited and competitive</p>
                    </div>
                </div>

                <!-- Requirements Checklist -->
                <div class="bg-purple-900/20 rounded-lg p-6 border border-purple-700/50">
                    <h3 class="font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Requirements Checklist
                    </h3>
                    <div class="space-y-2 text-sm text-gray-300">
                        <label class="flex items-center">
                            <input type="checkbox" required class="form-checkbox h-4 w-4 text-purple-500 bg-gray-800 border-gray-600 rounded focus:ring-purple-500">
                            <span class="ml-2">My song is already uploaded and approved on the platform</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" required class="form-checkbox h-4 w-4 text-purple-500 bg-gray-800 border-gray-600 rounded focus:ring-purple-500">
                            <span class="ml-2">I have high-quality cover art and metadata</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" required class="form-checkbox h-4 w-4 text-purple-500 bg-gray-800 border-gray-600 rounded focus:ring-purple-500">
                            <span class="ml-2">My song has good engagement (plays, likes, shares)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" required class="form-checkbox h-4 w-4 text-purple-500 bg-gray-800 border-gray-600 rounded focus:ring-purple-500">
                            <span class="ml-2">I understand trending placement is competitive and not guaranteed</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-center pt-6">
                    <button type="submit" 
                            class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-4 px-8 rounded-full transition-all transform hover:scale-105 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        Submit Trending Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection