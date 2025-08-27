@extends('admin.layout')

@section('title', 'Distribution Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-gray-50 dark:bg-gray-900 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-spotify-green/10 rounded-full">
                        <i class="fas fa-cloud-upload-alt text-spotify-green text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Distribution Dashboard</h1>
                        <p class="text-gray-600 dark:text-gray-400">Manage music distribution requests, pricing and analytics</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Total Requests -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <i class="fas fa-music text-blue-600 dark:text-blue-400"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Requests</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_requests']) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Requests</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['pending_requests']) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approved Requests -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Approved Requests</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['approved_requests']) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Declined Requests -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                <i class="fas fa-times text-red-600 dark:text-red-400"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Declined Requests</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['declined_requests']) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paid Users -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-purple-600 dark:text-purple-400"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Paid Users</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['paid_users_count']) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Plans -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tags text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Pricing Plans</div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_pricing_plans']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('admin.distribution.requests.index') }}" 
                           class="flex items-center justify-center px-4 py-3 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                            <i class="fas fa-list mr-2"></i>
                            View All Requests
                        </a>
                        <a href="{{ route('admin.distribution.pricing.index') }}" 
                           class="flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-dollar-sign mr-2"></i>
                            Manage Pricing
                        </a>
                        <a href="{{ route('admin.distribution.pricing.create') }}" 
                           class="flex items-center justify-center px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                            <i class="fas fa-plus mr-2"></i>
                            Add Pricing Plan
                        </a>
                        <a href="{{ route('admin.distribution.requests.index', ['status' => 'pending']) }}" 
                           class="flex items-center justify-center px-4 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors font-medium">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Review Pending
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Current Pricing Plans</h3>
                </div>
                <div class="p-6">
                    @if($pricingPlans->count() > 0)
                        <div class="space-y-3">
                            @foreach($pricingPlans->take(5) as $plan)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $plan->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->duration }}</div>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $plan->formatted_price }}</div>
                                </div>
                            @endforeach
                            @if($pricingPlans->count() > 5)
                                <div class="pt-2">
                                    <a href="{{ route('admin.distribution.pricing.index') }}" class="text-sm text-spotify-green hover:text-spotify-green/80">
                                        View all {{ $pricingPlans->count() }} pricing plans →
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-6">
                            <div class="text-gray-400 dark:text-gray-500 mb-2">
                                <i class="fas fa-tags text-3xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">No pricing plans configured yet</p>
                            <a href="{{ route('admin.distribution.pricing.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Create First Plan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        @if($recentRequests->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Distribution Requests</h3>
                    <a href="{{ route('admin.distribution.requests.index') }}" class="text-sm text-spotify-green hover:text-spotify-green/80">
                        View all →
                    </a>
                </div>
            </div>
            <div class="overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Artist</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Song</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentRequests as $request)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->artist_name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $request->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $request->song_title }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $request->genre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($request->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @elseif($request->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                    @endif">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $request->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.distribution.requests.show', $request) }}" 
                                   class="text-spotify-green hover:text-spotify-green/80">
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 text-center py-12">
            <div class="text-gray-400 dark:text-gray-500 mb-4">
                <i class="fas fa-music text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Distribution Requests Yet</h3>
            <p class="text-gray-500 dark:text-gray-400">Distribution requests from paid users will appear here.</p>
        </div>
        @endif
    </div>
</div>
@endsection