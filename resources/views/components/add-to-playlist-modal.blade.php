@auth
<!-- Add to Playlist Modal -->
<div id="playlist-modal-{{ $musicId }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add to Playlist</h3>
            
            <div class="max-h-60 overflow-y-auto space-y-2" id="playlists-list-{{ $musicId }}">
                @if(auth()->user()->playlists->count() > 0)
                    @foreach(auth()->user()->playlists as $playlist)
                        <button onclick="addToPlaylist({{ $playlist->id }}, {{ $musicId }})" 
                                class="w-full text-left p-3 hover:bg-gray-50 rounded-lg transition-colors flex items-center space-x-3">
                            <img src="{{ $playlist->cover_image_url }}" 
                                 alt="{{ $playlist->title }}" 
                                 class="w-10 h-10 rounded">
                            <div>
                                <div class="font-medium text-gray-900">{{ $playlist->title }}</div>
                                <div class="text-sm text-gray-500">{{ $playlist->music_count }} songs</div>
                            </div>
                        </button>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 mb-4">You don't have any playlists yet.</p>
                    </div>
                @endif
            </div>
            
            <!-- Create New Playlist Form -->
            <div class="mt-4 border-t pt-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Or create a new playlist:</h4>
                <form onsubmit="createPlaylistAndAdd(event, {{ $musicId }})" class="space-y-3">
                    <div>
                        <input type="text" 
                               id="new-playlist-title-{{ $musicId }}"
                               placeholder="Playlist name" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <textarea id="new-playlist-description-{{ $musicId }}"
                                  placeholder="Description (optional)" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  rows="2"></textarea>
                    </div>
                    <div>
                        <select id="new-playlist-visibility-{{ $musicId }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="private">Private</option>
                            <option value="public">Public</option>
                            <option value="unlisted">Unlisted</option>
                        </select>
                    </div>
                    <button type="submit" 
                            class="w-full bg-spotify-green text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                        Create & Add Song
                    </button>
                </form>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6 border-t pt-4">
                <button onclick="hidePlaylistModal({{ $musicId }})" 
                        class="px-4 py-2 text-gray-500 hover:text-gray-700">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endauth

<script>
function showPlaylistModal(musicId) {
    document.getElementById('playlist-modal-' + musicId).classList.remove('hidden');
}

function hidePlaylistModal(musicId) {
    document.getElementById('playlist-modal-' + musicId).classList.add('hidden');
}

function addToPlaylist(playlistId, musicId) {
    fetch(`/playlists/${playlistId}/add-music`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            music_id: musicId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', data.message);
            hidePlaylistModal(musicId);
        } else {
            showNotification('error', data.message || 'Failed to add to playlist');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Failed to add to playlist');
    });
}

function createPlaylistAndAdd(event, musicId) {
    event.preventDefault();
    
    const title = document.getElementById('new-playlist-title-' + musicId).value;
    const description = document.getElementById('new-playlist-description-' + musicId).value;
    const visibility = document.getElementById('new-playlist-visibility-' + musicId).value;
    
    fetch('/playlists/create-ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            title: title,
            description: description,
            visibility: visibility,
            music_id: musicId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Playlist created and song added successfully!');
            hidePlaylistModal(musicId);
            
            // Refresh playlist list for future use
            refreshPlaylistList(musicId);
        } else {
            showNotification('error', data.message || 'Failed to create playlist');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Failed to create playlist');
    });
}

function refreshPlaylistList(musicId) {
    fetch('/playlists/user-playlists')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const playlistsList = document.getElementById('playlists-list-' + musicId);
                if (data.playlists.length > 0) {
                    let playlistsHTML = '';
                    data.playlists.forEach(playlist => {
                        playlistsHTML += `
                            <button onclick="addToPlaylist(${playlist.id}, ${musicId})" 
                                    class="w-full text-left p-3 hover:bg-gray-50 rounded-lg transition-colors flex items-center space-x-3">
                                <img src="${playlist.cover_image_url}" 
                                     alt="${playlist.title}" 
                                     class="w-10 h-10 rounded">
                                <div>
                                    <div class="font-medium text-gray-900">${playlist.title}</div>
                                    <div class="text-sm text-gray-500">${playlist.music_count} songs</div>
                                </div>
                            </button>
                        `;
                    });
                    playlistsList.innerHTML = playlistsHTML;
                } else {
                    playlistsList.innerHTML = `
                        <div class="text-center py-4">
                            <p class="text-gray-500 mb-4">You don't have any playlists yet.</p>
                        </div>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Error refreshing playlists:', error);
        });
}

// Notification system
function showNotification(type, message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 3000);
}
</script>