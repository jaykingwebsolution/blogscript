@extends('layouts.listener-dashboard')

@section('dashboard-content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Listening History</h1>
        <p class="text-gray-300">Track your music journey</p>
    </div>

    <!-- History Content -->
    @if($history->count() > 0)
        <!-- Coming Soon - This would show actual listening history -->
        <div class="space-y-4">
            @foreach($history as $item)
            <div class="flex items-center p-4 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors">
                <div class="w-12 h-12 bg-gray-600 rounded flex-shrink-0 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-white font-medium">{{ $item['title'] }}</h4>
                    <p class="text-gray-400 text-sm">{{ $item['artist'] }}</p>
                    <p class="text-gray-500 text-xs">{{ $item['played_at'] }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="text-gray-400 hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <button class="text-gray-400 hover:text-red-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="mb-8">
                <div class="bg-gray-800 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-gray-300 text-xl mb-2">No listening history yet</h3>
                <p class="text-gray-500 mb-6">Start playing some music to build your listening history</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
                <a href="{{ route('dashboard.listener.browse') }}" 
                   class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white p-6 rounded-xl transition-all transform hover:scale-105 flex items-center">
                    <div>
                        <svg class="w-8 h-8 mb-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                        </svg>
                        <h4 class="font-semibold text-lg">Browse Music</h4>
                        <p class="text-sm opacity-90 mt-1">Discover new tracks</p>
                    </div>
                </a>

                <a href="{{ route('dashboard.listener.trending') }}" 
                   class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white p-6 rounded-xl transition-all transform hover:scale-105 flex items-center">
                    <div>
                        <svg class="w-8 h-8 mb-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                        <h4 class="font-semibold text-lg">Trending Now</h4>
                        <p class="text-sm opacity-90 mt-1">Check what's popular</p>
                    </div>
                </a>
            </div>

            <!-- Feature Preview -->
            <div class="mt-12 bg-gray-800 rounded-xl p-8">
                <h4 class="text-white font-semibold text-lg mb-4">Coming Soon: Advanced Listening History</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                    <div class="text-center">
                        <div class="bg-green-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h5 class="text-white font-medium mb-2">Detailed Timeline</h5>
                        <p class="text-gray-400">See exactly when you played each track</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <h5 class="text-white font-medium mb-2">Smart Statistics</h5>
                        <p class="text-gray-400">Track your most played songs and artists</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h5 class="text-white font-medium mb-2">Recommendations</h5>
                        <p class="text-gray-400">Get suggestions based on your history</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection