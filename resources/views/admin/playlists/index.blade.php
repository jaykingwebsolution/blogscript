@extends('admin.layout')

@section('title', 'Playlists Management')

@section('header', 'Playlists Management')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-spotify-green rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Playlists Management</h1>
                    <p class="text-spotify-light-gray mt-1">Manage user-created and admin curated playlists</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <a href="{{ route('admin.playlists.create') }}" class="bg-spotify-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-spotify-green-light transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create Admin Playlist
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Total Playlists</p>
                    <p class="text-3xl font-bold text-white">{{ $playlists->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Public Playlists</p>
                    <p class="text-3xl font-bold text-spotify-green">{{ $playlists->where('visibility', 'public')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-spotify-green rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Featured Playlists</p>
                    <p class="text-3xl font-bold text-yellow-400">{{ $playlists->where('is_featured', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Total Tracks</p>
                    <p class="text-3xl font-bold text-purple-400">{{ $playlists->sum('music_count') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <form method="GET" action="{{ route('admin.playlists.index') }}" class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search playlists..." 
                           class="bg-spotify-black border border-spotify-light-gray text-white px-4 py-2 rounded-lg pl-10 w-full sm:w-64">
                    <svg class="w-4 h-4 text-spotify-light-gray absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <select name="visibility" class="bg-spotify-black border border-spotify-light-gray text-white px-4 py-2 rounded-lg">
                    <option value="">All Visibility</option>
                    <option value="public" {{ request('visibility') === 'public' ? 'selected' : '' }}>Public</option>
                    <option value="private" {{ request('visibility') === 'private' ? 'selected' : '' }}>Private</option>
                    <option value="unlisted" {{ request('visibility') === 'unlisted' ? 'selected' : '' }}>Unlisted</option>
                </select>
                <select name="featured" class="bg-spotify-black border border-spotify-light-gray text-white px-4 py-2 rounded-lg">
                    <option value="">All Status</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured</option>
                    <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Not Featured</option>
                </select>
                <select name="creator" class="bg-spotify-black border border-spotify-light-gray text-white px-4 py-2 rounded-lg">
                    <option value="">All Creators</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('creator') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.playlists.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Clear
                </a>
            </div>
        </div>
    </form>

    <!-- Bulk Actions Form -->
    <form id="bulkActionForm" method="POST" action="{{ route('admin.playlists.bulk-action') }}" class="mb-6">
        @csrf
        <div class="bg-spotify-gray rounded-xl p-4 border border-spotify-gray flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <input type="checkbox" id="selectAll" class="rounded bg-spotify-black border-spotify-light-gray text-spotify-green">
                <label for="selectAll" class="text-white text-sm">Select All</label>
                <select name="action" class="bg-spotify-black border border-spotify-light-gray text-white px-3 py-2 rounded-lg text-sm">
                    <option value="">Bulk Actions</option>
                    <option value="delete">Delete Selected</option>
                    <option value="feature">Feature Selected</option>
                    <option value="unfeature">Unfeature Selected</option>
                    <option value="make_public">Make Public</option>
                    <option value="make_private">Make Private</option>
                </select>
            </div>
            <button type="submit" class="bg-spotify-green text-white px-4 py-2 rounded-lg hover:bg-spotify-green-light transition-colors text-sm">
                Apply
            </button>
        </div>

        <!-- Playlists Grid -->
        <div class="bg-spotify-gray rounded-xl border border-spotify-gray overflow-hidden mt-6">
            <div class="p-6 border-b border-spotify-light-gray">
                <h2 class="text-xl font-semibold text-white">Platform Playlists</h2>
                <p class="text-spotify-light-gray text-sm mt-1">Manage all playlists created by users and admin</p>
            </div>
            
            <div class="p-6">
                @if($playlists->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($playlists as $playlist)
                            <div class="bg-spotify-black rounded-lg p-4 hover:bg-spotify-dark-gray transition-colors">
                                <div class="flex items-center justify-between mb-4">
                                    <input type="checkbox" name="playlist_ids[]" value="{{ $playlist->id }}" class="playlistCheckbox rounded bg-spotify-black border-spotify-light-gray text-spotify-green">
                                    @if($playlist->is_featured)
                                        <span class="px-2 py-1 text-xs font-medium bg-spotify-green bg-opacity-20 text-spotify-green rounded-full">
                                            Featured
                                        </span>
                                    @elseif($playlist->visibility === 'private')
                                        <span class="px-2 py-1 text-xs font-medium bg-red-500 bg-opacity-20 text-red-400 rounded-full">
                                            Private
                                        </span>
                                    @elseif($playlist->visibility === 'unlisted')
                                        <span class="px-2 py-1 text-xs font-medium bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-full">
                                            Unlisted
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-500 bg-opacity-20 text-blue-400 rounded-full">
                                            Public
                                        </span>
                                    @endif
                                </div>

                                <div class="aspect-square bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg mb-4 flex items-center justify-center">
                                    @if($playlist->cover_image)
                                        <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->title }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                        </svg>
                                    @endif
                                </div>
                                
                                <div>
                                    <h3 class="text-white font-semibold truncate mb-1">{{ $playlist->title }}</h3>
                                    <p class="text-spotify-light-gray text-sm truncate mb-2">by {{ $playlist->user->name }} • {{ $playlist->music_count }} tracks</p>
                                    <div class="flex items-center justify-between text-sm text-spotify-light-gray mb-3">
                                        <span>{{ ucfirst($playlist->visibility) }}</span>
                                        <span>{{ $playlist->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-1">
                                            <a href="{{ route('admin.playlists.show', $playlist) }}" class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors" title="View">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.playlists.edit', $playlist) }}" class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center hover:bg-yellow-700 transition-colors" title="Edit">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        </div>
                                        @if($playlist->is_featured)
                                            <form method="POST" action="{{ route('admin.playlists.unfeature', $playlist) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 bg-spotify-green rounded-full flex items-center justify-center hover:bg-spotify-green-light transition-colors" title="Unfeature">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.playlists.feature', $playlist) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors" title="Feature">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $playlists->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-spotify-light-gray mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        <h3 class="text-white text-xl font-semibold mb-2">No playlists found</h3>
                        <p class="text-spotify-light-gray mb-4">No playlists match your current filters.</p>
                        <a href="{{ route('admin.playlists.create') }}" class="bg-spotify-green text-white px-6 py-3 rounded-lg hover:bg-spotify-green-light transition-colors">
                            Create First Playlist
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const playlistCheckboxes = document.querySelectorAll('.playlistCheckbox');
    const bulkActionForm = document.getElementById('bulkActionForm');
    
    selectAllCheckbox.addEventListener('change', function() {
        playlistCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Handle bulk actions
    bulkActionForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.playlistCheckbox:checked');
        const actionSelect = document.querySelector('[name="action"]');
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one playlist.');
            return;
        }
        
        if (!actionSelect.value) {
            e.preventDefault();
            alert('Please select an action.');
            return;
        }
        
        if (!confirm(`Are you sure you want to ${actionSelect.value} ${checkedBoxes.length} playlist(s)?`)) {
            e.preventDefault();
        }
    });
});
</script>
@endsection