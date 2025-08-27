<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || localStorage.getItem('darkMode') === null }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BlogScript Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        spotify: {
                            green: '#1db954',
                            'green-light': '#1ed760',
                            'green-dark': '#1aa34a',
                            black: '#191414',
                            'dark-gray': '#121212',
                            gray: '#282828',
                            'light-gray': '#b3b3b3'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-item {
            transition: all 0.2s ease-in-out;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        .nav-item.active {
            background: #1db954;
            color: #ffffff;
        }
        .nav-item.active svg {
            color: #ffffff;
        }
        
        /* Mobile responsive improvements */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .table-responsive {
                overflow-x: auto;
            }
            .mobile-hidden {
                display: none;
            }
        }
        
        /* Custom scrollbar for Spotify theme */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #121212;
        }
        ::-webkit-scrollbar-thumb {
            background: #1db954;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #1ed760;
        }
    </style>
</head>
<body class="bg-spotify-black text-white font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
        
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden">
        </div>

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="sidebar-transition fixed lg:relative lg:translate-x-0 inset-y-0 left-0 z-30 w-64 bg-spotify-black flex flex-col">
             
            <!-- Logo Section -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-spotify-gray">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-spotify-green rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">BlogScript</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-spotify-light-gray hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-spotify-light-gray' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 5l4-4 4 4"/>
                    </svg>
                    Dashboard
                </a>

                <!-- User Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">User Management</h3>
                    <a href="{{ route('admin.users.create') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.create') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create User
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.show') || request()->routeIs('admin.users.edit') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        Manage Users
                    </a>
                </div>

                <!-- Artist Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Artist Management</h3>
                    <a href="{{ route('admin.artists.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.artists.index') || request()->routeIs('admin.artists.edit') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Manage Artists
                    </a>
                </div>

                <!-- Music Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Music Management</h3>
                    <a href="{{ route('admin.music.create') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.music.create') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        Add Music
                    </a>
                    <a href="{{ route('admin.music.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.music.index') || request()->routeIs('admin.music.edit') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Manage Music
                    </a>
                    <a href="{{ route('admin.spotify-import.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.spotify-import.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.48.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                        </svg>
                        Import from Spotify
                    </a>
                    <a href="{{ route('admin.trending.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.trending.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Trending Posts
                    </a>
                </div>

                <!-- Media Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Media Management</h3>
                    <a href="{{ route('admin.media.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.media.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Media & Uploads
                    </a>
                </div>

                <!-- Distribution Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Distribution Management</h3>
                    <a href="{{ route('admin.distribution.dashboard') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.distribution.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        Distribution Dashboard
                    </a>
                </div>

                <!-- Playlists Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Playlists Management</h3>
                    <a href="{{ route('admin.playlists.create') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.playlists.create') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Playlist
                    </a>
                    <a href="{{ route('admin.playlists.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.playlists.index') || request()->routeIs('admin.playlists.show') || request()->routeIs('admin.playlists.edit') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        Manage Playlists
                    </a>
                </div>

                <!-- Record Labels Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Record Labels</h3>
                    <a href="{{ route('admin.record-labels.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.record-labels.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Manage Record Labels
                    </a>
                </div>

                <!-- Content Moderation Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Content Moderation</h3>
                    <a href="{{ route('admin.moderation.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.moderation.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Content Moderation
                    </a>
                </div>

                <!-- Communication Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Communication</h3>
                    <a href="{{ route('admin.notifications.create') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.notifications.create') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Send Notification
                    </a>
                    <a href="{{ route('admin.notifications.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.notifications.index') || request()->routeIs('admin.notifications.edit') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 3h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1z"/>
                        </svg>
                        Manage Notifications
                    </a>
                </div>

                <!-- Verification & Requests Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Requests Management</h3>
                    <a href="{{ route('admin.verification.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.verification.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Verification Requests
                    </a>
                </div>

                <!-- Financial Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Financial Management</h3>
                    <a href="{{ route('admin.plans.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.plans.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Subscription Plans
                    </a>
                    <a href="{{ route('admin.pricing.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.pricing.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                        General Pricing
                    </a>
                    <a href="{{ route('admin.subscriptions.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.subscriptions.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Manage Subscriptions
                    </a>
                    <a href="{{ route('admin.manual-payments.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.manual-payments.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Manual Payments
                    </a>
                    <a href="{{ route('admin.payment-settings.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.payment-settings.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Paystack Settings
                    </a>
                    <a href="{{ route('admin.api-keys.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.api-keys.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.586l4.707-4.707A1 1 0 0111 3h6a2 2 0 012 2v7z"/>
                        </svg>
                        API Keys & Integration
                    </a>
                </div>

                <!-- System Configuration Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">System Configuration</h3>
                    <a href="{{ route('admin.settings.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Site Settings (SEO + Logo)
                    </a>
                    <a href="{{ route('admin.pages.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.pages.*') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        DMCA / Policy Pages
                    </a>
                </div>

                <!-- Quick Actions Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-spotify-light-gray uppercase tracking-wider mb-2">Quick Actions</h3>
                    <a href="{{ route('home') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg text-spotify-light-gray" target="_blank">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Site
                    </a>
                </div>

                <!-- Logout Section -->
                <div class="pt-6 border-t border-spotify-gray mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg text-spotify-light-gray w-full">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0 flex flex-col overflow-hidden">
            <!-- Top Navigation Bar -->
            <header class="bg-spotify-gray shadow-lg border-b border-spotify-dark-gray">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = true" 
                                class="lg:hidden text-spotify-light-gray hover:text-white focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="text-2xl font-bold text-white">@yield('header', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Dark/Light Mode Toggle -->
                        <button @click="darkMode = !darkMode" 
                                class="p-2 rounded-lg bg-spotify-gray hover:bg-spotify-dark-gray border border-spotify-gray hover:border-spotify-light-gray transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-spotify-green focus:ring-opacity-50"
                                :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                            <svg x-show="!darkMode" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                            <svg x-show="darkMode" class="w-5 h-5 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </button>
                        
                        @auth
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-spotify-light-gray">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="w-8 h-8 bg-spotify-green rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-6 bg-spotify-black overflow-y-auto">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="bg-spotify-green bg-opacity-20 border border-spotify-green text-spotify-green-light px-6 py-4 rounded-lg mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-900 bg-opacity-20 border border-red-500 text-red-400 px-6 py-4 rounded-lg mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>