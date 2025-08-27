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
                            <a href="{{ route('dashboard.listener') }}" class="nav-link {{ request()->routeIs('dashboard.listener') ? 'active' : '' }}">
                                Home
                            </a>
                            <a href="{{ route('dashboard.listener.browse') }}" class="nav-link {{ request()->routeIs('dashboard.listener.browse') ? 'active' : '' }}">
                                Browse
                            </a>
                            <a href="{{ route('dashboard.listener.trending') }}" class="nav-link {{ request()->routeIs('dashboard.listener.trending') ? 'active' : '' }}">
                                Trending
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8">
                    <form action="{{ route('dashboard.listener.search') }}" method="GET" class="relative">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Search songs, artists, playlists..." 
                               class="w-full bg-gray-800 text-white placeholder-gray-400 rounded-full py-2 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
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
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:block">{{ auth()->user()->name }}</span>
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
                            <a href="{{ route('dashboard.listener') }}" 
                               class="sidebar-link {{ request()->routeIs('dashboard.listener') ? 'active' : '' }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                Home
                            </a>
                            
                            <a href="{{ route('dashboard.listener.browse') }}" 
                               class="sidebar-link {{ request()->routeIs('dashboard.listener.browse*') ? 'active' : '' }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                                Browse
                            </a>
                        </div>

                        <!-- Library -->
                        <div class="pt-8">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Your Library</h3>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('playlists.my-playlists') }}" 
                                   class="sidebar-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                    </svg>
                                    My Playlists
                                </a>
                                
                                <a href="{{ route('dashboard.liked-songs') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.liked-songs') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                    Liked Songs
                                </a>

                                <a href="{{ route('dashboard.listener.trending') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.listener.trending') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                    </svg>
                                    Trending
                                </a>
                            </div>
                        </div>

                        <!-- Account -->
                        <div class="pt-8">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Account</h3>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('dashboard.profile') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    Settings
                                </a>
                                
                                <a href="{{ route('dashboard.subscription') }}" 
                                   class="sidebar-link {{ request()->routeIs('dashboard.subscription') ? 'active' : '' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                                    </svg>
                                    Subscription
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
    @apply text-white bg-green-600;
}

.sidebar-link {
    @apply flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-800 hover:text-white transition-colors;
}

.sidebar-link.active {
    @apply bg-green-600 text-white;
}

.sidebar-link svg {
    @apply mr-3 flex-shrink-0;
}
</style>
@endsection