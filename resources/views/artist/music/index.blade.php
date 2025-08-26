@extends('layouts.app')

@section('title', 'My Music')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">My Music</h1>
                    <a href="{{ route('artist.music.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        Upload New Music
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($music as $track)
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="relative">
                            <img src="{{ $track->cover_image ? asset('storage/' . $track->cover_image) : 'asset("images/default-music.svg")' }}" 
                                 alt="{{ $track->title }}" class="w-full h-48 object-cover">
                            
                            <div class="absolute top-2 right-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $track->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $track->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $track->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $track->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($track->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $track->title }}</h3>
                            <p class="text-gray-600 mb-2">{{ $track->artist_name }}</p>
                            
                            @if($track->category)
                                <span class="inline-block bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-medium">
                                    {{ $track->category->name }}
                                </span>
                            @endif
                            
                            @if($track->genre)
                                <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs ml-1">
                                    {{ $track->genre }}
                                </span>
                            @endif
                            
                            <div class="flex justify-between items-center mt-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('artist.music.show', $track) }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                        View
                                    </a>
                                    <a href="{{ route('artist.music.edit', $track) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('artist.music.destroy', $track) }}" onsubmit="return confirm('Are you sure you want to delete this music?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $track->created_at->format('M j, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No music uploaded yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by uploading your first track.</p>
                        <div class="mt-6">
                            <a href="{{ route('artist.music.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                Upload Music
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
                
                @if($music->hasPages())
                <div class="mt-8">
                    {{ $music->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection