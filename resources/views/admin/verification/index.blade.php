@extends('layouts.app')

@section('title', 'Admin - Verification Requests')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-gray-50 dark:bg-gray-900 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Verification Requests</h1>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="space-y-6">
                    @forelse($requests as $request)
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <img class="h-12 w-12 rounded-full object-cover" 
                                         src="{{ $request->user->profile_picture ? asset('storage/' . $request->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($request->user->name) }}" 
                                         alt="{{ $request->user->name }}">
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $request->user->getDisplayName() }}</h3>
                                        <p class="text-sm text-gray-500">{{ $request->user->email }}</p>
                                        <p class="text-sm text-gray-500">Role: {{ ucfirst($request->user->role) }}</p>
                                        @if($request->user->artist_genre)
                                            <p class="text-sm text-gray-500">Genre: {{ $request->user->artist_genre }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900">Request Message:</h4>
                                    <p class="mt-1 text-sm text-gray-600">{{ $request->message }}</p>
                                </div>
                                
                                <div class="mt-2 text-sm text-gray-500">
                                    Requested on: {{ $request->created_at->format('M j, Y g:i A') }}
                                    ({{ $request->created_at->diffForHumans() }})
                                </div>
                                
                                <div class="mt-2 text-sm text-gray-500">
                                    Account active for: {{ $request->user->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-6">
                                <form method="POST" action="{{ route('admin.verification.approve', $request) }}" onsubmit="return confirm('Approve this verification request?')">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                        Approve
                                    </button>
                                </form>
                                
                                <button type="button" onclick="showRejectModal({{ $request->id }})" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Reject
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No verification requests</h3>
                        <p class="mt-1 text-sm text-gray-500">All verification requests have been processed.</p>
                    </div>
                    @endforelse
                </div>
                
                @if($requests->hasPages())
                <div class="mt-6">
                    {{ $requests->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-50 dark:bg-gray-900">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Verification Request</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Reason for rejection:</label>
                    <textarea name="admin_notes" id="admin_notes" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                              placeholder="Provide a reason for rejection..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideRejectModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(requestId) {
    document.getElementById('rejectForm').action = `/admin/verification/${requestId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('admin_notes').value = '';
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endsection