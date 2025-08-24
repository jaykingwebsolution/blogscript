@extends('admin.layout')

@section('title', 'User Management')
@section('header', 'User Management')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-900">All Users</h2>
    <p class="text-sm text-gray-600">Manage user accounts and approval status</p>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-700">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'editor' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->status === 'approved' ? 'bg-green-100 text-green-800' : ($user->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($user->id !== Auth::id())
                            <div class="flex space-x-2">
                                @if($user->status === 'pending')
                                    <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900"
                                                onclick="return confirm('Are you sure you want to approve this user?')">
                                            Approve
                                        </button>
                                    </form>
                                @endif
                                
                                @if($user->status !== 'suspended')
                                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to suspend this user?')">
                                            Suspend
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900"
                                                onclick="return confirm('Are you sure you want to reactivate this user?')">
                                            Reactivate
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400">Current User</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($users) && method_exists($users, 'links'))
    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endif
@endsection