@extends('admin.layout')

@section('title', 'Manage Pages')
@section('header', 'DMCA / Policy Pages')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-white mb-2">Page Management</h2>
            <p class="text-spotify-light-gray">Manage static pages, policies, and content</p>
        </div>
    </div>

    <!-- Pages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($pages as $page)
        <div class="bg-spotify-gray rounded-lg border border-spotify-dark-gray hover:border-spotify-green transition-all duration-200 p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-spotify-green bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-spotify-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $page['title'] }}</h3>
                        <p class="text-sm text-spotify-light-gray">{{ $page['slug'] }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-spotify-green bg-opacity-20 text-spotify-green-light">
                    {{ ucfirst($page['status']) }}
                </span>
            </div>

            <div class="space-y-3">
                <div class="flex items-center text-sm text-spotify-light-gray">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Last updated: {{ $page['last_updated'] }}
                </div>

                <div class="flex space-x-2">
                    <a href="{{ route('admin.pages.edit', $page['id']) }}" 
                       class="flex-1 bg-spotify-green hover:bg-spotify-green-light text-white px-4 py-2 rounded-lg text-sm font-medium text-center transition-colors">
                        Edit Content
                    </a>
                    <a href="{{ url($page['slug']) }}" 
                       target="_blank"
                       class="flex-1 bg-spotify-gray border border-spotify-green text-spotify-green hover:bg-spotify-green hover:text-white px-4 py-2 rounded-lg text-sm font-medium text-center transition-all">
                        View Live
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Info Section -->
    <div class="bg-spotify-gray rounded-lg border border-spotify-dark-gray p-6">
        <div class="flex items-start space-x-4">
            <div class="w-12 h-12 bg-blue-500 bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-white mb-2">About Page Management</h3>
                <p class="text-spotify-light-gray mb-4">
                    These are your site's static pages that provide important information to users about your platform, policies, and legal compliance.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-spotify-light-gray">
                    <div>
                        <strong class="text-white">About Us:</strong> Platform introduction and mission
                    </div>
                    <div>
                        <strong class="text-white">Privacy Policy:</strong> Data collection and usage terms
                    </div>
                    <div>
                        <strong class="text-white">DMCA Policy:</strong> Copyright infringement procedures
                    </div>
                    <div>
                        <strong class="text-white">Terms of Service:</strong> User agreement and rules
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection