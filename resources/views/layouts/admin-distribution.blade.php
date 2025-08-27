<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: true, sidebarOpen: false }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Distribution Admin | MusicStream')</title>
    
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
                        },
                        'distro-admin': {
                            'bg': '#0A0E27',
                            'sidebar': '#0F1629', 
                            'card': '#141B2D',
                            'border': '#1E293B',
                            'text': '#F1F5F9',
                            'accent': '#6366F1'
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
            background: rgba(99, 102, 241, 0.1);
            transform: translateX(4px);
        }
        .nav-item.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.1) 100%);
            border-right: 3px solid #6366F1;
            color: #6366F1;
        }
        .nav-item.active svg {
            color: #6366F1;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0F1629;
        }
        ::-webkit-scrollbar-thumb {
            background: #1E293B;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-distro-admin-bg text-distro-admin-text font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar-transition bg-distro-admin-sidebar border-r border-distro-admin-border" 
               :class="sidebarOpen ? 'w-64' : 'w-64 lg:w-64 -translate-x-full lg:translate-x-0'">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 px-6 border-b border-distro-admin-border">
                    <div class="flex items-center">
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-white">Distribution</h1>
                            <p class="text-xs text-gray-400">Admin Panel</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.distribution.dashboard') }}" 
                       class="nav-item {{ request()->routeIs('admin.distribution.dashboard') ? 'active' : 'text-gray-300' }} flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Submissions -->
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-2">Submissions</h3>
                        <a href="{{ route('admin.distribution.requests.index') }}" 
                           class="nav-item {{ request()->routeIs('admin.distribution.requests.*') ? 'active' : 'text-gray-300' }} flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            All Requests
                        </a>
                        
                        <a href="{{ route('admin.distribution.requests.index', ['status' => 'pending']) }}" 
                           class="nav-item text-gray-300 flex items-center px-4 py-2 text-sm rounded-lg ml-4">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pending
                        </a>
                        
                        <a href="{{ route('admin.distribution.requests.index', ['status' => 'approved']) }}" 
                           class="nav-item text-gray-300 flex items-center px-4 py-2 text-sm rounded-lg ml-4">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approved
                        </a>
                    </div>

                    <!-- Content Management -->
                    <div class="pt-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-2">Content</h3>
                        <a href="{{ route('admin.distribution.pricing.index') }}" 
                           class="nav-item {{ request()->routeIs('admin.distribution.pricing.*') ? 'active' : 'text-gray-300' }} flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            Pricing Plans
                        </a>
                        
                        <a href="{{ route('admin.distribution.content.about') }}" 
                           class="nav-item {{ request()->routeIs('admin.distribution.content.about') ? 'active' : 'text-gray-300' }} flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            About Us Content
                        </a>
                        
                        <a href="{{ route('admin.distribution.content.contact') }}" 
                           class="nav-item {{ request()->routeIs('admin.distribution.content.contact') ? 'active' : 'text-gray-300' }} flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact Settings
                        </a>
                    </div>

                    <!-- Analytics -->
                    <div class="pt-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-4 py-2">Analytics</h3>
                        <a href="{{ route('admin.distribution.analytics') }}" 
                           class="nav-item {{ request()->routeIs('admin.distribution.analytics') ? 'active' : 'text-gray-300' }} flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Reports
                        </a>
                    </div>
                </nav>
                
                <!-- Bottom Actions -->
                <div class="px-4 py-6 border-t border-distro-admin-border">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center justify-center space-x-2 w-full bg-distro-admin-accent hover:bg-indigo-600 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Back to Main Admin</span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition.opacity 
             class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" 
             @click="sidebarOpen = false"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-distro-admin-card border-b border-distro-admin-border">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="text-gray-400 hover:text-white lg:hidden mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        
                        <h1 class="text-xl font-semibold text-white">@yield('header-title', 'Distribution Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode" 
                                class="p-2 rounded-lg bg-distro-admin-sidebar hover:bg-distro-admin-border border border-distro-admin-border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:ring-opacity-50"
                                :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                            <svg x-show="!darkMode" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L13.09 8.26L20 9L14 14.74L15.18 21.02L10 17.77L4.82 21.02L6 14.74L0 9L6.91 8.26L10 2Z"/>
                            </svg>
                            <svg x-show="darkMode" class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                            </svg>
                        </button>
                        
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-3 p-2 rounded-lg bg-distro-admin-sidebar hover:bg-distro-admin-border border border-distro-admin-border transition-colors">
                                <div class="w-8 h-8 bg-distro-admin-accent rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="text-white font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-48 bg-distro-admin-card rounded-lg shadow-lg border border-distro-admin-border z-50">
                                <div class="py-2">
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-distro-admin-border transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        Main Admin
                                    </a>
                                    <hr class="border-distro-admin-border my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center w-full text-left px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-distro-admin-border transition-colors">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-distro-admin-bg">
                <div class="p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>