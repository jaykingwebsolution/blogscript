@extends('admin.layout')

@section('title', 'Content Moderation')

@section('header', 'Content Moderation')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-spotify-green rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Content Moderation</h1>
                    <p class="text-spotify-light-gray mt-1">Review and moderate platform content for quality and compliance</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <a href="{{ route('admin.moderation.settings') }}" class="bg-spotify-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-spotify-green-light transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Moderation Settings
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Pending Review</p>
                    <p class="text-3xl font-bold text-yellow-400">{{ $stats['pending_review'] ?? 23 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Flagged Content</p>
                    <p class="text-3xl font-bold text-red-400">{{ $stats['flagged_content'] ?? 7 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6H8.5l-1 1H5a2 2 0 01-2-2zm9-13.5V9"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Approved Today</p>
                    <p class="text-3xl font-bold text-spotify-green">{{ $stats['approved_today'] ?? 45 }}</p>
                </div>
                <div class="w-12 h-12 bg-spotify-green rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">User Reports</p>
                    <p class="text-3xl font-bold text-purple-400">{{ $stats['user_reports'] ?? 12 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- TODO Notice -->
    <div class="bg-yellow-900 bg-opacity-20 border border-yellow-500 text-yellow-400 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                <p class="font-semibold">TODO: Implementation Required</p>
                <p class="text-sm">This content moderation system requires full implementation including automated flagging, manual review workflows, and reporting systems.</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray mb-8">
        <h2 class="text-xl font-semibold text-white mb-4">Quick Moderation Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <button class="bg-yellow-600 text-white px-4 py-3 rounded-lg hover:bg-yellow-700 transition-colors text-left">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <div class="font-semibold">Bulk Approve</div>
                        <div class="text-sm opacity-80">23 items pending</div>
                    </div>
                </div>
            </button>
            <button class="bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 transition-colors text-left">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <div>
                        <div class="font-semibold">Review Flagged</div>
                        <div class="text-sm opacity-80">7 items flagged</div>
                    </div>
                </div>
            </button>
            <button class="bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700 transition-colors text-left">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <div>
                        <div class="font-semibold">User Reports</div>
                        <div class="text-sm opacity-80">12 reports waiting</div>
                    </div>
                </div>
            </button>
            <button class="bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors text-left">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div>
                        <div class="font-semibold">View Logs</div>
                        <div class="text-sm opacity-80">Activity history</div>
                    </div>
                </div>
            </button>
        </div>
    </div>

    <!-- Content Type Navigation -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('admin.moderation.music') }}" class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray hover:border-spotify-green transition-colors group">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg">Music Tracks</h3>
                    <p class="text-spotify-light-gray text-sm">Review uploaded music</p>
                    <p class="text-yellow-400 font-medium">15 pending</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.moderation.artists') }}" class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray hover:border-spotify-green transition-colors group">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center group-hover:bg-purple-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg">Artist Profiles</h3>
                    <p class="text-spotify-light-gray text-sm">Verify artist accounts</p>
                    <p class="text-yellow-400 font-medium">5 pending</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.moderation.posts') }}" class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray hover:border-spotify-green transition-colors group">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center group-hover:bg-green-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg">Blog Posts</h3>
                    <p class="text-spotify-light-gray text-sm">Review news & articles</p>
                    <p class="text-yellow-400 font-medium">3 pending</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.moderation.comments') }}" class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray hover:border-spotify-green transition-colors group">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center group-hover:bg-orange-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg">Comments</h3>
                    <p class="text-spotify-light-gray text-sm">Moderate user comments</p>
                    <p class="text-red-400 font-medium">8 flagged</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Recent Moderation Activity -->
    <div class="bg-spotify-gray rounded-xl border border-spotify-gray overflow-hidden">
        <div class="p-6 border-b border-spotify-light-gray">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-white">Recent Moderation Activity</h2>
                    <p class="text-spotify-light-gray text-sm mt-1">Latest content review actions</p>
                </div>
                <a href="{{ route('admin.moderation.logs') }}" class="text-spotify-green hover:text-spotify-green-light">
                    View All Logs
                </a>
            </div>
        </div>
        
        <div class="divide-y divide-spotify-light-gray">
            <!-- Sample Activity Items -->
            <div class="p-6 hover:bg-spotify-black transition-colors">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-spotify-green rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white font-medium">Music track approved</p>
                                <p class="text-spotify-light-gray text-sm">"Best Hip Hop Track 2024" by Artist Name</p>
                            </div>
                            <span class="text-spotify-light-gray text-sm">2 minutes ago</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 hover:bg-spotify-black transition-colors">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white font-medium">Comment flagged for review</p>
                                <p class="text-spotify-light-gray text-sm">Inappropriate content reported by user</p>
                            </div>
                            <span class="text-spotify-light-gray text-sm">15 minutes ago</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 hover:bg-spotify-black transition-colors">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white font-medium">Artist verification pending</p>
                                <p class="text-spotify-light-gray text-sm">New artist profile requires verification</p>
                            </div>
                            <span class="text-spotify-light-gray text-sm">1 hour ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection