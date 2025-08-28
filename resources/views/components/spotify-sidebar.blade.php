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

            <a href="{{ route('playlists.index') }}" class="sidebar-link {{ request()->routeIs('playlists.index') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span>Browse Playlists</span>
            </a>

            @auth
                <a href="{{ route('dashboard.library') }}" class="sidebar-link {{ request()->routeIs('dashboard.library') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    <span>Your Library</span>
                </a>

                <!-- User account navigation -->
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('dashboard.profile') }}" class="sidebar-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Profile</span>
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
                    <a href="{{ route('playlists.create') }}" class="sidebar-link {{ request()->routeIs('playlists.create') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white w-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Create Playlist</span>
                    </a>
                    
                    <a href="{{ route('playlists.my-playlists') }}" class="sidebar-link {{ request()->routeIs('playlists.my-playlists') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        <span>My Playlists</span>
                    </a>
                    
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
                        
                        <button class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors" onclick="alert('Please log in to see playlists')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                            <span>My Playlists</span>
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
                        <a href="{{ route('playlists.show', $playlist) }}" class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-400 hover:text-white text-sm transition-colors">
                            <img src="{{ $playlist->cover_image ? asset('storage/' . $playlist->cover_image) : asset('images/default-playlist.svg') }}" alt="Playlist" class="w-6 h-6 rounded">
                            <span class="truncate">{{ $playlist->title }}</span>
                        </a>
                    @empty
                        @for($i = 1; $i <= 3; $i++)
                        <div class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-500 text-sm">
                            <img src="{{ asset('images/default-playlist.svg') }}" alt="Playlist" class="w-6 h-6 rounded opacity-50">
                            <span class="truncate">Create your first playlist</span>
                        </div>
                        @endfor
                    @endforelse
                @else
                    @for($i = 1; $i <= 3; $i++)
                    <div class="sidebar-link flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-500 text-sm">
                        <img src="{{ asset('images/default-playlist.svg') }}" alt="Playlist" class="w-6 h-6 rounded opacity-50">
                        <span class="truncate">Log in to see playlists</span>
                    </div>
                    @endfor
                @endauth
            </div>
        </nav>

        <!-- Spotify-style Footer -->
        <div class="p-4 border-t border-gray-800">
            {{-- $publicPages should be passed to this view from the controller or a view composer --}}
            
            <!-- User actions (auth-specific) -->
            @auth
                <div class="mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('images/default-artist.svg') }}" alt="Profile" class="w-6 h-6 rounded-full">
                            <span class="text-xs text-white truncate">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->isVerified())
                                <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-gray-400 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="space-y-2 mb-4">
                    <a href="{{ route('login') }}" class="block w-full text-center py-1.5 px-3 bg-spotify-green text-white rounded-full text-xs font-semibold hover:bg-green-600 transition-colors">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-1.5 px-3 border border-gray-600 text-gray-300 rounded-full text-xs font-semibold hover:bg-gray-700 transition-colors">
                        Sign Up
                    </a>
                </div>
            @endauth
            
            <!-- Dynamic Pages Links -->
            <div class="space-y-1 mb-4">
                @foreach($publicPages as $page)
                    <a href="{{ $page['url'] }}" class="block text-xs text-gray-400 hover:text-white transition-colors py-1">
                        {{ $page['title'] }}
                    </a>
                @endforeach
            </div>

            <!-- Copyright/Brand -->
            <div class="text-xs text-gray-500 pt-2 border-t border-gray-800">
                <p>&copy; {{ date('Y') }} MusicStream</p>
                <p class="mt-1">Your ultimate music platform</p>
            </div>
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

                <a href="{{ route('playlists.index') }}" class="sidebar-link {{ request()->routeIs('playlists.index') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Browse Playlists</span>
                </a>

                @auth
                    <a href="{{ route('dashboard.library') }}" class="sidebar-link {{ request()->routeIs('dashboard.library') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        <span>Your Library</span>
                    </a>

                    <!-- User account navigation -->
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard*') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('dashboard.profile') }}" class="sidebar-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Profile</span>
                    </a>
                @else
                    <a href="{{ route('music.index') }}" class="sidebar-link {{ request()->routeIs('music.index') ? 'active' : '' }} flex items-center space-x-3 px-3 py-2 rounded-lg text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        <span>Browse Music</span>
                    </a>
                @endauth
            </nav>

            <!-- Mobile Footer (same as desktop) -->
            <div class="p-4 border-t border-gray-800 mt-auto">
                @php
                    $publicPages = \App\Http\Controllers\Admin\PageController::getPublicPages();
                @endphp
                
                <!-- User actions (auth-specific) -->
                @auth
                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('images/default-artist.svg') }}" alt="Profile" class="w-6 h-6 rounded-full">
                                <span class="text-xs text-white truncate">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->isVerified())
                                    <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-gray-400 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="space-y-2 mb-4">
                        <a href="{{ route('login') }}" class="block w-full text-center py-1.5 px-3 bg-spotify-green text-white rounded-full text-xs font-semibold hover:bg-green-600 transition-colors">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="block w-full text-center py-1.5 px-3 border border-gray-600 text-gray-300 rounded-full text-xs font-semibold hover:bg-gray-700 transition-colors">
                            Sign Up
                        </a>
                    </div>
                @endauth
                
                <!-- Dynamic Pages Links -->
                <div class="space-y-1 mb-4">
                    @foreach($publicPages as $page)
                        <a href="{{ $page['url'] }}" class="block text-xs text-gray-400 hover:text-white transition-colors py-1">
                            {{ $page['title'] }}
                        </a>
                    @endforeach
                </div>

                <!-- Copyright/Brand -->
                <div class="text-xs text-gray-500 pt-2 border-t border-gray-800">
                    <p>&copy; {{ date('Y') }} MusicStream</p>
                    <p class="mt-1">Your ultimate music platform</p>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Mobile menu button -->
    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden fixed top-4 left-4 z-40 w-10 h-10 bg-black/80 hover:bg-black/90 rounded-full flex items-center justify-center text-white backdrop-blur-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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