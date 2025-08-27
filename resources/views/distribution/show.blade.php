@extends('layouts.distribution')

@section('title', 'Distribution Request Details')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('distribution.my-submissions') }}" 
                           class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-arrow-left mr-2"></i>My Submissions
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-3"></i>
                            <span class="text-gray-900 dark:text-white font-medium">{{ $distributionRequest->song_title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Request Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Request Details</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Song Title</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->song_title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Artist Name</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->artist_name }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Genre</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->genre }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Release Date</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->release_date->format('F d, Y') }}</p>
                            </div>
                        </div>

                        @if($distributionRequest->description)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white leading-relaxed">{{ $distributionRequest->description }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Submitted</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->updated_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Files Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Submitted Files</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Cover Image -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Cover Image</label>
                                @if($distributionRequest->cover_image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $distributionRequest->cover_image) }}" 
                                             alt="{{ $distributionRequest->song_title }}"
                                             class="w-full max-w-xs rounded-lg shadow-sm">
                                        <a href="{{ asset('storage/' . $distributionRequest->cover_image) }}" 
                                           target="_blank"
                                           class="absolute top-2 right-2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition-colors">
                                            <i class="fas fa-external-link-alt text-sm"></i>
                                        </a>
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">No cover image uploaded</p>
                                @endif
                            </div>

                            <!-- Audio File -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Audio File</label>
                                @if($distributionRequest->audio_file)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-audio text-spotify-green text-xl mr-3"></i>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Audio File</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ pathinfo($distributionRequest->audio_file, PATHINFO_EXTENSION) }} file</p>
                                                </div>
                                            </div>
                                            <a href="{{ asset('storage/' . $distributionRequest->audio_file) }}" 
                                               download
                                               class="text-spotify-green hover:text-spotify-green/80 text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </a>
                                        </div>
                                        <div class="mt-3">
                                            <audio controls class="w-full">
                                                <source src="{{ asset('storage/' . $distributionRequest->audio_file) }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">No audio file uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes (if any) -->
                @if($distributionRequest->notes)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Admin Feedback</h2>
                        </div>
                        <div class="p-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-comment-alt text-blue-500 mt-1 mr-3"></i>
                                    <p class="text-blue-800 dark:text-blue-300 text-sm leading-relaxed">{{ $distributionRequest->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Status & Actions -->
            <div class="lg:col-span-1">
                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Request Status</h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $distributionRequest->status_color }} mb-4">
                                @if($distributionRequest->status === 'pending')
                                    <i class="fas fa-clock mr-2"></i>
                                @elseif($distributionRequest->status === 'approved')
                                    <i class="fas fa-check mr-2"></i>
                                @else
                                    <i class="fas fa-times mr-2"></i>
                                @endif
                                {{ ucfirst($distributionRequest->status) }}
                            </span>

                            @if($distributionRequest->status === 'pending')
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    Your submission is currently under review. You'll receive an update within 3-5 business days.
                                </p>
                            @elseif($distributionRequest->status === 'approved')
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    Congratulations! Your music has been approved for distribution to streaming platforms.
                                </p>
                            @else
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    Your submission needs revision. Please check the admin feedback below and resubmit.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Distribution Platforms -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Distribution Platforms</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @php
                                $platforms = [
                                    ['name' => 'Spotify', 'icon' => 'fab fa-spotify', 'color' => 'text-green-600'],
                                    ['name' => 'Apple Music', 'icon' => 'fab fa-apple', 'color' => 'text-gray-600'],
                                    ['name' => 'YouTube Music', 'icon' => 'fab fa-youtube', 'color' => 'text-red-600'],
                                    ['name' => 'Boomplay', 'icon' => 'fas fa-music', 'color' => 'text-orange-600'],
                                    ['name' => 'Audiomack', 'icon' => 'fas fa-headphones', 'color' => 'text-purple-600'],
                                    ['name' => 'Amazon Music', 'icon' => 'fab fa-amazon', 'color' => 'text-yellow-600'],
                                    ['name' => 'Deezer', 'icon' => 'fas fa-play-circle', 'color' => 'text-blue-600'],
                                ];
                            @endphp

                            @foreach($platforms as $platform)
                                <div class="flex items-center justify-between py-2">
                                    <div class="flex items-center">
                                        <i class="{{ $platform['icon'] }} {{ $platform['color'] }} mr-3"></i>
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $platform['name'] }}</span>
                                    </div>
                                    @if($distributionRequest->status === 'approved')
                                        <span class="text-green-600 text-xs">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection