@extends('admin.layout')

@section('title', 'Record Labels Management')

@section('header', 'Record Labels Management')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-spotify-green rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Record Labels Management</h1>
                    <p class="text-spotify-light-gray mt-1">Manage record labels, their artists, and music catalog</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <a href="{{ route('admin.record-labels.create') }}" class="bg-spotify-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-spotify-green-light transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add New Record Label
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Total Record Labels</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_labels'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Active Labels</p>
                    <p class="text-3xl font-bold text-spotify-green">{{ $stats['active_labels'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-spotify-green rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Pending Approval</p>
                    <p class="text-3xl font-bold text-yellow-400">{{ $stats['pending_labels'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-spotify-light-gray text-sm">Total Artists</p>
                    <p class="text-3xl font-bold text-purple-400">{{ $stats['total_artists'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-spotify-gray rounded-xl p-6 border border-spotify-gray mb-6">
        <form method="GET" action="{{ route('admin.record-labels.index') }}">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search record labels..." 
                               class="bg-spotify-black border border-spotify-light-gray text-white px-4 py-2 rounded-lg pl-10 w-full sm:w-64">
                        <svg class="w-4 h-4 text-spotify-light-gray absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <select name="status" class="bg-spotify-black border border-spotify-light-gray text-white px-4 py-2 rounded-lg">
                        <option value="">All Statuses</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.record-labels.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Record Labels Table -->
    <div class="bg-spotify-gray rounded-xl border border-spotify-gray overflow-hidden">
        <div class="p-6 border-b border-spotify-light-gray">
            <h2 class="text-xl font-semibold text-white">Record Labels Directory</h2>
            <p class="text-spotify-light-gray text-sm mt-1">Manage all registered record labels on your platform</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-spotify-black">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-spotify-light-gray uppercase tracking-wider">
                            <input type="checkbox" class="rounded border-spotify-light-gray">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-spotify-light-gray uppercase tracking-wider">Label</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-spotify-light-gray uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-spotify-light-gray uppercase tracking-wider">Artists</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-spotify-light-gray uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-spotify-light-gray uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-spotify-light-gray uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-spotify-light-gray">
                    @forelse($recordLabels as $label)
                        <tr class="hover:bg-spotify-black transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="rounded border-spotify-light-gray" value="{{ $label->id }}">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                                        @if($label->profile_picture)
                                            <img src="{{ asset('storage/' . $label->profile_picture) }}" alt="{{ $label->name }}" class="w-full h-full rounded-lg object-cover">
                                        @else
                                            <span class="text-white font-semibold text-sm">{{ strtoupper(substr($label->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-white font-medium">{{ $label->name }}</div>
                                        <div class="text-spotify-light-gray text-sm">Est. {{ $label->created_at->format('Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-white">{{ $label->email }}</div>
                                @if($label->social_links && isset($label->social_links['website']))
                                    <div class="text-spotify-light-gray text-sm">
                                        <a href="{{ $label->social_links['website'] }}" target="_blank" class="hover:text-spotify-green">
                                            Website
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-white font-medium">{{ $label->total_music ?? 0 }}</div>
                                <div class="text-spotify-light-gray text-sm">tracks</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'approved' => 'bg-spotify-green bg-opacity-20 text-spotify-green',
                                        'pending' => 'bg-yellow-500 bg-opacity-20 text-yellow-400',
                                        'suspended' => 'bg-red-500 bg-opacity-20 text-red-400'
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$label->status] ?? 'bg-gray-500 bg-opacity-20 text-gray-400' }}">
                                    {{ ucfirst($label->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-spotify-light-gray">
                                {{ $label->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.record-labels.show', $label) }}" class="text-blue-400 hover:text-blue-300" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.record-labels.edit', $label) }}" class="text-yellow-400 hover:text-yellow-300" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($label->status === 'pending')
                                        <form method="POST" action="{{ route('admin.record-labels.approve', $label->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="text-green-400 hover:text-green-300" title="Approve">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @elseif($label->status === 'approved')
                                        <form method="POST" action="{{ route('admin.record-labels.suspend', $label->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="text-orange-400 hover:text-orange-300" title="Suspend">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.record-labels.destroy', $label) }}" style="display: inline;" 
                                          onsubmit="return confirm('Are you sure you want to delete this record label?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <div class="text-spotify-light-gray">
                                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <p class="text-lg font-medium mb-2">No record labels found</p>
                                    <p class="text-sm">
                                        @if(request('search') || request('status'))
                                            Try adjusting your search criteria or <a href="{{ route('admin.record-labels.index') }}" class="text-spotify-green hover:underline">clear filters</a>.
                                        @else
                                            Get started by <a href="{{ route('admin.record-labels.create') }}" class="text-spotify-green hover:underline">adding your first record label</a>.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-spotify-light-gray">
            <div class="flex items-center justify-between">
                <div class="text-spotify-light-gray text-sm">
                    Showing {{ $recordLabels->firstItem() ?? 0 }} to {{ $recordLabels->lastItem() ?? 0 }} of {{ $recordLabels->total() }} record labels
                </div>
                <div class="flex items-center space-x-2">
                    {{ $recordLabels->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection