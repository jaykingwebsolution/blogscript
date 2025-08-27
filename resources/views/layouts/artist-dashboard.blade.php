@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 text-white">
    <!-- Top Navigation -->
    <nav class="bg-gray-900 border-b border-gray-700 sticky top-0 z-50">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Main Nav -->
                <div class="flex items-center space-x-8">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-green-400">{{ config('app.name', 'MusicApp') }}</h1>
                    </div>
                    <div class="hidden md:block">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('dashboard.artist') }}" class="nav-link {{ request()->routeIs('dashboard.artist') ? 'active' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('dashboard.artist.analytics') }}" class="nav-link {{ request()->routeIs('dashboard.artist.analytics') ? 'active' : '' }}">
                                Analytics
                            </a>
                            <a href="{{ route('dashboard.artist.my-songs') }}" class="nav-link {{ request()->routeIs('dashboard.artist.my-songs*') ? 'active' : '' }}">
                                My Music
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search your music, analytics..." 
                               class="w-full bg-gray-800 text-white placeholder-gray-400 rounded-full py-2 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <button class="absolute right-3 top-2 text-gray-400 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button class="p-2 rounded-full hover:bg-gray-800 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM5 7h14l-2-2H7l-2 2zm2 3v6a2 2 0 002 2h6a2 2 0 002-2v-6H7z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 p-2 rounded-full hover:bg-gray-800 transition-colors">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                {{ substr(auth()->user()->artist_stage_name ?? auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:block">{{ auth()->user()->artist_stage_name ?? auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-gray-900 border-r border-gray-700">
                <div class="flex-1 flex flex-col min-h-0 px-4 py-6">
                    <nav class="flex-1 space-y-1">
                        <!-- Main Navigation -->
                        <div class="space-y-1">
                            <a href="{{ route('dashboard.artist') }}" 
                               class="sidebar-link {{ request()->routeIs('dashboard.artist') ? 'active' : '' }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="{{ route('dashboard.artist.analytics') }}" 
                               class="sidebar-link {{ request()->routeIs('dashboard.artist.analytics') ? 'active' : '' }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                Analytics
                            </a>
                        </div>

                        <!-- Music Management -->
                        <div class="pt-8">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Music</h3>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('dashboard.artist.upload-music') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.artist.upload-music') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Upload Music
                                </a>
                                
                                <a href="{{ route('dashboard.artist.my-songs') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.artist.my-songs*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                    </svg>
                                    My Songs
                                </a>
                                
                                <a href="{{ route('playlists.create') }}" 
                                   class="sidebar-link {{ request()->routeIs('playlists.create') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Create Playlist
                                </a>
                                
                                <a href="{{ route('playlists.my-playlists') }}" 
                                   class="sidebar-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                    </svg>
                                    My Playlists
                                </a>
                            </div>
                        </div>

                        <!-- Distribution -->
                        <div class="pt-8">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Distribution</h3>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('dashboard.artist.submit-song') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.artist.submit-song*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    Distribution
                                </a>
                                
                                <a href="{{ route('dashboard.artist.submit-trending-song') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.artist.submit-trending*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                    </svg>
                                    Submit Trending
                                </a>
                                
                                <a href="{{ route('dashboard.artist.submit-trending-mixtape') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.artist.submit-trending-mixtape*') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/>
                                    </svg>
                                    Submit Mixtape
                                </a>
                            </div>
                        </div>

                        <!-- Earnings & Analytics -->
                        <div class="pt-8">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Business</h3>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('dashboard.artist.earnings') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.artist.earnings') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                    Earnings
                                </a>
                            </div>
                        </div>

                        <!-- Account -->
                        <div class="pt-8">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Account</h3>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('dashboard.verification') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.verification') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Verification
                                </a>
                                
                                <a href="{{ route('dashboard.profile') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    Settings
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            @yield('dashboard-content')
        </main>
    </div>
</div>

<style>
.nav-link {
    @apply text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors;
}

.nav-link.active {
    @apply text-white bg-purple-600;
}

.sidebar-link {
    @apply flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors;
}

.sidebar-link.active {
    @apply bg-purple-600 text-white;
}

.sidebar-link svg {
    @apply mr-3 flex-shrink-0;
}
</style>
@endsection