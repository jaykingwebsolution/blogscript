@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black text-white">
    <!-- Top Header Navigation -->
    <header class="bg-gradient-to-r from-gray-900 via-green-900 to-gray-900 border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo and Dashboard Title -->
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-2 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-green-400">{{ config('app.name', 'MusicApp') }}</h1>
                        <p class="text-xs text-gray-400">Artist Dashboard</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('dashboard.artist') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.artist') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Home
                    </a>
                    
                    <a href="{{ route('dashboard.artist.my-songs') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.artist.my-songs*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                        </svg>
                        My Music
                    </a>

                    <a href="{{ route('dashboard.artist.upload-music') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.artist.upload-music') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload
                    </a>

                    <a href="{{ route('playlists.my-playlists') }}" 
                       class="nav-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 000 2h8a1 1 0 100-2H3zM3 10a1 1 0 000 2h8a1 1 0 100-2H3zM3 16a1 1 0 100 2h8a1 1 0 100-2H3z"/>
                        </svg>
                        Playlists
                    </a>

                    <a href="{{ route('dashboard.artist.analytics') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.artist.analytics') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                        Analytics
                    </a>

                    <a href="{{ route('dashboard.artist.earnings') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.artist.earnings') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                        Earnings
                    </a>
                </nav>

                <!-- User Menu and Mobile Menu Button -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="hidden lg:block">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="w-64 px-4 py-2 bg-gray-800 text-white rounded-full border border-gray-700 focus:border-green-400 focus:outline-none focus:ring-1 focus:ring-green-400 text-sm">
                            <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-400 hover:text-green-400 hover:bg-gray-800 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 3h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-green-400 rounded-full"></span>
                    </button>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(auth()->user()->artist_stage_name ?? auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-medium text-white truncate">
                                {{ Str::limit(auth()->user()->artist_stage_name ?? auth()->user()->name, 20) }}
                            </p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors p-1" title="Logout">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Mobile menu button -->
                    <button class="md:hidden text-gray-400 hover:text-white p-2" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden border-t border-gray-800">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard.artist') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.artist') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Home
                    </a>
                    <a href="{{ route('dashboard.artist.my-songs') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.artist.my-songs*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                        </svg>
                        My Music
                    </a>
                    <a href="{{ route('dashboard.artist.upload-music') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.artist.upload-music') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload Music
                    </a>
                    <a href="{{ route('playlists.my-playlists') }}" 
                       class="mobile-nav-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 000 2h8a1 1 0 100-2H3zM3 10a1 1 0 000 2h8a1 1 0 100-2H3zM3 16a1 1 0 100 2h8a1 1 0 100-2H3z"/>
                        </svg>
                        Playlists
                    </a>
                    <a href="{{ route('dashboard.artist.analytics') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.artist.analytics') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                        Analytics
                    </a>
                    <a href="{{ route('dashboard.artist.earnings') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.artist.earnings') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                        Earnings
                    </a>
                    <hr class="border-gray-700 my-3">
                    <a href="{{ route('dashboard.profile') }}" class="mobile-nav-link">Settings</a>
                    <a href="{{ route('dashboard.verification') }}" class="mobile-nav-link">Verification</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('dashboard-content')
    </main>
</div>

@push('styles')
<style>
/* Navigation Links */
.nav-link {
    @apply flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-all duration-200 backdrop-blur-sm;
}

.nav-link.active {
    @apply text-white bg-green-500/20 border-l-2 border-green-400;
}

.nav-link svg {
    @apply flex-shrink-0;
}

/* Mobile Navigation */
.mobile-nav-link {
    @apply flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-all duration-200;
}

.mobile-nav-link.active {
    @apply text-white bg-green-500/20 border-l-2 border-green-400;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

/* Card hover effects */
.card-hover {
    @apply transition-all duration-300 hover:scale-105 hover:shadow-2xl;
}

/* Gradient text */
.gradient-text {
    @apply bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent;
}

/* Responsive Design */
@media (max-width: 768px) {
    #mobile-menu {
        @apply bg-gray-900/95 backdrop-blur-md;
    }
}
</style>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('mobile-menu');
    const button = event.target.closest('[onclick="toggleMobileMenu()"]');
    
    if (!menu.contains(event.target) && !button) {
        menu.classList.add('hidden');
    }
});
</script>
@endpush
@endsection