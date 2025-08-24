@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Statistics Cards -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-semibold">♪</div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Music</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['total_music'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center text-white font-semibold">♂</div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Artists</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['total_artists'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white font-semibold">▶</div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total Videos</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['total_videos'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-accent rounded-full flex items-center justify-center text-white font-semibold">📰</div>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total News</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['total_news'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pending Users -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Pending User Approvals</h3>
        </div>
        <div class="p-6">
            @if($stats['pending_users'] > 0)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white font-semibold">!</div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $stats['pending_users'] }} users waiting for approval</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="text-primary hover:text-secondary font-medium">Review →</a>
                </div>
            @else
                <p class="text-gray-500">No pending user approvals</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                <a href="{{ route('admin.music.create') }}" class="block w-full bg-primary text-white text-center py-2 rounded hover:bg-secondary transition-colors">
                    Add New Music
                </a>
                <a href="{{ route('admin.artists.create') }}" class="block w-full bg-secondary text-white text-center py-2 rounded hover:bg-primary transition-colors">
                    Add New Artist
                </a>
                <a href="{{ route('admin.users.index') }}" class="block w-full bg-accent text-white text-center py-2 rounded hover:bg-yellow-600 transition-colors">
                    Manage Users
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Content Overview -->
<div class="mt-8 bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Latest Music</h4>
                @forelse($recentContent['music'] ?? [] as $music)
                    <div class="text-sm text-gray-600 mb-1">{{ $music->title }}</div>
                @empty
                    <div class="text-sm text-gray-400">No music yet</div>
                @endforelse
            </div>
            
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Latest Artists</h4>
                @forelse($recentContent['artists'] ?? [] as $artist)
                    <div class="text-sm text-gray-600 mb-1">{{ $artist->name }}</div>
                @empty
                    <div class="text-sm text-gray-400">No artists yet</div>
                @endforelse
            </div>
            
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Latest Videos</h4>
                @forelse($recentContent['videos'] ?? [] as $video)
                    <div class="text-sm text-gray-600 mb-1">{{ $video->title }}</div>
                @empty
                    <div class="text-sm text-gray-400">No videos yet</div>
                @endforelse
            </div>
            
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Latest News</h4>
                @forelse($recentContent['news'] ?? [] as $news)
                    <div class="text-sm text-gray-600 mb-1">{{ $news->title }}</div>
                @empty
                    <div class="text-sm text-gray-400">No news yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection