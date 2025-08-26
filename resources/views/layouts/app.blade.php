<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MusicStream - Discover, Upload, Stream')</title>
    
    <!-- Fonts - using system fonts for now -->
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
    </style>
    
    <!-- Icons (basic replacements) -->
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}")
    
    <!-- Tailwind CSS (compiled locally) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Alpine.js (local) -->
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>


    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.8);
        }
        .dark ::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99, 0.5);
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(75, 85, 99, 0.8);
        }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-gray-50 dark:bg-spotify-black font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        @include('components.spotify-sidebar')
        
        <main class="flex-1 flex flex-col min-h-screen max-w-full overflow-hidden">
            <!-- Top Header Navbar -->
            <header class="flex-shrink-0 bg-spotify-black/90 dark:bg-spotify-black/90 backdrop-blur-sm border-b border-gray-800 lg:pl-0 pl-16">
                <div class="flex items-center justify-between px-4 py-3">
                    <!-- Left section - Back/Forward buttons (desktop only) -->
                    <div class="flex items-center space-x-2">
                        <div class="hidden lg:flex items-center space-x-2">
                            <button class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Search bar (hidden on mobile) -->
                        @auth
                        <form method="GET" action="{{ route('search') }}" class="hidden md:flex items-center ml-4">
                            <div class="relative">
                                <input type="text" 
                                       name="q" 
                                       placeholder="What do you want to listen to?" 
                                       class="w-80 px-4 py-2 pl-10 pr-4 text-sm bg-white/10 text-white placeholder-white/70 border border-white/20 rounded-full focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </form>
                        @endauth
                    </div>

                    <!-- Right section - User actions -->
                    <div class="flex items-center space-x-3">
                        <!-- Dark mode toggle -->
                        <button onclick="toggleDarkMode()" class="w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                            <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        @auth
                        <!-- Notification Bell -->
                        <div class="relative" x-data="{ 
                            notificationOpen: false, 
                            unreadCount: 0,
                            notifications: [],
                            async fetchNotifications() {
                                try {
                                    const response = await fetch('/notifications/unread-count');
                                    const data = await response.json();
                                    this.unreadCount = data.count;
                                    
                                    // Fetch latest notifications for dropdown
                                    const notifResponse = await fetch('/notifications', {
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    });
                                    const notifData = await notifResponse.json();
                                    this.notifications = notifData.notifications || [];
                                    
                                    // Update notification list in dropdown
                                    this.updateNotificationList();
                                } catch (error) {
                                    console.error('Error fetching notifications:', error);
                                }
                            },
                            updateNotificationList() {
                                const notificationList = document.getElementById('notification-list');
                                if (this.notifications.length === 0) {
                                    notificationList.innerHTML = '<div class=\\x22p-4 text-center text-gray-400\\x22>No new notifications</div>';
                                } else {
                                    notificationList.innerHTML = this.notifications.map(notification => {
                                        const safeTitle = (notification.title || '').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\\x22/g, '&quot;');
                                        const safeMessage = (notification.message || '').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\\x22/g, '&quot;');
                                        const safeUrl = (notification.action_url || '').replace(/\\x22/g, '&quot;');
                                        return `<div class=\\x22px-4 py-3 hover:bg-gray-700 cursor-pointer border-b border-gray-600 last:border-b-0\\x22 onclick=\\x22markNotificationAsRead(${notification.id}, '${safeUrl}')\\x22>
                                            <div class=\\x22flex items-start space-x-3\\x22>
                                                <div class=\\x22flex-shrink-0\\x22>
                                                    <div class=\\x22w-8 h-8 rounded-full bg-spotify-green/20 flex items-center justify-center\\x22>
                                                        <svg class=\\x22w-4 h-4 text-spotify-green\\x22 fill=\\x22none\\x22 stroke=\\x22currentColor\\x22 viewBox=\\x220 0 24 24\\x22>
                                                            <path stroke-linecap=\\x22round\\x22 stroke-linejoin=\\x22round\\x22 stroke-width=\\x222\\x22 d=\\x22M15 17h5l-3-3v-4c0-5.523-4.477-10-10-10S2 4.477 2 10v4l-3 3h5m9 0a3 3 0 11-6 0m6 0H9\\x22/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class=\\x22flex-1 min-w-0\\x22>
                                                    <p class=\\x22text-sm font-medium text-white\\x22>${safeTitle}</p>
                                                    <p class=\\x22text-sm text-gray-400 mt-1\\x22>${safeMessage}</p>
                                                    <p class=\\x22text-xs text-gray-500 mt-2\\x22>${notification.created_at || ''}</p>
                                                </div>
                                            </div>
                                        </div>`;
                                    }).join('');
                                }
                            },
                            async markAsRead(notificationId) {
                                try {
                                    await fetch('/notifications/mark-as-read', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                        },
                                        body: JSON.stringify({ notification_id: notificationId })
                                    });
                                    await this.fetchNotifications();
                                } catch (error) {
                                    console.error('Error marking notification as read:', error);
                                }
                            }
                        }" x-init="fetchNotifications(); setInterval(fetchNotifications, 30000)">
                            <button @click="notificationOpen = !notificationOpen; if(notificationOpen) fetchNotifications()" 
                                    class="relative w-8 h-8 bg-black/40 hover:bg-black/60 rounded-full flex items-center justify-center text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-3-3v-4c0-5.523-4.477-10-10-10S2 4.477 2 10v4l-3 3h5m9 0a3 3 0 11-6 0m6 0H9"/>
                                </svg>
                                <!-- Notification Badge -->
                                <span x-show="unreadCount > 0" 
                                      x-text="unreadCount > 99 ? '99+' : unreadCount"
                                      class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center min-w-[20px] text-[10px] font-medium">
                                </span>
                            </button>

                            <!-- Notification Dropdown -->
                            <div x-show="notificationOpen" 
                                 @click.away="notificationOpen = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 top-full mt-2 w-96 bg-gray-800 rounded-lg shadow-lg ring-1 ring-white/10 z-50 max-h-80 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-700">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-white">Notifications</h3>
                                        <button @click="fetch('/notifications/mark-all-as-read', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content}}).then(() => fetchNotifications())" 
                                                class="text-xs text-gray-400 hover:text-white">Mark all read</button>
                                    </div>
                                </div>
                                <div class="max-h-64 overflow-y-auto" id="notification-list">
                                    <!-- Notifications will be loaded here via AJAX -->
                                    <div class="p-4 text-center text-gray-400">
                                        Loading notifications...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile Icon and Dropdown -->
                        <div class="relative" x-data="{ profileOpen: false }">
                            <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 hover:bg-white/10 rounded-full p-1 transition-colors">
                                @php
                                    $defaultAvatars = [
                                        'artist' => asset('images/default-music.svg'),
                                        'record_label' => asset('images/default-artist.svg'),
                                        'listener' => asset('images/default-artist.svg'),
                                        'admin' => asset('images/default.svg'),
                                    ];
                                    $avatarUrl = auth()->user()->profile_picture 
                                        ? asset('storage/' . auth()->user()->profile_picture)
                                        : ($defaultAvatars[auth()->user()->role] ?? $defaultAvatars['listener']);
                                @endphp
                                <img src="{{ $avatarUrl }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-8 h-8 rounded-full ring-2 ring-white/20">
                                <span class="hidden sm:block text-sm text-white font-medium">{{ Str::limit(auth()->user()->name, 12) }}</span>
                                <svg class="w-4 h-4 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Profile Dropdown -->
                            <div x-show="profileOpen" @click.away="profileOpen = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 top-full mt-2 w-48 bg-gray-800 rounded-lg shadow-lg ring-1 ring-white/10 z-50">
                                <div class="py-1">
                                    <a href="{{ route('dashboard.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        View Profile
                                    </a>
                                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                        </svg>
                                        Dashboard
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Admin Panel  
                                        </a>
                                    @endif
                                    <div class="border-t border-gray-600 my-1"></div>
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
                        <!-- Login/Register for guests -->
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm bg-spotify-green text-white rounded-full font-semibold hover:bg-green-600 transition-colors">
                                Log In
                            </a>
                            <a href="{{ route('register') }}" class="hidden sm:block px-4 py-2 text-sm border border-gray-600 text-gray-300 rounded-full font-semibold hover:bg-gray-700 transition-colors">
                                Sign Up
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area with proper scrolling -->
            <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Global Music Player -->
    @include('components.music-player')
    
    <script>
        // Initialize dark mode
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu) menu.classList.toggle('hidden');
        }
        
        // Dark mode toggle function
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
        
        // Mark notification as read
        async function markNotificationAsRead(notificationId, actionUrl = '') {
            try {
                await fetch('/notifications/mark-as-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify({ notification_id: notificationId })
                });
                
                // If there's an action URL, redirect to it
                if (actionUrl && actionUrl.trim() !== '') {
                    window.open(actionUrl, '_blank');
                }
                
                // Refresh notification count
                if (typeof window.fetchNotifications === 'function') {
                    window.fetchNotifications();
                }
            } catch (error) {
                console.error('Failed to mark notification as read:', error);
            }
        }
    </script>

    @stack('scripts')
</body>
</html>