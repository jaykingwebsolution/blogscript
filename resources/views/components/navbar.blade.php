<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <a href="#" class="text-2xl font-bold text-primary">BlogScript</a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-900 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                    <a href="{{ route('music.index') }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Music</a>
                    <a href="{{ route('music.index', ['category' => 'albums']) }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Albums</a>
                    <a href="{{ route('music.index', ['category' => 'mixtapes']) }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Mixtapes</a>
                    <a href="{{ route('music.index', ['genre' => 'gospel']) }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Gospel</a>
                    <a href="{{ route('artists.index') }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Artists</a>
                    <a href="{{ route('videos.index') }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Videos</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Gist</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">News</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Contact</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                    
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-accent hover:text-yellow-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Logout</button>
                        </form>
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