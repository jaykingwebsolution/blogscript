<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: true }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Music Distribution | MusicStream')</title>
    
    <!-- Fonts -->
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
    </style>
    
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    
    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'spotify-green': '#1db954',
                        'spotify-black': '#191414',
                        'distro-dark': '#0D1117',
                        'distro-gray': '#161B22',
                        'distro-border': '#21262D',
                        'distro-text': '#F0F6FC',
                        'distro-accent': '#58A6FF'
                    }
                }
            }
        }
    </script>

    <style>
        .distro-gradient {
            background: linear-gradient(135deg, #1db954 0%, #1ed760 100%);
        }
        .distro-sidebar-gradient {
            background: linear-gradient(180deg, #0D1117 0%, #161B22 100%);
        }
        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            background: rgba(88, 166, 255, 0.1);
            border-left: 3px solid #58A6FF;
            padding-left: 1.25rem;
        }
        .sidebar-link.active {
            background: rgba(29, 185, 84, 0.1);
            border-left: 3px solid #1db954;
            color: #1db954;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #161B22;
        }
        ::-webkit-scrollbar-thumb {
            background: #21262D;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #30363D;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-distro-dark text-distro-text font-sans antialiased overflow-x-hidden">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden lg:flex flex-col w-64 distro-sidebar-gradient border-r border-distro-border">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b border-distro-border">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-white flex items-center">
                    <div class="w-8 h-8 distro-gradient rounded mr-2 flex items-center justify-center">
                        <i class="fas fa-music text-white text-sm"></i>
                    </div>
                    Distribution
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('distribution.index') }}" 
                   class="sidebar-link {{ request()->routeIs('distribution.index') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-home w-5"></i>
                    <span>Home</span>
                </a>
                
                <a href="{{ route('distribution.pricing') }}" 
                   class="sidebar-link {{ request()->routeIs('distribution.pricing') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-dollar-sign w-5"></i>
                    <span>Pricing</span>
                </a>
                
                <a href="{{ route('distribution.about') }}" 
                   class="sidebar-link {{ request()->routeIs('distribution.about') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-info-circle w-5"></i>
                    <span>About</span>
                </a>
                
                <a href="{{ route('distribution.how-it-works') }}" 
                   class="sidebar-link {{ request()->routeIs('distribution.how-it-works') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-question-circle w-5"></i>
                    <span>How It Works</span>
                </a>
                
                <a href="{{ route('distribution.contact') }}" 
                   class="sidebar-link {{ request()->routeIs('distribution.contact') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-envelope w-5"></i>
                    <span>Contact</span>
                </a>
                
                @auth
                    @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                        <hr class="border-distro-border my-4">
                        
                        <a href="{{ route('distribution.create') }}" 
                           class="sidebar-link {{ request()->routeIs('distribution.create') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                            <i class="fas fa-upload w-5"></i>
                            <span>Upload Music</span>
                        </a>
                        
                        <a href="{{ route('distribution.my-submissions') }}" 
                           class="sidebar-link {{ request()->routeIs('distribution.my-submissions') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                            <i class="fas fa-list w-5"></i>
                            <span>My Submissions</span>
                        </a>
                        
                        <a href="{{ route('distribution.earnings') }}" 
                           class="sidebar-link {{ request()->routeIs('distribution.earnings') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                            <i class="fas fa-chart-line w-5"></i>
                            <span>Earnings</span>
                        </a>
                        
                        <a href="{{ route('distribution.payouts') }}" 
                           class="sidebar-link {{ request()->routeIs('distribution.payouts') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                            <i class="fas fa-money-bill-wave w-5"></i>
                            <span>Payouts</span>
                        </a>
                    @endif
                @endauth
            </nav>
            
            <!-- Bottom Actions -->
            <div class="px-4 py-6 border-t border-distro-border">
                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center justify-center space-x-2 w-full bg-distro-accent hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                        <i class="fas fa-arrow-left text-sm"></i>
                        <span>Back to Music Platform</span>
                    </a>
                @else
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" 
                           class="flex items-center justify-center w-full bg-spotify-green hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" 
                           class="flex items-center justify-center w-full border border-gray-600 text-gray-300 hover:bg-gray-800 py-2 px-4 rounded-lg font-medium transition-colors">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- Mobile Sidebar Toggle -->
        <div x-data="{ sidebarOpen: false }" class="lg:hidden">
            <!-- Mobile Header -->
            <div class="flex items-center justify-between h-16 px-4 bg-distro-gray border-b border-distro-border">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-300 hover:text-white mr-4">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white flex items-center">
                        <div class="w-6 h-6 distro-gradient rounded mr-2 flex items-center justify-center">
                            <i class="fas fa-music text-white text-xs"></i>
                        </div>
                        Distribution
                    </a>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-distro-accent hover:text-blue-400 text-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                @endauth
            </div>

            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-40" @click="sidebarOpen = false"></div>
            
            <!-- Mobile Sidebar -->
            <aside x-show="sidebarOpen" 
                   x-transition:enter="transition ease-out duration-300" 
                   x-transition:enter-start="-translate-x-full" 
                   x-transition:enter-end="translate-x-0" 
                   x-transition:leave="transition ease-in duration-200" 
                   x-transition:leave-start="translate-x-0" 
                   x-transition:leave-end="-translate-x-full" 
                   class="fixed left-0 top-0 h-full w-64 distro-sidebar-gradient z-50 overflow-y-auto">
                <!-- Same navigation content as desktop -->
                <div class="flex items-center justify-between h-16 px-4 border-b border-distro-border">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white flex items-center">
                        <div class="w-6 h-6 distro-gradient rounded mr-2 flex items-center justify-center">
                            <i class="fas fa-music text-white text-xs"></i>
                        </div>
                        Distribution
                    </a>
                    <button @click="sidebarOpen = false" class="text-gray-300 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <!-- Same navigation items as desktop version -->
                    <a href="{{ route('distribution.index') }}" 
                       class="sidebar-link {{ request()->routeIs('distribution.index') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        <i class="fas fa-home w-5"></i>
                        <span>Home</span>
                    </a>
                    
                    <a href="{{ route('distribution.pricing') }}" 
                       class="sidebar-link {{ request()->routeIs('distribution.pricing') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        <i class="fas fa-dollar-sign w-5"></i>
                        <span>Pricing</span>
                    </a>
                    
                    <a href="{{ route('distribution.about') }}" 
                       class="sidebar-link {{ request()->routeIs('distribution.about') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        <i class="fas fa-info-circle w-5"></i>
                        <span>About</span>
                    </a>
                    
                    <a href="{{ route('distribution.how-it-works') }}" 
                       class="sidebar-link {{ request()->routeIs('distribution.how-it-works') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        <i class="fas fa-question-circle w-5"></i>
                        <span>How It Works</span>
                    </a>
                    
                    <a href="{{ route('distribution.contact') }}" 
                       class="sidebar-link {{ request()->routeIs('distribution.contact') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        <i class="fas fa-envelope w-5"></i>
                        <span>Contact</span>
                    </a>
                    
                    @auth
                        @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                            <hr class="border-distro-border my-4">
                            
                            <a href="{{ route('distribution.create') }}" 
                               class="sidebar-link {{ request()->routeIs('distribution.create') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                                <i class="fas fa-upload w-5"></i>
                                <span>Upload Music</span>
                            </a>
                            
                            <a href="{{ route('distribution.my-submissions') }}" 
                               class="sidebar-link {{ request()->routeIs('distribution.my-submissions') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                                <i class="fas fa-list w-5"></i>
                                <span>My Submissions</span>
                            </a>
                            
                            <a href="{{ route('distribution.earnings') }}" 
                               class="sidebar-link {{ request()->routeIs('distribution.earnings') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                                <i class="fas fa-chart-line w-5"></i>
                                <span>Earnings</span>
                            </a>
                            
                            <a href="{{ route('distribution.payouts') }}" 
                               class="sidebar-link {{ request()->routeIs('distribution.payouts') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white transition-colors">
                                <i class="fas fa-money-bill-wave w-5"></i>
                                <span>Payouts</span>
                            </a>
                        @endif
                    @endauth
                </nav>
                
                <div class="px-4 py-6 border-t border-distro-border">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center justify-center space-x-2 w-full bg-distro-accent hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span>Back to Music Platform</span>
                        </a>
                    @else
                        <div class="space-y-2">
                            <a href="{{ route('login') }}" 
                               class="flex items-center justify-center w-full bg-spotify-green hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" 
                               class="flex items-center justify-center w-full border border-gray-600 text-gray-300 hover:bg-gray-800 py-2 px-4 rounded-lg font-medium transition-colors">
                                Sign Up
                            </a>
                        </div>
                    @endauth
                </div>
            </aside>
        </div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-distro-dark">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>