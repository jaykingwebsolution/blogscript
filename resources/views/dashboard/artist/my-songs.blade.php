@extends('layouts.artist-dashboard')

@section('dashboard-content')
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Songs</h1>
            <p class="text-gray-300">Manage your music library</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('dashboard.artist.upload-music') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full font-medium transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Upload New Song
            </a>
        </div>
    </div>

    <!-- Filter/Search Bar -->
    <div class="bg-gray-800 rounded-lg p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search your songs..." 
                       class="w-full bg-gray-700 border border-gray-600 text-white placeholder-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div>
                <select class="bg-gray-700 border border-gray-600 text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">All Status</option>
                    <option value="pending">Pending Review</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div>
                <select class="bg-gray-700 border border-gray-600 text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">All Genres</option>
                    <option value="Afrobeats">Afrobeats</option>
                    <option value="Hip Hop">Hip Hop</option>
                    <option value="R&B">R&B</option>
                    <option value="Pop">Pop</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Songs Grid/List -->
    @if($songs->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($songs as $song)
            <div class="bg-gray-800 rounded-xl overflow-hidden hover:bg-gray-750 transition-colors group">
                <!-- Cover Image -->
                <div class="relative aspect-square bg-gray-700">
                    @if($song->cover_image)
                        <img src="{{ Storage::url($song->cover_image) }}" alt="{{ $song->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $song->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                               ($song->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                               'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                            {{ ucfirst($song->status) }}
                        </span>
                    </div>

                    <!-- Action Buttons Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                        <div class="flex space-x-2">
                            @if($song->audio_file)
                            <button class="bg-purple-600 hover:bg-purple-700 text-white rounded-full p-3 transition-colors" title="Play">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            @endif
                            
                            <a href="{{ route('dashboard.artist.my-songs.edit', $song) }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Song Info -->
                <div class="p-4">
                    <h3 class="text-white font-medium text-lg truncate mb-1">{{ $song->title }}</h3>
                    <p class="text-gray-400 text-sm mb-2">{{ $song->genre }}</p>
                    
                    <!-- Stats Row -->
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                        <div class="flex items-center space-x-3">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                                {{ $song->likes_count }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                                0 plays
                            </span>
                        </div>
                        <span>{{ $song->created_at->format('M j') }}</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('dashboard.artist.my-songs.edit', $song) }}" 
                           class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                            Edit
                        </a>
                        
                        <div class="relative">
                            <button class="text-gray-400 hover:text-white transition-colors dropdown-toggle" data-song-id="{{ $song->id }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu hidden absolute right-0 bottom-full mb-2 w-48 bg-gray-700 rounded-md shadow-lg z-10" data-song-id="{{ $song->id }}">
                                <div class="py-1">
                                    <a href="{{ route('dashboard.artist.my-songs.edit', $song) }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-white">
                                        Edit Song
                                    </a>
                                    @if($song->status === 'approved')
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-white">
                                        Submit for Trending
                                    </a>
                                    @endif
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-white">
                                        View Analytics
                                    </a>
                                    <hr class="border-gray-600 my-1">
                                    <button type="button" onclick="deleteSong({{ $song->id }})" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-600 hover:text-red-300">
                                        Delete Song
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $songs->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="mb-8">
                <div class="bg-gray-800 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.367 4.367 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                    </svg>
                </div>
                <h3 class="text-gray-300 text-xl mb-2">No songs yet</h3>
                <p class="text-gray-500 mb-6">Start building your music library by uploading your first track</p>
            </div>

            <a href="{{ route('dashboard.artist.upload-music') }}" 
               class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-8 rounded-full transition-all transform hover:scale-105">
                Upload Your First Song
            </a>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-4">Delete Song</h3>
        <p class="text-gray-300 mb-6">Are you sure you want to delete this song? This action cannot be undone.</p>
        
        <div class="flex space-x-4">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                Cancel
            </button>
            <form id="deleteForm" method="POST" style="flex: 1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Dropdown functionality
document.addEventListener('click', function(e) {
    if (e.target.closest('.dropdown-toggle')) {
        e.preventDefault();
        const songId = e.target.closest('.dropdown-toggle').dataset.songId;
        const menu = document.querySelector(`.dropdown-menu[data-song-id="${songId}"]`);
        
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            if (m !== menu) m.classList.add('hidden');
        });
        
        menu.classList.toggle('hidden');
    } else if (!e.target.closest('.dropdown-menu')) {
        // Close all dropdowns when clicking outside
        document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.add('hidden'));
    }
});

// Delete song functionality
function deleteSong(songId) {
    const form = document.getElementById('deleteForm');
    form.action = `/dashboard/artist/my-songs/${songId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection