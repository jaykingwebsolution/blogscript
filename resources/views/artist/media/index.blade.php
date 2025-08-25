@extends('layouts.dashboard')

@section('title', 'My Media')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Media</h1>
        <a href="{{ route('artist.media.upload') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
            <i class="fas fa-plus mr-2"></i>Upload Media
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Status Filter Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="#" onclick="filterByStatus('all')" class="status-tab active py-2 px-1 border-b-2 font-medium text-sm">
                    All Media
                    <span class="ml-2 bg-gray-200 text-gray-800 py-1 px-2 rounded-full text-xs">
                        {{ $media->total() }}
                    </span>
                </a>
                <a href="#" onclick="filterByStatus('approved')" class="status-tab py-2 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Approved
                    <span class="ml-2 bg-green-200 text-green-800 py-1 px-2 rounded-full text-xs">
                        {{ $media->where('status', 'approved')->count() }}
                    </span>
                </a>
                <a href="#" onclick="filterByStatus('pending')" class="status-tab py-2 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Pending
                    <span class="ml-2 bg-yellow-200 text-yellow-800 py-1 px-2 rounded-full text-xs">
                        {{ $media->where('status', 'pending')->count() }}
                    </span>
                </a>
                <a href="#" onclick="filterByStatus('rejected')" class="status-tab py-2 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Rejected
                    <span class="ml-2 bg-red-200 text-red-800 py-1 px-2 rounded-full text-xs">
                        {{ $media->where('status', 'rejected')->count() }}
                    </span>
                </a>
            </nav>
        </div>
    </div>

    @if($media->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($media as $item)
                <div class="media-item bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300" data-status="{{ $item->status }}">
                    <!-- Media Preview -->
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                        @if($item->cover_url)
                            <img src="{{ $item->cover_url }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                        @elseif($item->type === 'image' && $item->file_url)
                            <img src="{{ $item->file_url }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gradient-to-br from-purple-400 to-pink-400">
                                @if($item->type === 'audio')
                                    <i class="fas fa-music text-4xl text-white"></i>
                                @elseif($item->type === 'video')
                                    <i class="fas fa-video text-4xl text-white"></i>
                                @else
                                    <i class="fas fa-image text-4xl text-white"></i>
                                @endif
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-2 left-2">
                            @if($item->status === 'approved')
                                <span class="bg-green-500 text-white text-xs font-medium px-2 py-1 rounded-full">
                                    <i class="fas fa-check mr-1"></i>Approved
                                </span>
                            @elseif($item->status === 'pending')
                                <span class="bg-yellow-500 text-white text-xs font-medium px-2 py-1 rounded-full">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @else
                                <span class="bg-red-500 text-white text-xs font-medium px-2 py-1 rounded-full">
                                    <i class="fas fa-times mr-1"></i>Rejected
                                </span>
                            @endif
                        </div>
                        
                        <!-- Media Type Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="bg-black bg-opacity-50 text-white text-xs font-medium px-2 py-1 rounded-full">
                                {{ ucfirst($item->type) }}
                            </span>
                        </div>
                    </div>

                    <!-- Media Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800 mb-2 truncate">{{ $item->title }}</h3>
                        
                        @if($item->description)
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($item->description, 100) }}</p>
                        @endif

                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                            <div class="flex items-center">
                                @if($item->isExternal())
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    <span>External</span>
                                @else
                                    <i class="fas fa-hdd mr-1"></i>
                                    <span>{{ $item->file_size_formatted }}</span>
                                @endif
                            </div>
                            <span>{{ $item->created_at->format('M d, Y') }}</span>
                        </div>

                        @if($item->category)
                            <div class="mb-3">
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ $item->category->name }}
                                </span>
                            </div>
                        @endif

                        @if($item->tags && count($item->tags) > 0)
                            <div class="mb-3">
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($item->tags, 0, 3) as $tag)
                                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                    @if(count($item->tags) > 3)
                                        <span class="text-gray-400 text-xs">+{{ count($item->tags) - 3 }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($item->status === 'rejected' && $item->rejection_reason)
                            <div class="mb-3 p-2 bg-red-50 rounded">
                                <p class="text-red-700 text-xs">
                                    <strong>Rejection Reason:</strong> {{ $item->rejection_reason }}
                                </p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                @if($item->file_url)
                                    <a href="{{ $item->file_url }}" target="_blank" class="text-purple-600 hover:text-purple-800 text-sm">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                                <a href="{{ route('artist.media.show', $item) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('artist.media.edit', $item) }}" class="text-green-600 hover:text-green-800 text-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <form action="{{ route('artist.media.destroy', $item) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this media?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $media->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 text-6xl mb-4">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-600 mb-2">No Media Found</h3>
            <p class="text-gray-500 mb-6">Start by uploading your first piece of media.</p>
            <a href="{{ route('artist.media.upload') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium">
                <i class="fas fa-upload mr-2"></i>Upload Media
            </a>
        </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.status-tab.active {
    border-color: #9333ea;
    color: #9333ea;
}
</style>

<script>
function filterByStatus(status) {
    const items = document.querySelectorAll('.media-item');
    const tabs = document.querySelectorAll('.status-tab');
    
    // Remove active class from all tabs
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Add active class to clicked tab
    event.target.classList.add('active');
    
    // Show/hide items based on status
    items.forEach(item => {
        if (status === 'all' || item.dataset.status === status) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endsection