<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BlogScript Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF',
                        accent: '#F59E0B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 px-4 py-6">
            <div class="text-2xl font-bold mb-8">BlogScript Admin</div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.music.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.music.*') ? 'bg-gray-700' : '' }}">
                    Music
                </a>
                <a href="{{ route('admin.artists.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.artists.*') ? 'bg-gray-700' : '' }}">
                    Artists
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                    Users
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700' : '' }}">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Site Settings
                </a>
                <a href="{{ route('home') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    View Site
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-gray-700">
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-900">@yield('header', 'Dashboard')</h1>
                    <div class="text-sm text-gray-600">
                        Welcome, {{ Auth::user()->name }}
                    </div>
                </div>
            </header>

            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>