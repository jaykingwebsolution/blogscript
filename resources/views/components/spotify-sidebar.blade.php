<!-- Spotify-style Sidebar -->
<aside class="hidden lg:flex lg:flex-col lg:w-64 bg-spotify-black border-r border-gray-800 overflow-y-auto">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center space-x-3 p-6">
            <div class="w-8 h-8 bg-spotify-green rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white">MusicStream</h1>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-4.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                </svg>
                <span class="font-medium">Home</span>
            </a>

            <a href="{{ route('search') }}" class="sidebar-link {{ request()->routeIs('search') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Search</span>
            </a>

            @auth
                <a href="{{ route('dashboard.library') }}" class="sidebar-link {{ request()->routeIs('dashboard.library') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    <span>Your Library</span>
                </a>
            @else
                <a href="{{ route('music.index') }}" class="sidebar-link {{ request()->routeIs('music.index') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    <span>Browse Music</span>
                </a>
            @endauth

            <div class="pt-4">
                @auth
                    @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                        <a href="{{ route('playlists.create') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white w-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span>Create Playlist</span>
                        </a>
                    @else
                        <button class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white w-full transition-colors" onclick="alert('Please upgrade to Premium to create playlists')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span>Create Playlist</span>
                        </button>
                    @endif
                    
                    <a href="{{ route('dashboard.liked-songs') }}" class="sidebar-link {{ request()->routeIs('dashboard.liked-songs') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        <span>Liked Songs</span>
                    </a>
                @else
                    <div class="space-y-2">
                        <button class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white w-full transition-colors" onclick="alert('Please log in to create playlists')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span>Create Playlist</span>
                        </button>
                        
                        <button class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors" onclick="alert('Please log in to see liked songs')">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                            <span>Liked Songs</span>
                        </button>
                    </div>
                @endauth
            </div>

            <hr class="border-gray-600 my-4">

            <!-- Recently Played Playlists -->
            <div class="space-y-1">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3">Recently Played</div>
                @auth
                    @php
                        $recentPlaylists = auth()->user()->playlists()->take(3)->get();
                    @endphp
                    @forelse($recentPlaylists as $playlist)
                        <a href="{{ route('playlists.show', $playlist->id) }}" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-400 hover:text-white text-sm transition-colors">
                            <img src="{{ $playlist->cover_image ? asset('storage/' . $playlist->cover_image) : 'https://via.placeholder.com/40x40/1db954/FFFFFF?text=P' }}" alt="Playlist" class="w-6 h-6 rounded">
                            <span class="truncate">{{ $playlist->name }}</span>
                        </a>
                    @empty
                        @for($i = 1; $i <= 3; $i++)
                        <div class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-500 text-sm">
                            <img src="https://via.placeholder.com/40x40/1db954/FFFFFF?text=P{{ $i }}" alt="Playlist" class="w-6 h-6 rounded opacity-50">
                            <span class="truncate">Create your first playlist</span>
                        </div>
                        @endfor
                    @endforelse
                @else
                    @for($i = 1; $i <= 3; $i++)
                    <div class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-500 text-sm">
                        <img src="https://via.placeholder.com/40x40/1db954/FFFFFF?text=P{{ $i }}" alt="Playlist" class="w-6 h-6 rounded opacity-50">
                        <span class="truncate">Log in to see playlists</span>
                    </div>
                    @endfor
                @endauth
            </div>
        </nav>

        <!-- User Profile -->
        <div class="p-4 border-t border-gray-800">
            @auth
            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-3 w-full text-left hover:bg-gray-700 p-2 rounded-lg transition-colors">
                    <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://via.placeholder.com/32x32/3b82f6/FFFFFF?text=' . substr(auth()->user()->name, 0, 1) }}" alt="Profile" class="w-8 h-8 rounded-full">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    @if(auth()->user()->isVerified())
                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition class="absolute bottom-full left-0 right-0 mb-2 bg-gray-800 rounded-lg shadow-lg ring-1 ring-white/10 z-50">
                    <div class="py-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('dashboard.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile
                        </a>
                        @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                            <a href="{{ route('artist.music.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                                My Music
                            </a>
                            <a href="{{ route('distribution.create') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Submit Distribution
                            </a>
                            <a href="{{ route('distribution.my-submissions') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                My Submissions
                            </a>
                        @endif
                        <a href="{{ route('dashboard.subscription') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Subscription
                        </a>
                        @if(auth()->user()->isAdmin())
                            <div class="border-t border-gray-600"></div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Admin Panel
                            </a>
                        @endif
                        <div class="border-t border-gray-600"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <div class="space-y-2">
                <a href="{{ route('login') }}" class="block w-full text-center py-2 px-4 bg-spotify-green text-white rounded-full font-semibold hover:bg-green-600 transition-colors">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center py-2 px-4 border border-gray-600 text-gray-300 rounded-full font-semibold hover:bg-gray-700 transition-colors">
                    Sign Up
                </a>
            </div>
            @endauth
        </div>
    </div>
</aside>

<!-- Mobile Sidebar -->
<div x-data="{ sidebarOpen: false }">
    <div x-show="sidebarOpen" x-transition.opacity class="lg:hidden fixed inset-0 bg-black/50 z-40" @click="sidebarOpen = false"></div>
    <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="lg:hidden fixed left-0 top-0 h-full w-64 bg-spotify-black z-50 overflow-y-auto">
        <!-- Mobile sidebar content (same as desktop but with close button) -->
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-spotify-green rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-white">MusicStream</h1>
                </div>
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Same navigation content as desktop sidebar -->
            <nav class="flex-1 px-4 space-y-2 py-4">
                <!-- Copy all navigation items from desktop version -->
                <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-4.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                    </svg>
                    <span class="font-medium">Home</span>
                </a>

                <a href="{{ route('search') }}" class="sidebar-link {{ request()->routeIs('search') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Search</span>
                </a>
                
                <!-- Add other mobile navigation items -->
            </nav>
        </div>
    </aside>
    
    <!-- Mobile menu button -->
    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden fixed top-4 left-4 z-30 w-10 h-10 bg-black/50 hover:bg-black/70 rounded-full flex items-center justify-center text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>

<style>
.sidebar-link.active {
    background: rgba(29, 185, 84, 0.1);
    border-left: 4px solid #1db954;
    color: #1db954;
}

.sidebar-link:hover {
    background: rgba(29, 185, 84, 0.1);
}

.sidebar-link {
    transition: all 0.3s ease;
}
</style>