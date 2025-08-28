@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Enhanced Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Content Statistics -->
    <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-semibold">♪</div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Music</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_music'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center text-white font-semibold">👥</div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Users</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_users'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">💰</div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Revenue</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">₦{{ number_format($stats['total_revenue'] ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">📊</div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Subscriptions</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($stats['active_subscriptions'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Signup Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Today</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['new_signups_today'] ?? 0 }}</p>
                </div>
                <div class="text-green-500">📈</div>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">New signups</p>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">This Week</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['new_signups_this_week'] ?? 0 }}</p>
                </div>
                <div class="text-blue-500">📊</div>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">New signups</p>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">This Month</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['new_signups_this_month'] ?? 0 }}</p>
                </div>
                <div class="text-purple-500">📅</div>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">New signups</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Pending Items -->
    <div class="lg:col-span-2">
        <!-- Pending Approvals -->
        <div class="bg-gray-50 dark:bg-gray-900 shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pending Approvals</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Pending Users -->
                    <a href="{{ route('admin.users.index') }}" class="block p-4 bg-yellow-50 dark:bg-yellow-900 dark:bg-opacity-30 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900 dark:hover:bg-opacity-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">{{ $stats['pending_users'] }}</div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Users</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Pending approval</p>
                            </div>
                        </div>
                    </a>

                    <!-- Pending Uploads -->
                    <a href="{{ route('admin.media.index') }}" class="block p-4 bg-blue-50 dark:bg-blue-900 dark:bg-opacity-30 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 dark:hover:bg-opacity-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">{{ $stats['pending_uploads'] }}</div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Uploads</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Pending review</p>
                            </div>
                        </div>
                    </a>

                    <!-- Pending Verifications -->
                    <a href="{{ route('admin.verification.index') }}" class="block p-4 bg-green-50 dark:bg-green-900 dark:bg-opacity-30 rounded-lg hover:bg-green-100 dark:hover:bg-green-900 dark:hover:bg-opacity-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">{{ $stats['pending_verifications'] }}</div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Verifications</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Pending review</p>
                            </div>
                        </div>
                    </a>

                    <!-- Pending Trending -->
                    <a href="{{ route('admin.trending.index') }}" class="block p-4 bg-purple-50 dark:bg-purple-900 dark:bg-opacity-30 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900 dark:hover:bg-opacity-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">{{ $stats['pending_trending'] }}</div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Trending</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Pending review</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-gray-50 dark:bg-gray-900 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Activity</h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @if(isset($recentContent['pending_requests']['verifications']) && count($recentContent['pending_requests']['verifications']) > 0)
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-3">Recent Verification Requests</h4>
                        @foreach($recentContent['pending_requests']['verifications'] as $verification)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 dark:bg-opacity-50 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-green-800 dark:text-green-400">{{ substr($verification->user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $verification->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $verification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="text-xs bg-yellow-100 dark:bg-yellow-900 dark:bg-opacity-50 text-yellow-800 dark:text-yellow-400 px-2 py-1 rounded-full">Pending</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if(isset($recentContent['users']) && count($recentContent['users']) > 0)
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-3">Latest Users</h4>
                        @foreach($recentContent['users'] as $user)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-300">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->role }} • {{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full {{ $user->status === 'approved' ? 'bg-green-100 dark:bg-green-900 dark:bg-opacity-50 text-green-800 dark:text-green-400' : ($user->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 dark:bg-opacity-50 text-yellow-800 dark:text-yellow-400' : 'bg-red-100 dark:bg-red-900 dark:bg-opacity-50 text-red-800 dark:text-red-400') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-6">
        <div class="bg-gray-50 dark:bg-gray-900 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="{{ route('admin.users.create') }}" class="block w-full bg-primary text-white text-center py-3 rounded-lg hover:bg-secondary transition-colors font-medium">
                        <i class="fas fa-user-plus mr-2"></i>Create User
                    </a>
                    <a href="{{ route('admin.music.create') }}" class="block w-full bg-secondary text-white text-center py-3 rounded-lg hover:bg-primary transition-colors font-medium">
                        <i class="fas fa-music mr-2"></i>Add Music
                    </a>
                    <a href="{{ route('admin.notifications.create') }}" class="block w-full bg-purple-600 text-white text-center py-3 rounded-lg hover:bg-purple-700 transition-colors font-medium">
                        <i class="fas fa-bell mr-2"></i>Send Notification
                    </a>
                </div>
            </div>
        </div>

        <!-- User Role Distribution -->
        @if(isset($userRoleStats) && !empty($userRoleStats))
        <div class="bg-gray-50 dark:bg-gray-900 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">User Distribution</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($userRoleStats as $role => $count)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full {{ 
                                $role === 'admin' ? 'bg-red-500' : 
                                ($role === 'artist' ? 'bg-blue-500' : 
                                ($role === 'record_label' ? 'bg-purple-500' : 
                                'bg-gray-500')) 
                            }}"></div>
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ ucwords(str_replace('_', ' ', $role)) }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($count) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="bg-gray-50 dark:bg-gray-900 shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Content Overview</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-3 flex items-center">
                    <i class="fas fa-music text-primary mr-2"></i>Latest Music
                </h4>
                @forelse($recentContent['music'] ?? [] as $music)
                    <div class="flex items-center justify-between mb-2 pb-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $music->title }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">by {{ $music->artist_name }}</div>
                        </div>
                        @if($music->is_featured)
                            <span class="text-xs bg-yellow-100 dark:bg-yellow-900 dark:bg-opacity-50 text-yellow-800 dark:text-yellow-400 px-1 py-0.5 rounded">★</span>
                        @endif
                    </div>
                @empty
                    <div class="text-sm text-gray-400 dark:text-gray-500">No music yet</div>
                @endforelse
            </div>
            
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-3 flex items-center">
                    <i class="fas fa-microphone text-secondary mr-2"></i>Latest Artists
                </h4>
                @forelse($recentContent['artists'] ?? [] as $artist)
                    <div class="flex items-center justify-between mb-2 pb-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $artist->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $artist->genre ?? 'No genre' }}</div>
                        </div>
                        @if($artist->is_trending)
                            <span class="text-xs bg-red-100 dark:bg-red-900 dark:bg-opacity-50 text-red-800 dark:text-red-400 px-1 py-0.5 rounded">🔥</span>
                        @endif
                    </div>
                @empty
                    <div class="text-sm text-gray-400 dark:text-gray-500">No artists yet</div>
                @endforelse
            </div>
            
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-3 flex items-center">
                    <i class="fas fa-video text-red-500 mr-2"></i>Latest Videos
                </h4>
                @forelse($recentContent['videos'] ?? [] as $video)
                    <div class="mb-2 pb-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $video->title }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $video->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="text-sm text-gray-400 dark:text-gray-500">No videos yet</div>
                @endforelse
            </div>
            
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-3 flex items-center">
                    <i class="fas fa-newspaper text-green-500 mr-2"></i>Latest News
                </h4>
                @forelse($recentContent['news'] ?? [] as $news)
                    <div class="mb-2 pb-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $news->title }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $news->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="text-sm text-gray-400 dark:text-gray-500">No news yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection