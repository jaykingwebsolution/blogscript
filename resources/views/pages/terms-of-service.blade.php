@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Terms of Service</h1>
                <p class="text-gray-600 dark:text-gray-400">Please read these terms carefully before using our service</p>
            </div>

            <div class="prose prose-lg dark:prose-invert max-w-none">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>
@endsection