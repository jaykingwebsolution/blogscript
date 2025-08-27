@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black text-white">
    <!-- Top Header Navigation -->
    <header class="bg-gradient-to-r from-gray-900 via-purple-900 to-gray-900 border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo and Dashboard Title -->
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-br from-purple-400 to-pink-600 p-2 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-purple-400">{{ config('app.name', 'MusicApp') }}</h1>
                        <p class="text-xs text-gray-400">Listener Dashboard</p>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('dashboard.listener') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.listener') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Home
                    </a>
                    
                    <a href="{{ route('dashboard.listener.browse') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.listener.browse') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Browse
                    </a>

                    <a href="{{ route('dashboard.listener.trending') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.listener.trending') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        Trending
                    </a>

                    <a href="{{ route('music.liked') }}" 
                       class="nav-link {{ request()->routeIs('music.liked') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        Liked Songs
                    </a>

                    <a href="{{ route('playlists.my-playlists') }}" 
                       class="nav-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 000 2h8a1 1 0 100-2H3zM3 10a1 1 0 000 2h8a1 1 0 100-2H3zM3 16a1 1 0 100 2h8a1 1 0 100-2H3z"/>
                        </svg>
                        Playlists
                    </a>

                    <a href="{{ route('dashboard.library') }}" 
                       class="nav-link {{ request()->routeIs('dashboard.library') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                        </svg>
                        Recent
                    </a>
                </nav>

                <!-- User Menu and Mobile Menu Button -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="hidden lg:block">
                        <div class="relative">
                            <input type="text" placeholder="Search songs, artists..." class="w-80 px-4 py-2 bg-gray-800 text-white rounded-full border border-gray-700 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400 text-sm">
                            <svg class="absolute right-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-400 hover:text-purple-400 hover:bg-gray-800 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 3h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-purple-400 rounded-full"></span>
                    </button>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-medium text-white truncate">
                                {{ Str::limit(auth()->user()->name, 20) }}
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
                    <a href="{{ route('dashboard.listener') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.listener') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Home
                    </a>
                    <a href="{{ route('dashboard.listener.browse') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.listener.browse') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Browse
                    </a>
                    <a href="{{ route('dashboard.listener.trending') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.listener.trending') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        Trending
                    </a>
                    <a href="{{ route('music.liked') }}" 
                       class="mobile-nav-link {{ request()->routeIs('music.liked') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        Liked Songs
                    </a>
                    <a href="{{ route('playlists.my-playlists') }}" 
                       class="mobile-nav-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 000 2h8a1 1 0 100-2H3zM3 10a1 1 0 000 2h8a1 1 0 100-2H3zM3 16a1 1 0 100 2h8a1 1 0 100-2H3z"/>
                        </svg>
                        My Playlists
                    </a>
                    <a href="{{ route('playlists.create') }}" 
                       class="mobile-nav-link {{ request()->routeIs('playlists.create') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Playlist
                    </a>
                    <a href="{{ route('dashboard.library') }}" 
                       class="mobile-nav-link {{ request()->routeIs('dashboard.library') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                        </svg>
                        Recent
                    </a>
                    <hr class="border-gray-700 my-3">
                    <a href="{{ route('dashboard.profile') }}" class="mobile-nav-link">Settings</a>
                    <a href="{{ route('dashboard.subscription') }}" class="mobile-nav-link">Subscription</a>
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
/* Navigation Links - Listener theme with purple accent */
.nav-link {
    @apply flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-all duration-200 backdrop-blur-sm;
}

.nav-link.active {
    @apply text-white bg-purple-500/20 border-l-2 border-purple-400;
}

.nav-link svg {
    @apply flex-shrink-0;
}

/* Mobile Navigation */
.mobile-nav-link {
    @apply flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800/50 rounded-lg transition-all duration-200;
}

.mobile-nav-link.active {
    @apply text-white bg-purple-500/20 border-l-2 border-purple-400;
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

/* Gradient text - Purple theme */
.gradient-text {
    @apply bg-gradient-to-r from-purple-400 to-pink-600 bg-clip-text text-transparent;
}

/* Music player controls styling */
.player-control {
    @apply p-2 text-gray-400 hover:text-purple-400 rounded-full hover:bg-purple-400/10 transition-all duration-200;
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
