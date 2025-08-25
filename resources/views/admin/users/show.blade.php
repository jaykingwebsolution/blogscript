@extends('admin.layout')

@section('title', 'User Details')
@section('header', 'User Details')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.users.index') }}" class="text-primary hover:text-secondary mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md">
                <i class="fas fa-edit mr-1"></i>Edit
            </a>
            @if($user->id !== Auth::id())
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Name</label>
                    <p class="text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Email</label>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Role</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                           ($user->role === 'artist' ? 'bg-blue-100 text-blue-800' :
                           ($user->role === 'record_label' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Status</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $user->status === 'approved' ? 'bg-green-100 text-green-800' : ($user->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Member Since</label>
                    <p class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
                @if($user->approved_at)
                <div>
                    <label class="text-sm font-medium text-gray-500">Approved On</label>
                    <p class="text-gray-900">{{ $user->approved_at->format('M d, Y') }}</p>
                </div>
                @endif
            </div>

            @if($user->bio)
            <div class="mt-4">
                <label class="text-sm font-medium text-gray-500">Bio</label>
                <p class="text-gray-900 mt-1">{{ $user->bio }}</p>
            </div>
            @endif

            @if($user->artist_stage_name || $user->artist_genre)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <h4 class="font-medium text-gray-900 mb-2">Artist Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($user->artist_stage_name)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Stage Name</label>
                        <p class="text-gray-900">{{ $user->artist_stage_name }}</p>
                    </div>
                    @endif
                    @if($user->artist_genre)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Genre</label>
                        <p class="text-gray-900">{{ $user->artist_genre }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Recent Activity -->
        @if($user->createdMusic && $user->createdMusic->count() > 0)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Music</h3>
            <div class="space-y-3">
                @foreach($user->createdMusic->take(5) as $music)
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">{{ $music->title }}</p>
                        <p class="text-sm text-gray-500">{{ $music->artist_name }} • {{ $music->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $music->status === 'published' ? 'bg-green-100 text-green-800' : ($music->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($music->status) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Stats and Actions -->
    <div class="space-y-6">
        <!-- Statistics -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Music Created</span>
                    <span class="font-semibold text-gray-900">{{ $user->createdMusic->count() ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Media Uploaded</span>
                    <span class="font-semibold text-gray-900">{{ $user->media->count() ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Verification Requests</span>
                    <span class="font-semibold text-gray-900">{{ $user->verificationRequests->count() ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Trending Requests</span>
                    <span class="font-semibold text-gray-900">{{ $user->trendingRequests->count() ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        @if($user->id !== Auth::id())
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                @if($user->status === 'pending')
                    <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-md"
                                onclick="return confirm('Are you sure you want to approve this user?')">
                            <i class="fas fa-check mr-2"></i>Approve User
                        </button>
                    </form>
                @endif
                
                @if($user->status !== 'suspended')
                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}">
                        @csrf
                        <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 rounded-md"
                                onclick="return confirm('Are you sure you want to suspend this user?')">
                            <i class="fas fa-ban mr-2"></i>Suspend User
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-md"
                                onclick="return confirm('Are you sure you want to reactivate this user?')">
                            <i class="fas fa-check mr-2"></i>Reactivate User
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endif

        <!-- Subscription Info -->
        @if($user->subscription)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Subscription</h3>
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Plan</span>
                    <span class="font-semibold text-gray-900">{{ $user->subscription->plan->name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Status</span>
                    <span class="text-xs px-2 py-1 rounded-full {{ $user->subscription->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($user->subscription->status ?? 'Inactive') }}
                    </span>
                </div>
                @if($user->subscription->expires_at)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Expires</span>
                    <span class="text-sm text-gray-900">{{ $user->subscription->expires_at->format('M d, Y') }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection