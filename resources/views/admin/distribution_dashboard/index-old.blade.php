@extends('layouts.admin-distribution')

@section('title', 'Distribution Dashboard')

@section('header-title', 'Distribution Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <div class="flex items-center">
                <div class="p-3 bg-spotify-green/10 rounded-lg">
                    <i class="fas fa-music text-spotify-green text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-400">Total Submissions</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($stats['total_requests'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-500/10 rounded-lg">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-400">Pending Review</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($stats['pending_requests'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <div class="flex items-center">
                <div class="p-3 bg-green-500/10 rounded-lg">
                    <i class="fas fa-check text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-400">Approved</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($stats['approved_requests'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <div class="flex items-center">
                <div class="p-3 bg-distro-admin-accent/10 rounded-lg">
                    <i class="fas fa-users text-distro-admin-accent text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-400">Active Artists</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($stats['active_artists'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.distribution.requests.index') }}" 
           class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border hover:border-spotify-green transition-colors group">
            <div class="flex items-center justify-center mb-4">
                <div class="p-3 bg-spotify-green/10 rounded-lg group-hover:bg-spotify-green/20 transition-colors">
                    <i class="fas fa-list text-spotify-green text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-white text-center mb-2">View All Requests</h3>
            <p class="text-gray-400 text-center text-sm">Manage all distribution submissions</p>
        </a>
        
        <a href="{{ route('admin.distribution.pricing.index') }}" 
           class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border hover:border-distro-admin-accent transition-colors group">
            <div class="flex items-center justify-center mb-4">
                <div class="p-3 bg-distro-admin-accent/10 rounded-lg group-hover:bg-distro-admin-accent/20 transition-colors">
                    <i class="fas fa-dollar-sign text-distro-admin-accent text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-white text-center mb-2">Manage Pricing</h3>
            <p class="text-gray-400 text-center text-sm">Configure distribution plans</p>
        </a>
        
        <a href="{{ route('admin.distribution.pricing.create') }}" 
           class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border hover:border-purple-500 transition-colors group">
            <div class="flex items-center justify-center mb-4">
                <div class="p-3 bg-purple-500/10 rounded-lg group-hover:bg-purple-500/20 transition-colors">
                    <i class="fas fa-plus text-purple-500 text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-white text-center mb-2">Add Pricing Plan</h3>
            <p class="text-gray-400 text-center text-sm">Create new distribution plans</p>
        </a>
        
        <a href="{{ route('admin.distribution.requests.index', ['status' => 'pending']) }}" 
           class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border hover:border-yellow-500 transition-colors group">
            <div class="flex items-center justify-center mb-4">
                <div class="p-3 bg-yellow-500/10 rounded-lg group-hover:bg-yellow-500/20 transition-colors">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-white text-center mb-2">Pending Requests</h3>
            <p class="text-gray-400 text-center text-sm">Review submissions awaiting approval</p>
        </a>
    </div>

    <!-- Recent Submissions -->
    <div class="bg-distro-admin-card rounded-lg border border-distro-admin-border overflow-hidden">
        <div class="px-6 py-4 border-b border-distro-admin-border">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Recent Submissions</h2>
                <a href="{{ route('admin.distribution.requests.index') }}" class="text-sm text-distro-admin-accent hover:text-indigo-400 transition-colors">
                    View all →
                </a>
            </div>
        </div>
        <div class="overflow-hidden">
            @if(isset($recentRequests) && $recentRequests->count() > 0)
                <table class="w-full">
                    <thead class="bg-distro-admin-bg">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Artist</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Song</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-distro-admin-border">
                        @foreach($recentRequests as $request)
                            <tr class="hover:bg-distro-admin-bg transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-distro-admin-accent rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($request->artist_name, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-white">{{ $request->artist_name }}</div>
                                            <div class="text-sm text-gray-400">{{ $request->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-white">{{ $request->song_title }}</div>
                                    <div class="text-sm text-gray-400">{{ $request->genre }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($request->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($request->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($request->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ $request->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.distribution.requests.show', $request) }}" 
                                       class="text-distro-admin-accent hover:text-indigo-400 transition-colors">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center">
                    <i class="fas fa-music text-gray-600 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-white mb-2">No submissions yet</h3>
                    <p class="text-gray-400">Distribution requests will appear here when artists submit music.</p>
                </div>
            @endif
        </div>
    </div>
</div>
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