@extends('layouts.admin-distribution')

@section('title', 'Distribution Request Details')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('admin.distribution.dashboard') }}" 
                           class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-arrow-left mr-2"></i>Distribution Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-3"></i>
                            <a href="{{ route('admin.distribution.requests.index') }}" 
                               class="text-gray-400 hover:text-gray-500">
                                Distribution Requests
                            </a>
                        </div>
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

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Request Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">User Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-spotify-green rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr($distributionRequest->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $distributionRequest->user->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $distributionRequest->user->email }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 capitalize">
                                        {{ str_replace('_', ' ', $distributionRequest->user->role) }}
                                    </span>
                                    @if($distributionRequest->user->distribution_paid)
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            <i class="fas fa-check-circle mr-1"></i>Paid User
                                        </span>
                                    @else
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <i class="fas fa-exclamation-circle mr-1"></i>Not Paid
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Song Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Song Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Song Title</label>
                                <p class="text-gray-900 dark:text-white">{{ $distributionRequest->song_title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Artist Name</label>
                                <p class="text-gray-900 dark:text-white">{{ $distributionRequest->artist_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Genre</label>
                                <p class="text-gray-900 dark:text-white">{{ $distributionRequest->genre }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Release Date</label>
                                <p class="text-gray-900 dark:text-white">{{ $distributionRequest->release_date->format('F j, Y') }}</p>
                            </div>
                        </div>
                        
                        @if($distributionRequest->description)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $distributionRequest->description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submitted Files -->
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
                                             class="w-full max-w-sm rounded-lg shadow-sm">
                                        <a href="{{ asset('storage/' . $distributionRequest->cover_image) }}" 
                                           target="_blank"
                                           class="absolute top-2 right-2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition-colors">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="w-48 h-48 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <div class="text-center text-gray-400 dark:text-gray-500">
                                            <i class="fas fa-image text-3xl mb-2"></i>
                                            <p class="text-sm">No cover image</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Audio File -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Audio File</label>
                                @if($distributionRequest->audio_file)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-audio text-spotify-green mr-3"></i>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">Audio Track</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $distributionRequest->audio_file) }}" 
                                               target="_blank" 
                                               class="text-spotify-green hover:text-spotify-green/80 text-sm">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </a>
                                        </div>
                                        <audio controls class="w-full">
                                            <source src="{{ asset('storage/' . $distributionRequest->audio_file) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                @else
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center text-gray-400 dark:text-gray-500">
                                        <i class="fas fa-file-audio text-2xl mb-2"></i>
                                        <p class="text-sm">No audio file uploaded</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Status & Actions -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Request Status</h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                @if($distributionRequest->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @elseif($distributionRequest->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @endif">
                                @if($distributionRequest->status === 'pending')
                                    <i class="fas fa-clock mr-2"></i>
                                @elseif($distributionRequest->status === 'approved')
                                    <i class="fas fa-check mr-2"></i>
                                @else
                                    <i class="fas fa-times mr-2"></i>
                                @endif
                                {{ ucfirst($distributionRequest->status) }}
                            </span>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Submitted:</span>
                                <span class="text-gray-900 dark:text-white">{{ $distributionRequest->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Updated:</span>
                                <span class="text-gray-900 dark:text-white">{{ $distributionRequest->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Admin Notes</h2>
                    </div>
                    <div class="p-6">
                        @if($distributionRequest->notes)
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                                <div class="flex items-start">
                                    <i class="fas fa-comment-alt text-blue-500 mt-1 mr-3"></i>
                                    <p class="text-blue-800 dark:text-blue-300 text-sm leading-relaxed">{{ $distributionRequest->notes }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No admin notes yet.</p>
                        @endif

                        @if($distributionRequest->status === 'pending')
                            <!-- Quick Actions Forms -->
                            <div class="space-y-4 mt-6">
                                <!-- Approve Form -->
                                <form action="{{ route('admin.distribution.requests.approve', $distributionRequest) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="approve_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Notes (Optional)
                                        </label>
                                        <textarea id="approve_notes" name="notes" rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                                  placeholder="Add any notes for approval..."></textarea>
                                    </div>
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium"
                                            onclick="return confirm('Approve this distribution request?')">
                                        <i class="fas fa-check mr-2"></i>Approve Request
                                    </button>
                                </form>

                                <!-- Decline Form -->
                                <form action="{{ route('admin.distribution.requests.decline', $distributionRequest) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="decline_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Reason for declining <span class="text-red-500">*</span>
                                        </label>
                                        <textarea id="decline_notes" name="notes" rows="3" required
                                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                                  placeholder="Please provide a reason for declining..."></textarea>
                                    </div>
                                    <button type="submit" 
                                            class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors font-medium"
                                            onclick="return confirm('Decline this distribution request?')">
                                        <i class="fas fa-times mr-2"></i>Decline Request
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-red-200 dark:border-red-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-red-200 dark:border-red-800">
                        <h2 class="text-lg font-medium text-red-800 dark:text-red-400">Danger Zone</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.distribution.requests.destroy', $distributionRequest) }}">
                            @csrf
                            @method('DELETE')
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Permanently delete this distribution request and all associated files. This action cannot be undone.
                            </p>
                            <button type="submit" 
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors font-medium"
                                    onclick="return confirm('Are you sure you want to delete this distribution request? This action cannot be undone.')">
                                <i class="fas fa-trash mr-2"></i>Delete Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection