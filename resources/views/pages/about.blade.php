@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600/10 to-green-400/10 dark:from-green-900/20 dark:to-green-700/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">About {{ config('app.name', 'MusicStream') }}</h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">Learn more about our platform and mission.</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 md:p-12">
            <div class="prose prose-lg dark:prose-invert max-w-none">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>
@endsection