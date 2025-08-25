@extends('admin.layout')

@section('title', 'Media Management')
@section('header', 'Media Management')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Media & Upload Management</h2>
    <p class="text-sm text-gray-600">Review and manage user uploads and media content</p>
</div>

<!-- Tabs -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button onclick="showTab('pending')" id="pending-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Pending Approval
                @if($pendingMedia->count() > 0)
                <span class="bg-red-100 text-red-600 ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                    {{ $pendingMedia->count() }}
                </span>
                @endif
            </button>
            <button onclick="showTab('all')" id="all-tab" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                All Media
            </button>
        </nav>
    </div>
</div>

<!-- Pending Media Tab -->
<div id="pending-content" class="tab-content">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-yellow-50">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-clock text-yellow-600 mr-2"></i>
                Pending Media Approval ({{ $pendingMedia->count() }})
            </h3>
            <p class="text-sm text-gray-600 mt-1">Review uploaded media content and approve or reject</p>
        </div>
        
        @forelse($pendingMedia as $media)
        <div class="border-b border-gray-200 p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <!-- Media Preview -->
                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                        @if($media->type === 'image' && $media->cover_url)
                            <img src="{{ $media->cover_url }}" alt="Preview" class="w-full h-full object-cover rounded-lg">
                        @elseif($media->type === 'audio')
                            <i class="fas fa-music text-2xl text-gray-400"></i>
                        @elseif($media->type === 'video')
                            <i class="fas fa-video text-2xl text-gray-400"></i>
                        @else
                            <i class="fas fa-file text-2xl text-gray-400"></i>
                        @endif
                    </div>
                    
                    <!-- Media Info -->
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <h4 class="text-lg font-medium text-gray-900">{{ $media->title }}</h4>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($media->type) }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                            <div>
                                <strong>Uploaded by:</strong> {{ $media->user->name }}<br>
                                <strong>Email:</strong> {{ $media->user->email }}
                            </div>
                            <div>
                                <strong>Upload Date:</strong> {{ $media->created_at->format('M d, Y H:i') }}<br>
                                <strong>File Size:</strong> {{ $media->file_size_formatted }}
                            </div>
                            <div>
                                <strong>MIME Type:</strong> {{ $media->mime_type ?? 'N/A' }}<br>
                                @if($media->external_url)
                                    <strong>External URL:</strong> <a href="{{ $media->external_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">View</a>
                                @else
                                    <strong>File:</strong> {{ $media->original_filename }}
                                @endif
                            </div>
                        </div>
                        
                        @if($media->description)
                        <div class="mt-3">
                            <strong class="text-gray-700">Description:</strong>
                            <p class="text-gray-600">{{ $media->description }}</p>
                        </div>
                        @endif
                        
                        @if($media->tags && is_array($media->tags) && count($media->tags) > 0)
                        <div class="mt-3">
                            <strong class="text-gray-700">Tags:</strong>
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach($media->tags as $tag)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $tag }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex space-x-2 ml-4">
                    @if($media->file_url)
                    <a href="{{ $media->file_url }}" target="_blank" 
                       class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-2 rounded-md text-sm">
                        <i class="fas fa-external-link-alt mr-1"></i>View
                    </a>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.media.approve', $media) }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-2 rounded-md text-sm"
                                onclick="return confirm('Are you sure you want to approve this media?')">
                            <i class="fas fa-check mr-1"></i>Approve
                        </button>
                    </form>
                    
                    <button onclick="showRejectModal({{ $media->id }})" 
                            class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-2 rounded-md text-sm">
                        <i class="fas fa-times mr-1"></i>Reject
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center">
            <i class="fas fa-check-circle text-4xl text-green-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">All Caught Up!</h3>
            <p class="text-gray-600">No media pending approval at this time.</p>
        </div>
        @endforelse
    </div>
    
    @if($pendingMedia->hasPages())
    <div class="mt-4">
        {{ $pendingMedia->links() }}
    </div>
    @endif
</div>

<!-- All Media Tab -->
<div id="all-content" class="tab-content hidden">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Media</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($allMedia as $media)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                        @if($media->type === 'image' && $media->cover_url)
                                            <img src="{{ $media->cover_url }}" alt="Preview" class="w-full h-full object-cover rounded-lg">
                                        @elseif($media->type === 'audio')
                                            <i class="fas fa-music text-gray-400"></i>
                                        @elseif($media->type === 'video')
                                            <i class="fas fa-video text-gray-400"></i>
                                        @else
                                            <i class="fas fa-file text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $media->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $media->file_size_formatted }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $media->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $media->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($media->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $media->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($media->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($media->status) }}
                                </span>
                                @if($media->status === 'rejected' && $media->rejection_reason)
                                <div class="text-xs text-gray-500 mt-1" title="{{ $media->rejection_reason }}">
                                    {{ Str::limit($media->rejection_reason, 20) }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $media->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @if($media->file_url)
                                    <a href="{{ $media->file_url }}" target="_blank" 
                                       class="text-blue-600 hover:text-blue-900" title="View">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    @endif
                                    
                                    @if($media->status === 'pending')
                                        <form method="POST" action="{{ route('admin.media.approve', $media) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Approve"
                                                    onclick="return confirm('Are you sure you want to approve this media?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        
                                        <button onclick="showRejectModal({{ $media->id }})" 
                                                class="text-red-600 hover:text-red-900" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No media found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($allMedia->hasPages())
    <div class="mt-4">
        {{ $allMedia->links() }}
    </div>
    @endif
</div>

<!-- Rejection Modal -->
<div id="reject-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-times text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Reject Media</h3>
            <form id="reject-form" method="POST" class="mt-4">
                @csrf
                <div class="text-left">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for rejection:
                    </label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Please provide a reason for rejecting this media..."></textarea>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="hideRejectModal()" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                        Reject Media
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTab(tab) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-button').forEach(el => {
        el.classList.remove('border-primary', 'text-primary');
        el.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById(tab + '-content').classList.remove('hidden');
    document.getElementById(tab + '-tab').classList.remove('border-transparent', 'text-gray-500');
    document.getElementById(tab + '-tab').classList.add('border-primary', 'text-primary');
}

function showRejectModal(mediaId) {
    document.getElementById('reject-form').action = `/admin/media/${mediaId}/reject`;
    document.getElementById('reject-modal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
    document.getElementById('rejection_reason').value = '';
}

// Initialize with pending tab
document.addEventListener('DOMContentLoaded', function() {
    showTab('pending');
});

// Close modal when clicking outside
document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endsection