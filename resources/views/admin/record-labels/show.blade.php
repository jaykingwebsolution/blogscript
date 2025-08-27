@extends('admin.layout')

@section('title', 'Record Label Details')

@section('header', 'Record Label Details')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.record-labels.index') }}" class="w-10 h-10 bg-spotify-gray rounded-lg flex items-center justify-center hover:bg-spotify-light-gray transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $recordLabel->name }}</h1>
                    <p class="text-spotify-light-gray mt-1">Record label details and statistics</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.record-labels.edit', $recordLabel) }}" 
                   class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                @if($recordLabel->status === 'pending')
                    <form method="POST" action="{{ route('admin.record-labels.approve', $recordLabel->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Approve
                        </button>
                    </form>
                @elseif($recordLabel->status === 'approved')
                    <form method="POST" action="{{ route('admin.record-labels.suspend', $recordLabel->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                            </svg>
                            Suspend
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Banner -->
    @php
        $statusConfig = [
            'approved' => ['color' => 'bg-green-900 border-green-500 text-green-400', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'message' => 'This record label is approved and active.'],
            'pending' => ['color' => 'bg-yellow-900 border-yellow-500 text-yellow-400', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'message' => 'This record label is pending approval.'],
            'suspended' => ['color' => 'bg-red-900 border-red-500 text-red-400', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728', 'message' => 'This record label is suspended.']
        ];
        $config = $statusConfig[$recordLabel->status] ?? $statusConfig['pending'];
    @endphp
    <div class="{{ $config['color'] }} bg-opacity-20 border px-6 py-4 rounded-lg mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
            </svg>
            <div>
                <p class="font-semibold">{{ ucfirst($recordLabel->status) }} Status</p>
                <p class="text-sm">{{ $config['message'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <!-- Basic Information Card -->
            <div class="bg-spotify-gray rounded-xl border border-spotify-gray p-6 mb-6">
                <h2 class="text-xl font-semibold text-white mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-spotify-light-gray mb-1">Label Name</label>
                        <p class="text-white text-lg">{{ $recordLabel->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-spotify-light-gray mb-1">Email</label>
                        <p class="text-white">{{ $recordLabel->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-spotify-light-gray mb-1">Member Since</label>
                        <p class="text-white">{{ $recordLabel->created_at->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-spotify-light-gray mb-1">Last Updated</label>
                        <p class="text-white">{{ $recordLabel->updated_at->format('F j, Y g:i A') }}</p>
                    </div>
                    @if($recordLabel->approved_at)
                        <div>
                            <label class="block text-sm font-medium text-spotify-light-gray mb-1">Approved Date</label>
                            <p class="text-white">{{ $recordLabel->approved_at->format('F j, Y g:i A') }}</p>
                        </div>
                    @endif
                    @if($recordLabel->approvedBy)
                        <div>
                            <label class="block text-sm font-medium text-spotify-light-gray mb-1">Approved By</label>
                            <p class="text-white">{{ $recordLabel->approvedBy->name }}</p>
                        </div>
                    @endif
                </div>
                
                @if($recordLabel->bio)
                    <div class="mt-6 pt-6 border-t border-spotify-light-gray">
                        <label class="block text-sm font-medium text-spotify-light-gray mb-2">Description</label>
                        <p class="text-white leading-relaxed">{{ $recordLabel->bio }}</p>
                    </div>
                @endif
            </div>

            <!-- Social Links Card -->
            @if($recordLabel->social_links && array_filter($recordLabel->social_links))
                <div class="bg-spotify-gray rounded-xl border border-spotify-gray p-6 mb-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Social Links</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($recordLabel->social_links as $platform => $url)
                            @if($url)
                                <div class="flex items-center space-x-3 p-3 bg-spotify-black rounded-lg">
                                    <div class="w-8 h-8 bg-spotify-green rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            @if($platform === 'website')
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            @elseif($platform === 'instagram')
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            @else
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-spotify-light-gray">{{ ucfirst($platform) }}</p>
                                        <a href="{{ $url }}" target="_blank" class="text-spotify-green hover:text-spotify-green-light text-sm break-all">{{ $url }}</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Music Statistics Card -->
            <div class="bg-spotify-gray rounded-xl border border-spotify-gray p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Music Catalog</h2>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-spotify-green bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-spotify-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-2">{{ $recordLabel->total_music ?? 0 }}</p>
                    <p class="text-spotify-light-gray">Total Tracks Published</p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Profile Picture Card -->
            <div class="bg-spotify-gray rounded-xl border border-spotify-gray p-6 mb-6">
                <h2 class="text-xl font-semibold text-white mb-4">Profile Picture</h2>
                <div class="text-center">
                    @if($recordLabel->profile_picture)
                        <img src="{{ asset('storage/' . $recordLabel->profile_picture) }}" alt="{{ $recordLabel->name }}" class="w-32 h-32 rounded-lg object-cover mx-auto">
                    @else
                        <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mx-auto">
                            <span class="text-white font-bold text-4xl">{{ strtoupper(substr($recordLabel->name, 0, 2)) }}</span>
                        </div>
                    @endif
                    <p class="text-spotify-light-gray text-sm mt-3">
                        @if($recordLabel->profile_picture)
                            Profile picture uploaded
                        @else
                            No profile picture uploaded
                        @endif
                    </p>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-spotify-gray rounded-xl border border-spotify-gray p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.record-labels.edit', $recordLabel) }}" 
                       class="w-full bg-spotify-black text-white px-4 py-3 rounded-lg hover:bg-spotify-light-gray transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Details
                    </a>
                    
                    @if($recordLabel->status === 'pending')
                        <form method="POST" action="{{ route('admin.record-labels.approve', $recordLabel->id) }}">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Approve Label
                            </button>
                        </form>
                    @elseif($recordLabel->status === 'approved')
                        <form method="POST" action="{{ route('admin.record-labels.suspend', $recordLabel->id) }}">
                            @csrf
                            <button type="submit" class="w-full bg-orange-600 text-white px-4 py-3 rounded-lg hover:bg-orange-700 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                </svg>
                                Suspend Label
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.record-labels.destroy', $recordLabel) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this record label? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Label
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection