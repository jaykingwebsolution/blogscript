@extends('layouts.app')

@section('title', 'Trending Status')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Trending Status</h1>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Current Active Trending Status -->
                @php
                    $activeTrendingRequests = $requests->where('status', 'approved')->filter(function($request) {
                        return $request->expires_at && $request->expires_at->isFuture();
                    });
                @endphp

                @if($activeTrendingRequests->isNotEmpty())
                <div class="mb-8 p-6 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border border-orange-200">
                    <h2 class="text-lg font-semibold text-orange-900 mb-4">🔥 Active Trending Status</h2>
                    @foreach($activeTrendingRequests as $activeRequest)
                    <div class="flex items-center justify-between mb-3 last:mb-0">
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $activeRequest->type === 'week' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $activeRequest->type === 'month' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $activeRequest->type === 'all-time' ? 'bg-purple-100 text-purple-800' : '' }}">
                                🔥 {{ ucfirst(str_replace('-', ' ', $activeRequest->type)) }} Trending
                            </span>
                        </div>
                        <div class="text-sm text-orange-700">
                            Expires: {{ $activeRequest->expires_at->format('M j, Y') }}
                            ({{ $activeRequest->expires_at->diffForHumans() }})
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Apply for Trending -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-green-900">Week Trending</h3>
                        </div>
                        <p class="text-sm text-green-800 mb-4">Be featured as trending for 1 week</p>
                        
                        @php
                            $hasPendingWeek = $requests->where('type', 'week')->where('status', 'pending')->isNotEmpty();
                            $hasActiveWeek = $activeTrendingRequests->where('type', 'week')->isNotEmpty();
                        @endphp
                        
                        @if($hasActiveWeek)
                            <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded cursor-not-allowed" disabled>
                                Currently Active
                            </button>
                        @elseif($hasPendingWeek)
                            <button class="w-full bg-yellow-300 text-yellow-800 py-2 px-4 rounded cursor-not-allowed" disabled>
                                Request Pending
                            </button>
                        @else
                            <button onclick="showTrendingModal('week')" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded transition-colors">
                                Apply Now
                            </button>
                        @endif
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-blue-900">Month Trending</h3>
                        </div>
                        <p class="text-sm text-blue-800 mb-4">Be featured as trending for 1 month</p>
                        
                        @php
                            $hasPendingMonth = $requests->where('type', 'month')->where('status', 'pending')->isNotEmpty();
                            $hasActiveMonth = $activeTrendingRequests->where('type', 'month')->isNotEmpty();
                        @endphp
                        
                        @if($hasActiveMonth)
                            <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded cursor-not-allowed" disabled>
                                Currently Active
                            </button>
                        @elseif($hasPendingMonth)
                            <button class="w-full bg-yellow-300 text-yellow-800 py-2 px-4 rounded cursor-not-allowed" disabled>
                                Request Pending
                            </button>
                        @else
                            <button onclick="showTrendingModal('month')" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded transition-colors">
                                Apply Now
                            </button>
                        @endif
                    </div>

                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-purple-900">All-Time Trending</h3>
                        </div>
                        <p class="text-sm text-purple-800 mb-4">Be featured as trending for 1 year</p>
                        
                        @php
                            $hasPendingAllTime = $requests->where('type', 'all-time')->where('status', 'pending')->isNotEmpty();
                            $hasActiveAllTime = $activeTrendingRequests->where('type', 'all-time')->isNotEmpty();
                        @endphp
                        
                        @if(!auth()->user()->isVerified())
                            <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded cursor-not-allowed" disabled>
                                Verification Required
                            </button>
                        @elseif($hasActiveAllTime)
                            <button class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded cursor-not-allowed" disabled>
                                Currently Active
                            </button>
                        @elseif($hasPendingAllTime)
                            <button class="w-full bg-yellow-300 text-yellow-800 py-2 px-4 rounded cursor-not-allowed" disabled>
                                Request Pending
                            </button>
                        @else
                            <button onclick="showTrendingModal('all-time')" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded transition-colors">
                                Apply Now
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Request History -->
                @if($requests->isNotEmpty())
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Request History</h2>
                    <div class="space-y-4">
                        @foreach($requests->sortByDesc('created_at') as $request)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $request->type === 'week' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $request->type === 'month' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $request->type === 'all-time' ? 'bg-purple-100 text-purple-800' : '' }}">
                                            {{ ucfirst(str_replace('-', ' ', $request->type)) }}
                                        </span>
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        <span class="ml-3 text-sm text-gray-500">
                                            {{ $request->created_at->format('M j, Y g:i A') }}
                                        </span>
                                    </div>
                                    
                                    <p class="mt-2 text-sm text-gray-700">{{ $request->message }}</p>
                                    
                                    @if($request->admin_notes && $request->status === 'rejected')
                                        <div class="mt-2 p-3 bg-red-50 rounded">
                                            <p class="text-sm text-red-800"><strong>Admin Response:</strong> {{ $request->admin_notes }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($request->expires_at && $request->status === 'approved')
                                        <p class="mt-1 text-xs text-gray-500">
                                            @if($request->expires_at->isFuture())
                                                Expires: {{ $request->expires_at->format('M j, Y') }} ({{ $request->expires_at->diffForHumans() }})
                                            @else
                                                Expired: {{ $request->expires_at->format('M j, Y') }}
                                            @endif
                                        </p>
                                    @endif
                                    
                                    @if($request->reviewed_at)
                                        <p class="mt-1 text-xs text-gray-500">
                                            Reviewed {{ $request->reviewed_at->format('M j, Y g:i A') }}
                                            @if($request->reviewer)
                                                by {{ $request->reviewer->name }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Trending Request Modal -->
<div id="trendingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-4">Apply for Trending</h3>
            <form id="trendingForm" method="POST" action="{{ route('dashboard.trending.store') }}">
                @csrf
                <input type="hidden" name="type" id="trendingType">
                <div class="mb-4">
                    <label for="trending_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Why should you be trending? *
                    </label>
                    <textarea name="message" id="trending_message" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                              placeholder="Tell us about your recent achievements, viral content, or why you deserve trending status..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideTrendingModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTrendingModal(type) {
    document.getElementById('trendingType').value = type;
    document.getElementById('modalTitle').textContent = `Apply for ${type.charAt(0).toUpperCase() + type.slice(1).replace('-', ' ')} Trending`;
    document.getElementById('trendingModal').classList.remove('hidden');
}

function hideTrendingModal() {
    document.getElementById('trendingModal').classList.add('hidden');
    document.getElementById('trending_message').value = '';
}

// Close modal when clicking outside
document.getElementById('trendingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideTrendingModal();
    }
});
</script>
@endsection