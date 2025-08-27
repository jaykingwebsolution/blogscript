@extends('admin.layout')

@section('title', 'API Usage Logs')

@section('header', 'API Usage Logs')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-spotify-green rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">API Usage Logs</h1>
                    <p class="text-spotify-light-gray mt-1">Monitor API usage, performance metrics, and error tracking</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-0 flex space-x-4">
                <a href="{{ route('admin.api-keys.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to API Keys
                </a>
                <button class="bg-spotify-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-spotify-green-light transition-colors duration-200" disabled>
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Logs
                </button>
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
                <p class="text-sm">API usage logging and monitoring system needs to be implemented with real-time tracking and detailed analytics.</p>
            </div>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="bg-spotify-gray rounded-xl border border-spotify-gray p-6 mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-white font-medium mb-2">Service</label>
                <select class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white" disabled>
                    <option>All Services</option>
                    <option>Spotify API</option>
                    <option>Paystack API</option>
                    <option>Internal API</option>
                </select>
            </div>
            <div>
                <label class="block text-white font-medium mb-2">Status</label>
                <select class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white" disabled>
                    <option>All Statuses</option>
                    <option>Success (200)</option>
                    <option>Client Error (4xx)</option>
                    <option>Server Error (5xx)</option>
                </select>
            </div>
            <div>
                <label class="block text-white font-medium mb-2">Time Range</label>
                <select class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white" disabled>
                    <option>Last 24 hours</option>
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Custom Range</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-spotify-green text-white py-3 rounded-lg hover:bg-spotify-green-light transition-colors" disabled>
                    Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Usage Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold">Total Requests</h3>
                    <p class="text-spotify-light-gray text-sm">Last 24 hours</p>
                </div>
            </div>
            <div class="text-3xl font-bold text-white mb-2">15,247</div>
            <div class="flex items-center text-sm">
                <svg class="w-4 h-4 text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
                <span class="text-green-400">+12.5%</span>
                <span class="text-spotify-light-gray ml-1">from yesterday</span>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold">Error Rate</h3>
                    <p class="text-spotify-light-gray text-sm">Failed requests</p>
                </div>
            </div>
            <div class="text-3xl font-bold text-white mb-2">1.9%</div>
            <div class="flex items-center text-sm">
                <svg class="w-4 h-4 text-red-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
                <span class="text-red-400">-0.3%</span>
                <span class="text-spotify-light-gray ml-1">from yesterday</span>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold">Avg Response</h3>
                    <p class="text-spotify-light-gray text-sm">Response time</p>
                </div>
            </div>
            <div class="text-3xl font-bold text-white mb-2">142ms</div>
            <div class="flex items-center text-sm">
                <svg class="w-4 h-4 text-green-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
                <span class="text-green-400">-23ms</span>
                <span class="text-spotify-light-gray ml-1">improvement</span>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold">Quota Usage</h3>
                    <p class="text-spotify-light-gray text-sm">Daily limits</p>
                </div>
            </div>
            <div class="text-3xl font-bold text-white mb-2">65%</div>
            <div class="w-full bg-spotify-dark-gray rounded-full h-2">
                <div class="bg-spotify-green h-2 rounded-full" style="width: 65%"></div>
            </div>
        </div>
    </div>

    <!-- Recent API Logs -->
    <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
        <div class="p-6 border-b border-spotify-light-gray">
            <h2 class="text-xl font-semibold text-white">Recent API Calls</h2>
            <p class="text-spotify-light-gray text-sm mt-1">Latest API requests and responses</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-spotify-black">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-medium text-spotify-light-gray">Timestamp</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-spotify-light-gray">Service</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-spotify-light-gray">Endpoint</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-spotify-light-gray">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-spotify-light-gray">Response Time</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-spotify-light-gray">User</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-spotify-light-gray">
                    <!-- Sample log entries -->
                    <tr>
                        <td class="px-6 py-4 text-sm text-white">2024-01-15 14:32:15</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-spotify-green rounded-full flex items-center justify-center mr-2">
                                    <span class="text-white text-xs">S</span>
                                </div>
                                <span class="text-white">Spotify API</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">GET /v1/me/playlists</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs font-medium bg-green-500 bg-opacity-20 text-green-400 rounded-full">
                                200 OK
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-white">123ms</td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">user@example.com</td>
                    </tr>
                    
                    <tr>
                        <td class="px-6 py-4 text-sm text-white">2024-01-15 14:31:45</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-white text-xs">P</span>
                                </div>
                                <span class="text-white">Paystack API</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">POST /transaction/initialize</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs font-medium bg-green-500 bg-opacity-20 text-green-400 rounded-full">
                                200 OK
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-white">89ms</td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">customer@test.com</td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 text-sm text-white">2024-01-15 14:30:22</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-white text-xs">I</span>
                                </div>
                                <span class="text-white">Internal API</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">GET /api/user/profile</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs font-medium bg-green-500 bg-opacity-20 text-green-400 rounded-full">
                                200 OK
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-white">45ms</td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">admin@blogscript.com</td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 text-sm text-white">2024-01-15 14:29:10</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-spotify-green rounded-full flex items-center justify-center mr-2">
                                    <span class="text-white text-xs">S</span>
                                </div>
                                <span class="text-white">Spotify API</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">GET /v1/search</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs font-medium bg-red-500 bg-opacity-20 text-red-400 rounded-full">
                                429 Rate Limited
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-white">2,340ms</td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">user2@example.com</td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 text-sm text-white">2024-01-15 14:28:33</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-white text-xs">P</span>
                                </div>
                                <span class="text-white">Paystack API</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">POST /transaction/verify</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-full">
                                400 Bad Request
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-white">156ms</td>
                        <td class="px-6 py-4 text-sm text-spotify-light-gray">webhook</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-6 border-t border-spotify-light-gray">
            <div class="flex items-center justify-between">
                <div class="text-sm text-spotify-light-gray">
                    Showing 1 to 5 of 1,247 entries
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 text-sm text-spotify-light-gray bg-spotify-black rounded-lg hover:bg-spotify-dark-gray transition-colors" disabled>
                        Previous
                    </button>
                    <button class="px-3 py-2 text-sm text-white bg-spotify-green rounded-lg hover:bg-spotify-green-light transition-colors" disabled>
                        1
                    </button>
                    <button class="px-3 py-2 text-sm text-spotify-light-gray bg-spotify-black rounded-lg hover:bg-spotify-dark-gray transition-colors" disabled>
                        2
                    </button>
                    <button class="px-3 py-2 text-sm text-spotify-light-gray bg-spotify-black rounded-lg hover:bg-spotify-dark-gray transition-colors" disabled>
                        3
                    </button>
                    <button class="px-3 py-2 text-sm text-spotify-light-gray bg-spotify-black rounded-lg hover:bg-spotify-dark-gray transition-colors" disabled>
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection