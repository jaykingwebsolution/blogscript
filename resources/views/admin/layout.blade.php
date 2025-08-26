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
                    <a href="{{ route('admin.artists.create') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.artists.create') ? 'active' : 'text-spotify-light-gray' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Add Artist
                    </a>
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