@extends('admin.layout')

@section('title', 'Third-Party Services')

@section('header', 'Third-Party Services')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gray-500 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Third-Party Services</h1>
                    <p class="text-spotify-light-gray mt-1">Configure external service integrations and API credentials</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <a href="{{ route('admin.api-keys.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to API Keys
                </a>
            </div>
        </div>
    </div>

    <!-- TODO Notice -->
    <div class="bg-yellow-900 bg-opacity-20 border border-yellow-500 text-yellow-400 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                <p class="font-semibold">TODO: Implementation Required</p>
                <p class="text-sm">Third-party service management system needs to be implemented with secure credential storage and connection monitoring.</p>
            </div>
        </div>
    </div>

    <!-- Service Categories -->
    <div class="space-y-8">
        <!-- Email Services -->
        <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
            <div class="p-6 border-b border-spotify-light-gray">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-white">Email Services</h2>
                        <p class="text-spotify-light-gray text-sm">Configure email delivery providers</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- SendGrid -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-medium">SendGrid</h3>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-red-400 text-sm">Not configured</span>
                            </div>
                        </div>
                        <input type="text" placeholder="API Key" readonly
                               class="w-full bg-spotify-dark-gray border border-spotify-light-gray rounded px-3 py-2 text-white text-sm mb-3">
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors text-sm" disabled>
                            Configure SendGrid
                        </button>
                    </div>

                    <!-- Mailgun -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-medium">Mailgun</h3>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-yellow-400 text-sm">Configured</span>
                            </div>
                        </div>
                        <input type="text" placeholder="Domain" value="mail.example.com" readonly
                               class="w-full bg-spotify-dark-gray border border-spotify-light-gray rounded px-3 py-2 text-white text-sm mb-3">
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors text-sm" disabled>
                            Edit Configuration
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Storage Services -->
        <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
            <div class="p-6 border-b border-spotify-light-gray">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-white">Cloud Storage</h2>
                        <p class="text-spotify-light-gray text-sm">Configure file storage providers</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- AWS S3 -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-medium">AWS S3</h3>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-red-400 text-sm">Offline</span>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs text-spotify-light-gray mb-3">
                            <div>Bucket: music-uploads</div>
                            <div>Region: us-east-1</div>
                        </div>
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors text-sm" disabled>
                            Configure S3
                        </button>
                    </div>

                    <!-- Cloudinary -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-medium">Cloudinary</h3>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-spotify-green rounded-full mr-2"></div>
                                <span class="text-spotify-green text-sm">Connected</span>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs text-spotify-light-gray mb-3">
                            <div>Cloud: blogscript</div>
                            <div>Usage: 45% / 10GB</div>
                        </div>
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors text-sm" disabled>
                            Edit Configuration
                        </button>
                    </div>

                    <!-- Local Storage -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-medium">Local Storage</h3>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-spotify-green rounded-full mr-2"></div>
                                <span class="text-spotify-green text-sm">Active</span>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs text-spotify-light-gray mb-3">
                            <div>Path: /storage/app/public</div>
                            <div>Used: 2.3GB / 50GB</div>
                        </div>
                        <button class="w-full bg-gray-600 text-white py-2 rounded hover:bg-gray-700 transition-colors text-sm" disabled>
                            View Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics & Monitoring -->
        <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
            <div class="p-6 border-b border-spotify-light-gray">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-white">Analytics & Monitoring</h2>
                        <p class="text-spotify-light-gray text-sm">Configure tracking and monitoring services</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Google Analytics -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-medium">Google Analytics</h3>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-yellow-400 text-sm">Partial</span>
                            </div>
                        </div>
                        <input type="text" placeholder="Tracking ID (GA4)" value="G-XXXXXXXXXX" readonly
                               class="w-full bg-spotify-dark-gray border border-spotify-light-gray rounded px-3 py-2 text-white text-sm mb-3">
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors text-sm" disabled>
                            Configure Analytics
                        </button>
                    </div>

                    <!-- Application Monitoring -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-medium">Error Tracking</h3>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-red-400 text-sm">Not configured</span>
                            </div>
                        </div>
                        <select class="w-full bg-spotify-dark-gray border border-spotify-light-gray rounded px-3 py-2 text-white text-sm mb-3" disabled>
                            <option>Select Service</option>
                            <option>Sentry</option>
                            <option>Bugsnag</option>
                            <option>Rollbar</option>
                        </select>
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors text-sm" disabled>
                            Configure Tracking
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media APIs -->
        <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
            <div class="p-6 border-b border-spotify-light-gray">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2M7 4h10M7 4l-2 16h14l-2-16M11 9v8M13 9v8"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-white">Social Media Integration</h2>
                        <p class="text-spotify-light-gray text-sm">Configure social platform APIs</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Facebook -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray text-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-full mx-auto mb-2 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">f</span>
                        </div>
                        <h3 class="text-white font-medium mb-2">Facebook</h3>
                        <div class="w-3 h-3 bg-red-500 rounded-full mx-auto mb-2"></div>
                        <button class="w-full bg-blue-600 text-white py-1 rounded text-sm" disabled>Setup</button>
                    </div>

                    <!-- Twitter -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray text-center">
                        <div class="w-8 h-8 bg-blue-400 rounded-full mx-auto mb-2 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">T</span>
                        </div>
                        <h3 class="text-white font-medium mb-2">Twitter</h3>
                        <div class="w-3 h-3 bg-red-500 rounded-full mx-auto mb-2"></div>
                        <button class="w-full bg-blue-600 text-white py-1 rounded text-sm" disabled>Setup</button>
                    </div>

                    <!-- Instagram -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray text-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">I</span>
                        </div>
                        <h3 class="text-white font-medium mb-2">Instagram</h3>
                        <div class="w-3 h-3 bg-red-500 rounded-full mx-auto mb-2"></div>
                        <button class="w-full bg-blue-600 text-white py-1 rounded text-sm" disabled>Setup</button>
                    </div>

                    <!-- YouTube -->
                    <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray text-center">
                        <div class="w-8 h-8 bg-red-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">Y</span>
                        </div>
                        <h3 class="text-white font-medium mb-2">YouTube</h3>
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mx-auto mb-2"></div>
                        <button class="w-full bg-blue-600 text-white py-1 rounded text-sm" disabled>Configure</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save All Button -->
    <div class="mt-8 flex justify-end">
        <button class="px-8 py-3 bg-spotify-green text-white rounded-lg hover:bg-spotify-green-light transition-colors font-semibold opacity-50 cursor-not-allowed" disabled>
            Save All Configurations
        </button>
    </div>
</div>
@endsection