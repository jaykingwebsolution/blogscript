@extends('admin.layout')

@section('title', 'Edit User')
@section('header', 'Edit User')

@section('content')
<div class="mb-6">
    <div class="flex items-center">
        <a href="{{ route('admin.users.index') }}" class="text-primary hover:text-secondary mr-4">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-xl font-semibold text-gray-900">Edit User: {{ $user->name }}</h2>
    </div>
</div>

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Info -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select id="role" name="role" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="listener" {{ old('role', $user->role) == 'listener' ? 'selected' : '' }}>Listener</option>
                    <option value="artist" {{ old('role', $user->role) == 'artist' ? 'selected' : '' }}>Artist</option>
                    <option value="record_label" {{ old('role', $user->role) == 'record_label' ? 'selected' : '' }}>Record Label</option>
                    @if(Auth::user()->isAdmin())
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    @endif
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status', $user->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
        </div>

        <!-- Artist-specific fields -->
        <div id="artist-fields" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6" 
             style="display: {{ in_array($user->role, ['artist', 'record_label']) ? 'block' : 'none' }};">
            <div>
                <label for="artist_stage_name" class="block text-sm font-medium text-gray-700 mb-2">Stage Name</label>
                <input type="text" id="artist_stage_name" name="artist_stage_name" value="{{ old('artist_stage_name', $user->artist_stage_name) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <div>
                <label for="artist_genre" class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
                <input type="text" id="artist_genre" name="artist_genre" value="{{ old('artist_genre', $user->artist_genre) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
        </div>

        <div class="mt-6">
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
            <textarea id="bio" name="bio" rows="4" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <!-- User Stats -->
        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">User Statistics</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary">{{ $user->createdMusic->count() ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Music Created</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-secondary">{{ $user->media->count() ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Media Uploaded</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $user->verificationRequests->count() ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Verification Requests</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $user->created_at->diffForHumans() }}</div>
                    <div class="text-sm text-gray-600">Member Since</div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md">
                Cancel
            </a>
            <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2 rounded-md">
                Update User
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('role').addEventListener('change', function() {
    const artistFields = document.getElementById('artist-fields');
    if (this.value === 'artist' || this.value === 'record_label') {
        artistFields.style.display = 'block';
    } else {
        artistFields.style.display = 'none';
    }
});
</script>
@endsection