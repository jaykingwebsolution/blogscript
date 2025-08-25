@extends('admin.layout')

@section('title', 'User Management')
@section('header', 'User Management')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">All Users</h2>
            <p class="text-sm text-gray-600">Manage user accounts and approval status</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md">
            <i class="fas fa-plus mr-2"></i>Add User
        </a>
    </div>
</div>

<!-- Filter and Search -->
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
        <div>
            <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">All Roles</option>
                <option value="listener" {{ request('role') == 'listener' ? 'selected' : '' }}>Listener</option>
                <option value="artist" {{ request('role') == 'artist' ? 'selected' : '' }}>Artist</option>
                <option value="record_label" {{ request('role') == 'record_label' ? 'selected' : '' }}>Record Label</option>
                <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md">
                Filter
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    @if($user->artist_stage_name)
                                        <div class="text-xs text-gray-500">{{ $user->artist_stage_name }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            <div class="text-xs text-gray-500">{{ $user->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                   ($user->role === 'artist' ? 'bg-blue-100 text-blue-800' :
                                   ($user->role === 'record_label' ? 'bg-purple-100 text-purple-800' :
                                   ($user->role === 'editor' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))) }}">
                                {{ ucwords(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $user->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($user->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                            @if($user->approved_at)
                                <div class="text-xs text-gray-500 mt-1">{{ $user->approved_at->diffForHumans() }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center space-x-4">
                                <div class="text-center">
                                    <div class="font-medium text-gray-900">{{ $user->created_music_count ?? 0 }}</div>
                                    <div class="text-xs">Music</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium text-gray-900">{{ $user->media_count ?? 0 }}</div>
                                    <div class="text-xs">Media</div>
                                </div>
                                @if($user->subscription)
                                <div class="text-center">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mx-auto"></div>
                                    <div class="text-xs">Sub</div>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="text-primary hover:text-secondary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($user->id !== Auth::id())
                                    @if($user->status === 'pending')
                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Approve"
                                                    onclick="return confirm('Are you sure you want to approve this user?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($user->status !== 'suspended')
                                        <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Suspend"
                                                    onclick="return confirm('Are you sure you want to suspend this user?')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Reactivate"
                                                    onclick="return confirm('Are you sure you want to reactivate this user?')">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(!$user->isAdmin() || Auth::user()->isAdmin())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-gray-400" title="Current User">
                                        <i class="fas fa-user"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-users text-3xl mb-2"></i>
                                <p>No users found.</p>
                                @if(request()->hasAny(['search', 'role', 'status']))
                                    <p class="text-sm mt-1">Try adjusting your filters.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if(isset($users) && method_exists($users, 'links'))
    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>
@endif

<!-- Quick Stats -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-600"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Approved</p>
                <p class="text-lg font-semibold">{{ $users->where('status', 'approved')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-lg font-semibold">{{ $users->where('status', 'pending')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-ban text-red-600"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Suspended</p>
                <p class="text-lg font-semibold">{{ $users->where('status', 'suspended')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-blue-600"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600">Total</p>
                <p class="text-lg font-semibold">{{ $users->total() ?? $users->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection