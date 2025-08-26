@extends('admin.layout')

@section('title', 'API Keys & Integration')

@section('header', 'API Keys & Integration')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-spotify-green rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.586l4.707-4.707A1 1 0 0111 3h6a2 2 0 012 2v7z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">API Keys & Integration</h1>
                    <p class="text-spotify-light-gray mt-1">Manage external service integrations and API credentials</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <a href="{{ route('admin.api-keys.logs') }}" class="bg-spotify-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-spotify-green-light transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    View API Logs
                </a>
            </div>
        </div>
    </div>

    <!-- API Connection Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-spotify-green rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.48.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold">Spotify API</h3>
                        <p class="text-spotify-light-gray text-sm">Music import service</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-spotify-green rounded-full mr-2"></div>
                    <span class="text-spotify-green text-sm font-medium">Connected</span>
                </div>
            </div>
            <div class="space-y-2 text-sm text-spotify-light-gray">
                <div class="flex justify-between">
                    <span>API Calls Today:</span>
                    <span class="text-white">1,247 / 10,000</span>
                </div>
                <div class="flex justify-between">
                    <span>Last Import:</span>
                    <span class="text-white">2 hours ago</span>
                </div>
            </div>
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('admin.api-keys.spotify') }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    Configure
                </a>
                <button onclick="testConnection('spotify')" class="flex-1 bg-spotify-green text-white py-2 rounded-lg hover:bg-spotify-green-light transition-colors text-sm">
                    Test
                </button>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold">Paystack API</h3>
                        <p class="text-spotify-light-gray text-sm">Payment processing</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-spotify-green rounded-full mr-2"></div>
                    <span class="text-spotify-green text-sm font-medium">Connected</span>
                </div>
            </div>
            <div class="space-y-2 text-sm text-spotify-light-gray">
                <div class="flex justify-between">
                    <span>Transactions Today:</span>
                    <span class="text-white">23</span>
                </div>
                <div class="flex justify-between">
                    <span>Success Rate:</span>
                    <span class="text-white">98.2%</span>
                </div>
            </div>
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('admin.api-keys.paystack') }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    Configure
                </a>
                <button onclick="testConnection('paystack')" class="flex-1 bg-spotify-green text-white py-2 rounded-lg hover:bg-spotify-green-light transition-colors text-sm">
                    Test
                </button>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold">Third-Party Services</h3>
                        <p class="text-spotify-light-gray text-sm">Email, Storage, Analytics</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                    <span class="text-yellow-400 text-sm font-medium">Partial</span>
                </div>
            </div>
            <div class="space-y-2 text-sm text-spotify-light-gray">
                <div class="flex justify-between">
                    <span>Active Services:</span>
                    <span class="text-white">3 / 5</span>
                </div>
                <div class="flex justify-between">
                    <span>Health Score:</span>
                    <span class="text-yellow-400">85%</span>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.api-keys.services') }}" class="w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm block">
                    Manage Services
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
                <p class="text-sm">This API integration management system requires full implementation including secure credential storage, connection testing, and usage monitoring.</p>
            </div>
        </div>
    </div>

    <!-- Integration Management Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- API Keys Management -->
        <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
            <div class="p-6 border-b border-spotify-light-gray">
                <h2 class="text-xl font-semibold text-white">Platform API Keys</h2>
                <p class="text-spotify-light-gray text-sm mt-1">Internal API keys for platform access</p>
            </div>
            <div class="p-6 space-y-4">
                <!-- Sample API Key -->
                <div class="bg-spotify-black rounded-lg p-4 border border-spotify-light-gray">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-white font-medium">Mobile App API Key</h4>
                            <p class="text-spotify-light-gray text-sm">Created: Jan 15, 2024</p>
                            <p class="text-spotify-light-gray text-sm">Last used: 2 hours ago</p>
                        </div>
                        <div class="flex space-x-2">
                            <span class="px-2 py-1 text-xs font-medium bg-spotify-green bg-opacity-20 text-spotify-green rounded-full">
                                Active
                            </span>
                            <button class="text-red-400 hover:text-red-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="flex items-center space-x-2">
                            <code class="flex-1 bg-spotify-dark-gray text-spotify-light-gray px-3 py-2 rounded text-sm font-mono">
                                pk_••••••••••••••••••••••••••••••••
                            </code>
                            <button class="text-spotify-green hover:text-spotify-green-light">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Generate New Key Button -->
                <button onclick="generateApiKey()" class="w-full bg-spotify-green text-white py-3 rounded-lg hover:bg-spotify-green-light transition-colors">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Generate New API Key
                </button>
            </div>
        </div>

        <!-- Service Status Overview -->
        <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
            <div class="p-6 border-b border-spotify-light-gray">
                <h2 class="text-xl font-semibold text-white">Service Status</h2>
                <p class="text-spotify-light-gray text-sm mt-1">Monitor integration health and performance</p>
            </div>
            <div class="p-6 space-y-4">
                <!-- Service Status Items -->
                <div class="flex items-center justify-between p-3 bg-spotify-black rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-spotify-green rounded-full"></div>
                        <div>
                            <p class="text-white font-medium">Spotify Import Service</p>
                            <p class="text-spotify-light-gray text-sm">99.9% uptime</p>
                        </div>
                    </div>
                    <span class="text-spotify-green text-sm">Operational</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-spotify-black rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-spotify-green rounded-full"></div>
                        <div>
                            <p class="text-white font-medium">Payment Gateway</p>
                            <p class="text-spotify-light-gray text-sm">98.2% uptime</p>
                        </div>
                    </div>
                    <span class="text-spotify-green text-sm">Operational</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-spotify-black rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <div>
                            <p class="text-white font-medium">Email Service</p>
                            <p class="text-spotify-light-gray text-sm">85.1% uptime</p>
                        </div>
                    </div>
                    <span class="text-yellow-400 text-sm">Degraded</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-spotify-black rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <div>
                            <p class="text-white font-medium">Cloud Storage</p>
                            <p class="text-spotify-light-gray text-sm">Connection failed</p>
                        </div>
                    </div>
                    <span class="text-red-400 text-sm">Offline</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Usage Statistics -->
    <div class="mt-8 bg-spotify-gray rounded-xl border border-spotify-gray">
        <div class="p-6 border-b border-spotify-light-gray">
            <h2 class="text-xl font-semibold text-white">API Usage Statistics</h2>
            <p class="text-spotify-light-gray text-sm mt-1">Monitor API calls and quotas across all services</p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">15,247</div>
                    <div class="text-spotify-light-gray">Total API Calls Today</div>
                    <div class="mt-2">
                        <div class="w-full bg-spotify-dark-gray rounded-full h-2">
                            <div class="bg-spotify-green h-2 rounded-full" style="width: 65%"></div>
                        </div>
                        <div class="text-sm text-spotify-light-gray mt-1">65% of daily quota</div>
                    </div>
                </div>

                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">287</div>
                    <div class="text-spotify-light-gray">Failed Requests</div>
                    <div class="mt-2">
                        <div class="text-sm text-red-400">1.9% error rate</div>
                        <div class="text-xs text-spotify-light-gray">Mostly timeout errors</div>
                    </div>
                </div>

                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-2">142ms</div>
                    <div class="text-spotify-light-gray">Average Response Time</div>
                    <div class="mt-2">
                        <div class="text-sm text-spotify-green">↓ 23ms from yesterday</div>
                        <div class="text-xs text-spotify-light-gray">Performance improving</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testConnection(service) {
    // TODO: Implement actual API connection testing
    alert('Testing connection to ' + service + '... (TODO: Implement actual testing)');
}

function generateApiKey() {
    // TODO: Implement API key generation
    alert('Generate new API key... (TODO: Implement key generation)');
}
</script>
@endsection