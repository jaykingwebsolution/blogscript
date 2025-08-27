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
                                        @if($request->status === 'pending') bg-yellow-900/50 text-yellow-300
                                        @elseif($request->status === 'approved') bg-green-900/50 text-green-300
                                        @elseif($request->status === 'rejected') bg-red-900/50 text-red-300
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
@endsection