@extends('layouts.app')

@section('title', '403 - Access Forbidden')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col justify-center py-12 px-4">
    <div class="max-w-md mx-auto text-center">
        <div class="mb-8">
            <div class="text-9xl font-bold text-amber-500/20 dark:text-amber-400/10">403</div>
            <div class="relative -mt-8">
                <svg class="w-24 h-24 mx-auto text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Access Denied
        </h1>
        
        <p class="text-gray-600 dark:text-gray-300 mb-8">
            You don't have permission to access this area. 
            This content might be exclusive to certain users.
        </p>
        
        <div class="space-y-4">
            @guest
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Sign In
                </a>
            @else
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 5l4-4 4 4"/>
                    </svg>
                    Back to Home
                </a>
            @endguest
            
            <div class="mt-4">
                <a href="javascript:history.back()" 
                   class="text-primary hover:text-primary/80 font-medium">
                    ← Go Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection