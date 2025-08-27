@extends('admin.layout')

@section('title', 'Spotify API Configuration')

@section('header', 'Spotify API Configuration')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-spotify-green rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.48.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Spotify API Configuration</h1>
                    <p class="text-spotify-light-gray mt-1">Configure Spotify integration settings and credentials</p>
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
                <p class="text-sm">Spotify API configuration interface needs to be implemented with secure credential storage and connection testing.</p>
            </div>
        </div>
    </div>

    <!-- Configuration Form -->
    <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
        <div class="p-6 border-b border-spotify-light-gray">
            <h2 class="text-xl font-semibold text-white">Spotify Developer Settings</h2>
            <p class="text-spotify-light-gray text-sm mt-1">Configure your Spotify Web API credentials</p>
        </div>
        
        <form action="{{ route('admin.api-keys.update-spotify') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-6">
                <!-- Client ID -->
                <div>
                    <label class="block text-white font-medium mb-2">Client ID</label>
                    <input type="text" name="client_id" 
                           class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white placeholder-spotify-light-gray focus:border-spotify-green focus:ring-2 focus:ring-spotify-green focus:ring-opacity-20 focus:outline-none"
                           placeholder="Enter your Spotify Client ID"
                           value="{{ old('client_id', 'YOUR_SPOTIFY_CLIENT_ID') }}" readonly>
                    <p class="text-sm text-spotify-light-gray mt-2">
                        Get this from your <a href="https://developer.spotify.com/dashboard" target="_blank" class="text-spotify-green hover:underline">Spotify Developer Dashboard</a>
                    </p>
                </div>

                <!-- Client Secret -->
                <div>
                    <label class="block text-white font-medium mb-2">Client Secret</label>
                    <input type="password" name="client_secret" 
                           class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white placeholder-spotify-light-gray focus:border-spotify-green focus:ring-2 focus:ring-spotify-green focus:ring-opacity-20 focus:outline-none"
                           placeholder="Enter your Spotify Client Secret"
                           value="••••••••••••••••••••••••••••••••" readonly>
                    <p class="text-sm text-spotify-light-gray mt-2">
                        Keep this secret secure. It will be encrypted when stored.
                    </p>
                </div>

                <!-- Redirect URI -->
                <div>
                    <label class="block text-white font-medium mb-2">Redirect URI</label>
                    <input type="url" name="redirect_uri" 
                           class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white placeholder-spotify-light-gray focus:border-spotify-green focus:ring-2 focus:ring-spotify-green focus:ring-opacity-20 focus:outline-none"
                           placeholder="https://yourdomain.com/auth/spotify/callback"
                           value="{{ url('/auth/spotify/callback') }}" readonly>
                    <p class="text-sm text-spotify-light-gray mt-2">
                        Add this URI to your Spotify app settings
                    </p>
                </div>

                <!-- Scopes -->
                <div>
                    <label class="block text-white font-medium mb-2">API Scopes</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="scopes[]" value="user-read-private" checked disabled
                                   class="rounded border-spotify-light-gray text-spotify-green focus:border-spotify-green focus:ring-spotify-green focus:ring-opacity-20">
                            <span class="ml-2 text-white">user-read-private - Read user profile</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="scopes[]" value="user-read-email" checked disabled
                                   class="rounded border-spotify-light-gray text-spotify-green focus:border-spotify-green focus:ring-spotify-green focus:ring-opacity-20">
                            <span class="ml-2 text-white">user-read-email - Read user email</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="scopes[]" value="playlist-read-private" checked disabled
                                   class="rounded border-spotify-light-gray text-spotify-green focus:border-spotify-green focus:ring-spotify-green focus:ring-opacity-20">
                            <span class="ml-2 text-white">playlist-read-private - Read private playlists</span>
                        </label>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="testSpotifyConnection()" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Test Connection
                    </button>
                    <button type="submit" disabled
                            class="px-6 py-3 bg-spotify-green text-white rounded-lg hover:bg-spotify-green-light transition-colors opacity-50 cursor-not-allowed">
                        Save Configuration
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function testSpotifyConnection() {
    alert('Testing Spotify connection... (TODO: Implement actual testing)');
}
</script>
@endsection