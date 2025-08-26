@extends('layouts.app')

@section('title', 'Distribution Request Details - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('admin.distribution.index') }}" 
                           class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-arrow-left mr-2"></i>Distribution Requests
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
                            @if($distributionRequest->user->profile_picture)
                                <img src="{{ asset('storage/' . $distributionRequest->user->profile_picture) }}" 
                                     alt="{{ $distributionRequest->user->name }}"
                                     class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 dark:text-gray-500 text-xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white capitalize">{{ $distributionRequest->user->role }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Member Since</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $distributionRequest->user->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Request Details -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Request Details</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Song Title</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $distributionRequest->song_title }}</p>
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
                                             class="w-full max-w-sm rounded-lg shadow-sm">
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
                                        <div class="flex items-center justify-between mb-3">
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
                                        <audio controls class="w-full">
                                            <source src="{{ asset('storage/' . $distributionRequest->audio_file) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">No audio file uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes Section -->
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
                            <!-- Quick Notes Form -->
                            <form action="{{ route('admin.distribution.approve', $distributionRequest) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Add Notes (Optional)
                                    </label>
                                    <textarea id="notes" name="notes" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                              placeholder="Add approval notes or feedback for the user...">{{ old('notes') }}</textarea>
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-check mr-2"></i>Approve Request
                                    </button>
                                    <button type="button" onclick="openDeclineModal()" 
                                            class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                                        <i class="fas fa-times mr-2"></i>Decline Request
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Status & Info -->
            <div class="lg:col-span-1">
                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Request Status</h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $distributionRequest->status_color }}">
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

                        @if($distributionRequest->status !== 'pending')
                            <!-- Status Change Form -->
                            <form action="{{ route('admin.distribution.update-status', $distributionRequest) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Change Status
                                    </label>
                                    <select id="status" name="status" 
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                        <option value="pending" {{ $distributionRequest->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $distributionRequest->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="declined" {{ $distributionRequest->status === 'declined' ? 'selected' : '' }}>Declined</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="status_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Update Notes
                                    </label>
                                    <textarea id="status_notes" name="notes" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                              placeholder="Add notes about this status change...">{{ $distributionRequest->notes }}</textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-spotify-green text-white font-medium rounded-lg hover:bg-spotify-green/90 transition-colors">
                                    Update Status
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Distribution Platforms -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
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

                <!-- Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Actions</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="mailto:{{ $distributionRequest->user->email }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>Email User
                        </a>
                        
                        <form method="POST" action="{{ route('admin.distribution.destroy', $distributionRequest) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this distribution request permanently? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 dark:border-red-600 rounded-lg text-sm font-medium text-red-700 dark:text-red-300 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <i class="fas fa-trash mr-2"></i>Delete Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Decline Modal -->
<div id="declineModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Decline Distribution Request</h3>
                <form action="{{ route('admin.distribution.decline', $distributionRequest) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="decline_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Reason for declining <span class="text-red-500">*</span>
                        </label>
                        <textarea id="decline_notes" name="notes" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                  placeholder="Please provide a detailed reason for declining this request..."></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeDeclineModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Decline Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openDeclineModal() {
    document.getElementById('declineModal').classList.remove('hidden');
}

function closeDeclineModal() {
    document.getElementById('declineModal').classList.add('hidden');
    document.getElementById('decline_notes').value = '';
}

// Close modal when clicking outside
document.getElementById('declineModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeclineModal();
    }
});
</script>
@endsection