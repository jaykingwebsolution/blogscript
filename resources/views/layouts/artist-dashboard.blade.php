@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-white">
    <div class="flex">
        <!-- Spotify-style Sidebar -->
        <aside class="fixed left-0 top-0 h-screen w-64 bg-black border-r border-gray-800 z-40">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-800">
                    <h1 class="text-xl font-bold text-green-400">{{ config('app.name', 'MusicApp') }}</h1>
                    <p class="text-xs text-gray-400 mt-1">Artist Dashboard</p>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 overflow-y-auto">
                    <!-- Main Sections -->
                    <div class="space-y-2">
                        <a href="{{ route('dashboard.artist') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.artist') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('dashboard.artist.my-songs') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.artist.my-songs*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                            My Music
                        </a>

                        <a href="{{ route('playlists.my-playlists') }}" 
                           class="spotify-nav-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 000 2h8a1 1 0 100-2H3zM3 10a1 1 0 000 2h8a1 1 0 100-2H3zM3 16a1 1 0 100 2h8a1 1 0 100-2H3z"/>
                            </svg>
                            Playlists
                        </a>

                        <a href="{{ route('dashboard.artist.analytics') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.artist.analytics') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                            </svg>
                            Analytics
                        </a>
                    </div>

                    <!-- Divider -->
                    <hr class="my-6 border-gray-800">

                    <!-- Create Section -->
                    <div class="space-y-2">
                        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Create</h3>
                        <a href="{{ route('dashboard.artist.upload-music') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.artist.upload-music') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Upload Music
                        </a>
                        
                        <a href="{{ route('playlists.create') }}" 
                           class="spotify-nav-link {{ request()->routeIs('playlists.create') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Create Playlist
                        </a>
                    </div>

                    <!-- Divider -->
                    <hr class="my-6 border-gray-800">

                    <!-- Account Section -->
                    <div class="space-y-2">
                        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Profile</h3>
                        <a href="{{ route('dashboard.verification') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.verification') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Verification
                        </a>

                        <a href="{{ route('dashboard.artist.earnings') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.artist.earnings') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            Earnings
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" 
                           class="spotify-nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            Settings
                        </a>
                    </div>
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-gray-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(auth()->user()->artist_stage_name ?? auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">
                                {{ auth()->user()->artist_stage_name ?? auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-400 truncate">Artist</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors" title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- Top Header -->
            <header class="sticky top-0 z-30 bg-gradient-to-r from-gray-900/90 to-black/90 backdrop-blur-sm border-b border-gray-800">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <h1 class="text-xl font-bold text-white">@yield('page-title', 'Artist Dashboard')</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Search (optional) -->
                            <div class="hidden md:block">
                                <div class="relative">
                                    <input type="text" placeholder="Search..." class="w-64 px-4 py-2 bg-gray-800 text-white rounded-full border border-gray-700 focus:border-green-400 focus:outline-none focus:ring-1 focus:ring-green-400">
                                    <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-full transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 3h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                                </svg>
                                <!-- Notification dot -->
                                <span class="absolute top-1 right-1 w-2 h-2 bg-green-400 rounded-full"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
                @yield('dashboard-content')
            </div>
        </main>
    </div>
</div>

@push('styles')
<style>
.spotify-nav-link {
    @apply flex items-center px-3 py-2 text-sm font-medium text-gray-400 rounded-lg hover:text-white hover:bg-gray-800 transition-all duration-200;
}

.spotify-nav-link.active {
    @apply text-white bg-green-500/20 border-r-2 border-green-400;
}

.spotify-nav-link svg {
    @apply mr-3 flex-shrink-0;
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgb(75 85 99);
    border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgb(107 114 128);
}
</style>
@endpush
@endsection