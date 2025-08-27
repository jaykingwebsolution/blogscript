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
                    <p class="text-xs text-gray-400 mt-1">Listener Dashboard</p>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 overflow-y-auto">
                    <!-- Main Sections -->
                    <div class="space-y-2">
                        <a href="{{ route('dashboard.listener') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.listener') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Home
                        </a>
                        
                        <a href="{{ route('dashboard.listener.browse') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.listener.browse') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Browse
                        </a>

                        <a href="{{ route('dashboard.listener.trending') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.listener.trending') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            Trending
                        </a>

                        <a href="{{ route('music.liked') }}" 
                           class="spotify-nav-link {{ request()->routeIs('music.liked') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                            Liked Songs
                        </a>
                    </div>

                    <!-- Divider -->
                    <hr class="my-6 border-gray-800">

                    <!-- Library Section -->
                    <div class="space-y-2">
                        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Your Library</h3>
                        <a href="{{ route('playlists.my-playlists') }}" 
                           class="spotify-nav-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 000 2h8a1 1 0 100-2H3zM3 10a1 1 0 000 2h8a1 1 0 100-2H3zM3 16a1 1 0 100 2h8a1 1 0 100-2H3z"/>
                            </svg>
                            My Playlists
                        </a>
                        
                        <a href="{{ route('playlists.create') }}" 
                           class="spotify-nav-link {{ request()->routeIs('playlists.create') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Playlist
                        </a>
                        
                        <a href="{{ route('dashboard.library') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.library') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            Recently Played
                        </a>
                    </div>

                    <!-- Divider -->
                    <hr class="my-6 border-gray-800">

                    <!-- Account Section -->
                    <div class="space-y-2">
                        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Profile</h3>
                        <a href="{{ route('dashboard.subscription') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.subscription') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                            </svg>
                            Subscription
                        </a>
                        
                        <a href="{{ route('dashboard.profile') }}" 
                           class="spotify-nav-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
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
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-400 truncate">Listener</p>
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
                            <h1 class="text-xl font-bold text-white">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <div class="hidden md:block">
                                <div class="relative">
                                    <input type="text" placeholder="Search songs, artists, playlists..." class="w-80 px-4 py-2 bg-gray-800 text-white rounded-full border border-gray-700 focus:border-green-400 focus:outline-none focus:ring-1 focus:ring-green-400">
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

/* Mobile responsiveness */
@media (max-width: 768px) {
    aside {
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
    }
    
    aside.mobile-open {
        transform: translateX(0);
    }
    
    main {
        margin-left: 0;
    }
}
</style>
@endpush
@endsection
