@extends('layouts.admin-distribution')

@section('title', 'Distribution Requests Management')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-spotify-green/10 rounded-full">
                        <i class="fas fa-music text-spotify-green text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Distribution Requests</h1>
                        <p class="text-gray-600 dark:text-gray-400">Manage music distribution submissions from paid users</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.distribution.dashboard') }}" 
                       class="px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                        <i class="fas fa-music text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statusCounts['all'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Requests</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statusCounts['pending'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pending Review</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900/20 rounded-lg">
                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statusCounts['approved'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Approved</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 dark:bg-red-900/20 rounded-lg">
                        <i class="fas fa-times text-red-600 dark:text-red-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statusCounts['declined'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Declined</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <form method="GET" action="{{ route('admin.distribution.requests.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by artist, song title, genre, or user email..." 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-900 dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <select name="status" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-900 dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Declined</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-spotify-green text-white font-medium rounded-lg hover:bg-spotify-green/90 transition-colors">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.distribution.requests.index') }}" 
                       class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Requests Table -->
        <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($requests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Music</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Artist/User</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Genre</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Release Date</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($requests as $request)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($request->cover_image)
                                                <img src="{{ asset('storage/' . $request->cover_image) }}" 
                                                     alt="{{ $request->song_title }}" 
                                                     class="w-12 h-12 rounded-lg object-cover mr-4">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-music text-gray-400 dark:text-gray-500"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $request->song_title }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $request->artist_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $request->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $request->user->email }}</div>
                                        <div class="flex items-center text-xs text-gray-400 dark:text-gray-500 capitalize">
                                            {{ $request->user->role }}
                                            @if($request->user->distribution_paid)
                                                <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    <i class="fas fa-check-circle mr-1"></i>Paid
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $request->genre }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $request->release_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($request->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($request->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                            @endif">
                                            @if($request->status === 'pending')
                                                <i class="fas fa-clock mr-1"></i>
                                            @elseif($request->status === 'approved')
                                                <i class="fas fa-check mr-1"></i>
                                            @else
                                                <i class="fas fa-times mr-1"></i>
                                            @endif
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $request->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.distribution.requests.show', $request) }}" 
                                               class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($request->status === 'pending')
                                                <form method="POST" action="{{ route('admin.distribution.requests.approve', $request) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 ml-2"
                                                            onclick="return confirm('Approve this distribution request?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <button onclick="openDeclineModal({{ $request->id }})" 
                                                        class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 ml-2">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                            <form method="POST" action="{{ route('admin.distribution.requests.destroy', $request) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 ml-2"
                                                        onclick="return confirm('Delete this distribution request permanently?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $requests->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500 mb-4">
                        <i class="fas fa-music text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No distribution requests found</h3>
                    <p class="text-gray-600 dark:text-gray-400">No requests match your current filters or no paid users have submitted distribution requests.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Decline Modal -->
<div id="declineModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Decline Distribution Request</h3>
                <form id="declineForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="decline_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Reason for declining <span class="text-red-500">*</span>
                        </label>
                        <textarea id="decline_notes" name="notes" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-900 dark:bg-gray-700 text-gray-900 dark:text-white"
                                  placeholder="Please provide a reason for declining this request..."></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeDeclineModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600">
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
function openDeclineModal(requestId) {
    document.getElementById('declineForm').action = `/admin/distribution/requests/${requestId}/decline`;
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