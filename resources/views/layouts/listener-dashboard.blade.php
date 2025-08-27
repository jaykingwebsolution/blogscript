@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black text-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-900 via-purple-900 to-gray-900 px-8 py-12">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-purple-400 to-pink-600 p-4 rounded-full">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v9.28c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 9 12.28V6.5l6-2v5.78c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.37 3.32 0 1.1.6 2.08 1.5 2.6.9.52 2.01.33 2.69-.45.68-.78.68-1.98 0-2.76A2.99 2.99 0 0 0 12 10.28V3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold">Welcome, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-300 text-xl">Listener Dashboard</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-8">
        @yield('dashboard-content')
    </div>
</div>
@endsection