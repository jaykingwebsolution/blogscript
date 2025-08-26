@extends('admin.layout')

@section('title', 'Import from Spotify')

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
                    <h1 class="text-3xl font-bold text-white">Import from Spotify</h1>
                    <p class="text-spotify-light-gray mt-1">Search and import artists, albums, and tracks from Spotify</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <button onclick="syncAllArtists()" class="bg-spotify-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-spotify-green-light transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Sync All Artists
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Total Artists</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_artists'] }}</p>
                </div>
                <div class="w-12 h-12 bg-spotify-green rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Total Albums</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_albums'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Total Tracks</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_tracks'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Need Sync</p>
                    <p class="text-3xl font-bold text-yellow-400">{{ $stats['artists_needing_sync'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-spotify-gray rounded-xl p-6 mb-8 border border-spotify-gray">
        <h2 class="text-xl font-semibold text-white mb-4">Search Spotify Artists</h2>
        <div class="flex space-x-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    id="spotify-search" 
                    placeholder="Search for artists on Spotify..."
                    class="w-full px-4 py-3 bg-spotify-dark-gray border border-spotify-gray rounded-lg text-white placeholder-spotify-light-gray focus:border-spotify-green focus:outline-none"
                >
            </div>
            <button 
                onclick="searchSpotify()" 
                class="bg-spotify-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-spotify-green-light transition-colors duration-200">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Search
            </button>
        </div>
        
        <!-- Search Results -->
        <div id="search-results" class="mt-6 hidden">
            <h3 class="text-lg font-semibold text-white mb-4">Search Results</h3>
            <div id="search-results-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Results will be populated here -->
            </div>
        </div>
    </div>

    <!-- Imported Artists Section -->
    <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-white">Imported Artists</h2>
            <div class="flex space-x-2">
                <input type="checkbox" id="select-all" class="text-spotify-green">
                <label for="select-all" class="text-spotify-light-gray">Select All</label>
            </div>
        </div>

        @if($importedArtists->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($importedArtists as $artist)
                    <div class="bg-spotify-dark-gray rounded-lg p-4 border border-spotify-gray hover:border-spotify-green transition-colors duration-200">
                        <div class="flex items-start space-x-2 mb-3">
                            <input 
                                type="checkbox" 
                                name="selected_artists[]" 
                                value="{{ $artist->id }}"
                                class="mt-1 text-spotify-green artist-checkbox"
                            >
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    @if($artist->image_url)
                                        <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-spotify-green rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-white">{{ $artist->name }}</h3>
                                        <p class="text-sm text-spotify-light-gray">{{ number_format($artist->followers) }} followers</p>
                                    </div>
                                </div>
                                
                                <div class="mt-3 text-sm text-spotify-light-gray">
                                    <p>{{ $artist->albums->count() }} albums • {{ $artist->tracks->count() }} tracks</p>
                                    <p>Genres: {{ $artist->getGenresString() ?: 'N/A' }}</p>
                                    @if($artist->last_synced_at)
                                        <p>Last synced: {{ $artist->last_synced_at->diffForHumans() }}</p>
                                    @else
                                        <p class="text-yellow-400">Never synced</p>
                                    @endif
                                </div>

                                <div class="mt-4 flex space-x-2">
                                    <button 
                                        onclick="syncArtist({{ $artist->id }})"
                                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors duration-200">
                                        Sync
                                    </button>
                                    @if($artist->getSpotifyUrl())
                                        <a href="{{ $artist->getSpotifyUrl() }}" target="_blank" 
                                           class="bg-spotify-green text-white px-3 py-1 rounded text-sm hover:bg-spotify-green-light transition-colors duration-200">
                                            View on Spotify
                                        </a>
                                    @endif
                                    <button 
                                        onclick="deleteArtist({{ $artist->id }}, '{{ $artist->name }}')"
                                        class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors duration-200">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $importedArtists->links('pagination::tailwind') }}
            </div>

            <!-- Bulk Actions -->
            <div class="mt-6 p-4 bg-spotify-dark-gray rounded-lg border border-spotify-gray hidden" id="bulk-actions">
                <div class="flex items-center justify-between">
                    <span class="text-white font-semibold" id="selected-count">0 artists selected</span>
                    <div class="space-x-2">
                        <button onclick="bulkSync()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors duration-200">
                            Bulk Sync
                        </button>
                        <button onclick="bulkDelete()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors duration-200">
                            Bulk Delete
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-spotify-light-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">No Artists Imported Yet</h3>
                <p class="text-spotify-light-gray mb-6">Start by searching for artists on Spotify and importing them.</p>
            </div>
        @endif
    </div>
</div>

<script>
// CSRF token for requests
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Search functionality
function searchSpotify() {
    const query = document.getElementById('spotify-search').value.trim();
    if (!query) return;

    const resultsDiv = document.getElementById('search-results');
    const resultsGrid = document.getElementById('search-results-grid');
    
    resultsGrid.innerHTML = '<div class="col-span-full text-center py-4"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-spotify-green"></div></div>';
    resultsDiv.classList.remove('hidden');

    fetch(`{{ route('admin.spotify-import.search') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ query: query })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displaySearchResults(data.artists);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Search failed', 'error');
    });
}

function displaySearchResults(artists) {
    const resultsGrid = document.getElementById('search-results-grid');
    
    if (artists.length === 0) {
        resultsGrid.innerHTML = '<div class="col-span-full text-center py-4 text-spotify-light-gray">No artists found</div>';
        return;
    }

    resultsGrid.innerHTML = artists.map(artist => `
        <div class="bg-spotify-dark-gray rounded-lg p-4 border border-spotify-gray">
            <div class="flex items-center space-x-3 mb-3">
                <img src="${artist.images && artist.images[0] ? artist.images[0].url : '/default-artist.png'}" 
                     alt="${artist.name}" 
                     class="w-12 h-12 rounded-full object-cover">
                <div>
                    <h4 class="font-semibold text-white">${artist.name}</h4>
                    <p class="text-sm text-spotify-light-gray">${artist.followers ? number_format(artist.followers.total) : '0'} followers</p>
                </div>
            </div>
            <p class="text-sm text-spotify-light-gray mb-3">
                ${artist.genres ? artist.genres.join(', ') : 'No genres listed'}
            </p>
            <button 
                onclick="importArtist('${artist.id}')"
                class="${artist.is_imported ? 'bg-gray-600 cursor-not-allowed' : 'bg-spotify-green hover:bg-spotify-green-light'} text-white px-4 py-2 rounded text-sm transition-colors duration-200 w-full"
                ${artist.is_imported ? 'disabled' : ''}>
                ${artist.is_imported ? 'Already Imported' : 'Import Artist'}
            </button>
        </div>
    `).join('');
}

// Import artist
function importArtist(spotifyId) {
    fetch(`{{ route('admin.spotify-import.import') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ spotify_id: spotifyId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 2000);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Import failed', 'error');
    });
}

// Sync single artist
function syncArtist(artistId) {
    fetch(`{{ url('admin/spotify-import') }}/${artistId}/sync`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Sync failed', 'error');
    });
}

// Delete artist
function deleteArtist(artistId, artistName) {
    if (!confirm(`Are you sure you want to delete "${artistName}" and all their albums and tracks? This cannot be undone.`)) {
        return;
    }

    fetch(`{{ url('admin/spotify-import') }}/${artistId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Delete failed', 'error');
    });
}

// Bulk operations
function getSelectedArtists() {
    return Array.from(document.querySelectorAll('.artist-checkbox:checked')).map(cb => cb.value);
}

function updateBulkActions() {
    const selected = getSelectedArtists();
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    
    if (selected.length > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = `${selected.length} artist${selected.length > 1 ? 's' : ''} selected`;
    } else {
        bulkActions.classList.add('hidden');
    }
}

function bulkSync() {
    const selected = getSelectedArtists();
    if (selected.length === 0) return;

    fetch(`{{ route('admin.spotify-import.bulk-sync') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ artist_ids: selected })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 2000);
        } else {
            showNotification(data.message, 'error');
        }
    });
}

function syncAllArtists() {
    if (!confirm('Are you sure you want to sync all artists? This may take a while.')) return;

    const allArtists = Array.from(document.querySelectorAll('.artist-checkbox')).map(cb => cb.value);
    
    fetch(`{{ route('admin.spotify-import.bulk-sync') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ artist_ids: allArtists })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 3000);
        } else {
            showNotification(data.message, 'error');
        }
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Search on Enter key
    document.getElementById('spotify-search').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchSpotify();
        }
    });

    // Select all checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.artist-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateBulkActions();
    });

    // Individual checkboxes
    document.querySelectorAll('.artist-checkbox').forEach(cb => {
        cb.addEventListener('change', updateBulkActions);
    });
});

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg text-white ${type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600'}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

function number_format(number) {
    return new Intl.NumberFormat().format(number);
}
</script>
@endsection