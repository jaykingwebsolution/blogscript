@extends('layouts.app')

@section('title', 'Site Settings - Admin Panel')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Site Settings</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your site's SEO, content, and appearance settings</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-md">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Basic Site Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Basic Site Information</h3>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div>
                        <label for="site_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site Title</label>
                        <input type="text" name="site_title" id="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" 
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site Logo</label>
                            @if(isset($settings['site_logo']) && $settings['site_logo'])
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo" class="h-16 w-auto">
                                    <button type="button" onclick="removeFile('logo')" class="mt-2 text-sm text-red-600 hover:text-red-800">Remove Logo</button>
                                </div>
                            @endif
                            <input type="file" name="site_logo" id="site_logo" accept="image/*" 
                                   class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Max 2MB, recommended size: 200x50px</p>
                        </div>

                        <div>
                            <label for="site_favicon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Favicon</label>
                            @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Current Favicon" class="h-8 w-8">
                                    <button type="button" onclick="removeFile('favicon')" class="mt-2 text-sm text-red-600 hover:text-red-800">Remove Favicon</button>
                                </div>
                            @endif
                            <input type="file" name="site_favicon" id="site_favicon" accept="image/*" 
                                   class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Max 512KB, recommended size: 32x32px or 64x64px</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">SEO Settings</h3>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="seo_enabled" id="seo_enabled" 
                               {{ (old('seo_enabled', $settings['seo_enabled'] ?? false)) ? 'checked' : '' }}
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="seo_enabled" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Enable SEO optimization</label>
                    </div>

                    <div>
                        <label for="site_meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                        <textarea name="site_meta_description" id="site_meta_description" rows="3" maxlength="160"
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('site_meta_description', $settings['site_meta_description'] ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Max 160 characters for optimal SEO</p>
                    </div>

                    <div>
                        <label for="site_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Keywords</label>
                        <input type="text" name="site_keywords" id="site_keywords" value="{{ old('site_keywords', $settings['site_keywords'] ?? '') }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Separate keywords with commas</p>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Social Media Links</h3>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="social_facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facebook URL</label>
                            <input type="url" name="social_facebook" id="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                        
                        <div>
                            <label for="social_twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Twitter URL</label>
                            <input type="url" name="social_twitter" id="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                        
                        <div>
                            <label for="social_instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instagram URL</label>
                            <input type="url" name="social_instagram" id="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                        
                        <div>
                            <label for="social_youtube" class="block text-sm font-medium text-gray-700 dark:text-gray-300">YouTube URL</label>
                            <input type="url" name="social_youtube" id="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Page Content</h3>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div>
                        <label for="about_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">About Page Content</label>
                        <textarea name="about_content" id="about_content" rows="8" 
                                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('about_content', $settings['about_content'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="contact_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Page Content</label>
                        <textarea name="contact_content" id="contact_content" rows="6" 
                                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('contact_content', $settings['contact_content'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="privacy_policy_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Privacy Policy Content</label>
                        <textarea name="privacy_policy_content" id="privacy_policy_content" rows="8" 
                                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('privacy_policy_content', $settings['privacy_policy_content'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="dmca_policy_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">DMCA Policy Content</label>
                        <textarea name="dmca_policy_content" id="dmca_policy_content" rows="8" 
                                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('dmca_policy_content', $settings['dmca_policy_content'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="footer_copyright" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Footer Copyright Text</label>
                        <input type="text" name="footer_copyright" id="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Settings
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function removeFile(type) {
    if (confirm('Are you sure you want to remove this file?')) {
        fetch('{{ route("admin.settings.remove-file") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: type })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error removing file: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error removing file');
        });
    }
}
</script>
@endsection