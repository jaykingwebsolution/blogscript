@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col justify-center py-12 px-4">
    <div class="max-w-md mx-auto text-center">
        <div class="mb-8">
            <div class="text-9xl font-bold text-red-500/20 dark:text-red-400/10">500</div>
            <div class="relative -mt-8">
                <svg class="w-24 h-24 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Something Went Wrong
        </h1>
        
        <p class="text-gray-600 dark:text-gray-300 mb-8">
            Our servers hit a wrong note. We're working to get things back in harmony. 
            Please try again in a few minutes.
        </p>
        
        <div class="space-y-4">
            <button onclick="location.reload()" 
                    class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Try Again
            </button>
            
            <div class="mt-4">
                <a href="{{ route('home') }}" 
                   class="text-primary hover:text-primary/80 font-medium">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection