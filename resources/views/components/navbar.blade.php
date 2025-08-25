<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-purple-600">Music Platform</a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <div class="flex items-baseline space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-900 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                    <a href="{{ route('music.index') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Music</a>
                    <a href="{{ route('music.index', ['category' => 'albums']) }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Albums</a>
                    <a href="{{ route('music.index', ['genre' => 'gospel']) }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Gospel</a>
                    <a href="{{ route('artists.index') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Artists</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">News</a>
                    <a href="{{ route('posts.index', ['type' => 'gist']) }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Gist</a>
                    <a href="{{ route('videos.index') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Videos</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Contact</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                </div>

                <!-- Search -->
                <form method="GET" action="{{ route('search') }}" class="flex items-center">
                    <div class="relative">
                        <input type="text" 
                               name="q" 
                               placeholder="Search..." 
                               class="w-48 px-4 py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </form>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                <img class="h-8 w-8 rounded-full object-cover" 
                                     src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7C3AED&background=EDE9FE' }}" 
                                     alt="{{ auth()->user()->name }}">
                                <span class="ml-2 text-gray-700 font-medium">{{ auth()->user()->getDisplayName() }}</span>
                                @if(auth()->user()->isVerified())
                                    <svg class="w-4 h-4 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <svg class="ml-1 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                        </svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('dashboard.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profile
                                    </a>
                                    @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                                        <a href="{{ route('artist.music.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                            </svg>
                                            My Music
                                        </a>
                                    @endif
                                    <a href="{{ route('dashboard.subscription') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        Subscription
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <div class="border-t border-gray-100"></div>
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Admin Panel
                                        </a>
                                    @endif
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white hover:bg-secondary px-4 py-2 rounded-md text-sm font-medium transition-colors">Sign Up</a>
                    @endauth
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="text-gray-600 hover:text-primary focus:outline-none focus:text-primary">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden pb-3">
            <div class="space-y-1">
                <a href="{{ route('home') }}" class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="{{ route('music.index') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Music</a>
                <a href="{{ route('music.index', ['category' => 'albums']) }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Albums</a>
                <a href="{{ route('music.index', ['category' => 'mixtapes']) }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Mixtapes</a>
                <a href="{{ route('music.index', ['genre' => 'gospel']) }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Gospel</a>
                <a href="{{ route('artists.index') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Artists</a>
                <a href="{{ route('videos.index') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Videos</a>
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Gist</a>
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">News</a>
                <a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Contact</a>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="{{ route('privacy-policy') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Privacy Policy</a>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-accent hover:text-yellow-600 block px-3 py-2 rounded-md text-base font-medium">Admin Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="block px-3 py-2">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-primary text-left text-base font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary text-white hover:bg-secondary block px-3 py-2 rounded-md text-base font-medium text-center">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>