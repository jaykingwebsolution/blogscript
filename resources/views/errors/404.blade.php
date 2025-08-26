@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col justify-center py-12 px-4">
    <div class="max-w-md mx-auto text-center">
        <div class="mb-8">
            <div class="text-9xl font-bold text-primary/20 dark:text-primary/10">404</div>
            <div class="relative -mt-8">
                <svg class="w-24 h-24 mx-auto text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-3-8v.01M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z"/>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Oops! Page Not Found
        </h1>
        
        <p class="text-gray-600 dark:text-gray-300 mb-8">
            The page you're looking for seems to have disappeared into the rhythm. 
            Don't worry, let's get you back on track!
        </p>
        
        <div class="space-y-4">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 5l4-4 4 4"/>
                </svg>
                Back to Home
            </a>
            
            <div class="flex items-center justify-center space-x-4">
                <a href="{{ route('music.index') }}" 
                   class="text-primary hover:text-primary/80 font-medium">
                    Browse Music
                </a>
                <span class="text-gray-300 dark:text-gray-600">•</span>
                <a href="{{ route('artists.index') }}" 
                   class="text-primary hover:text-primary/80 font-medium">
                    Discover Artists
                </a>
                <span class="text-gray-300 dark:text-gray-600">•</span>
                <a href="{{ route('videos.index') }}" 
                   class="text-primary hover:text-primary/80 font-medium">
                    Watch Videos
                </a>
            </div>
        </div>
    </div>
</div>
@endsection