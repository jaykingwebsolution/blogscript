@extends('admin.layout')

@section('title', 'Create Notification')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.notifications.index') }}" 
           class="text-gray-600 hover:text-gray-900 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create Notification</h1>
            <p class="text-gray-600">Send notifications to all users or specific roles</p>
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

    <form method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Notification Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green" 
                           placeholder="Enter notification title..."
                           required>
                </div>
                
                <!-- Message -->
                <div class="md:col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <textarea id="message" 
                              name="message" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green" 
                              placeholder="Enter notification message..."
                              required>{{ old('message') }}</textarea>
                </div>
                
                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type <span class="text-red-500">*</span>
                    </label>
                    <select id="type" 
                            name="type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green"
                            required>
                        <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                        <option value="feature" {{ old('type') == 'feature' ? 'selected' : '' }}>Feature Announcement</option>
                        <option value="trending_song" {{ old('type') == 'trending_song' ? 'selected' : '' }}>Trending Song</option>
                        <option value="trending_artist" {{ old('type') == 'trending_artist' ? 'selected' : '' }}>Trending Artist</option>
                    </select>
                </div>
                
                <!-- Action URL -->
                <div>
                    <label for="action_url" class="block text-sm font-medium text-gray-700 mb-2">
                        Action URL (optional)
                    </label>
                    <input type="url" 
                           id="action_url" 
                           name="action_url" 
                           value="{{ old('action_url') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green" 
                           placeholder="https://example.com/page">
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Targeting Options</h2>
            
            <div class="space-y-4">
                <!-- Global Notification -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_global" 
                               name="is_global" 
                               type="checkbox" 
                               value="1"
                               {{ old('is_global') ? 'checked' : '' }}
                               onchange="toggleTargetRoles(this.checked)"
                               class="focus:ring-spotify-green h-4 w-4 text-spotify-green border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_global" class="font-medium text-gray-700">Send to All Users</label>
                        <p class="text-gray-500">This notification will be sent to all registered users</p>
                    </div>
                </div>
                
                <!-- Target Roles -->
                <div id="target_roles_section" class="{{ old('is_global') ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Target User Roles
                    </label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input id="role_listener" 
                                   name="target_roles[]" 
                                   type="checkbox" 
                                   value="listener"
                                   {{ in_array('listener', old('target_roles', [])) ? 'checked' : '' }}
                                   class="focus:ring-spotify-green h-4 w-4 text-spotify-green border-gray-300 rounded">
                            <label for="role_listener" class="ml-2 text-sm text-gray-700">Listeners</label>
                        </div>
                        <div class="flex items-center">
                            <input id="role_artist" 
                                   name="target_roles[]" 
                                   type="checkbox" 
                                   value="artist"
                                   {{ in_array('artist', old('target_roles', [])) ? 'checked' : '' }}
                                   class="focus:ring-spotify-green h-4 w-4 text-spotify-green border-gray-300 rounded">
                            <label for="role_artist" class="ml-2 text-sm text-gray-700">Artists</label>
                        </div>
                        <div class="flex items-center">
                            <input id="role_record_label" 
                                   name="target_roles[]" 
                                   type="checkbox" 
                                   value="record_label"
                                   {{ in_array('record_label', old('target_roles', [])) ? 'checked' : '' }}
                                   class="focus:ring-spotify-green h-4 w-4 text-spotify-green border-gray-300 rounded">
                            <label for="role_record_label" class="ml-2 text-sm text-gray-700">Record Labels</label>
                        </div>
                        <div class="flex items-center">
                            <input id="role_admin" 
                                   name="target_roles[]" 
                                   type="checkbox" 
                                   value="admin"
                                   {{ in_array('admin', old('target_roles', [])) ? 'checked' : '' }}
                                   class="focus:ring-spotify-green h-4 w-4 text-spotify-green border-gray-300 rounded">
                            <label for="role_admin" class="ml-2 text-sm text-gray-700">Administrators</label>
                        </div>
                    </div>
                </div>
                
                <!-- Expiry Date -->
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">
                        Expiry Date (optional)
                    </label>
                    <input type="datetime-local" 
                           id="expires_at" 
                           name="expires_at" 
                           value="{{ old('expires_at') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">
                    <p class="text-sm text-gray-500 mt-1">Leave empty for permanent notification</p>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.notifications.index') }}" 
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-spotify-green text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                Create Notification
            </button>
        </div>
    </form>
</div>

<script>
function toggleTargetRoles(isGlobal) {
    const targetRolesSection = document.getElementById('target_roles_section');
    if (isGlobal) {
        targetRolesSection.classList.add('hidden');
        // Uncheck all role checkboxes
        const roleCheckboxes = document.querySelectorAll('input[name="target_roles[]"]');
        roleCheckboxes.forEach(checkbox => checkbox.checked = false);
    } else {
        targetRolesSection.classList.remove('hidden');
    }
}
</script>
@endsection