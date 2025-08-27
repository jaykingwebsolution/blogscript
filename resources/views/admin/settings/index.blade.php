@extends('admin.layout')

@section('title', 'Site Settings - Admin Panel')
@section('header', 'Site Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-white mb-2">Site Settings</h2>
            <p class="text-spotify-light-gray">Manage your site's SEO, logo, and appearance settings</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-spotify-green bg-opacity-20 border border-spotify-green text-spotify-green-light px-6 py-4 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-900 bg-opacity-20 border border-red-500 text-red-400 px-6 py-4 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Site Information -->
            <div class="bg-spotify-gray rounded-lg border border-spotify-dark-gray">
                <div class="px-6 py-4 border-b border-spotify-dark-gray">
                    <h3 class="text-lg leading-6 font-medium text-white">Basic Site Information</h3>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div>
                        <label for="site_title" class="block text-sm font-medium text-white">Site Title</label>
                        <input type="text" name="site_title" id="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" 
                               class="mt-1 block w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_logo" class="block text-sm font-medium text-white">Site Logo</label>
                            @if(isset($settings['site_logo']) && $settings['site_logo'])
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo" class="h-16 w-auto">
                                    <button type="button" onclick="removeFile('logo')" class="mt-2 text-sm text-red-400 hover:text-red-300">Remove Logo</button>
                                </div>
                            @endif
                            <input type="file" name="site_logo" id="site_logo" accept="image/*" 
                                   class="mt-1 block w-full text-sm text-spotify-light-gray file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-spotify-green file:text-white hover:file:bg-spotify-green-light">
                            <p class="mt-1 text-xs text-spotify-light-gray">Max 2MB, recommended size: 200x50px</p>
                        </div>

                        <div>
                            <label for="site_favicon" class="block text-sm font-medium text-white">Favicon</label>
                            @if(isset($settings['site_favicon']) && $settings['site_favicon'])
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Current Favicon" class="h-8 w-8">
                                    <button type="button" onclick="removeFile('favicon')" class="mt-2 text-sm text-red-400 hover:text-red-300">Remove Favicon</button>
                                </div>
                            @endif
                            <input type="file" name="site_favicon" id="site_favicon" accept="image/*" 
                                   class="mt-1 block w-full text-sm text-spotify-light-gray file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-spotify-green file:text-white hover:file:bg-spotify-green-light">
                            <p class="mt-1 text-xs text-spotify-light-gray">Max 512KB, recommended size: 32x32px or 64x64px</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="bg-spotify-gray rounded-lg border border-spotify-dark-gray">
                <div class="px-6 py-4 border-b border-spotify-dark-gray">
                    <h3 class="text-lg leading-6 font-medium text-white">SEO Settings</h3>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="seo_enabled" id="seo_enabled" 
                               {{ (old('seo_enabled', $settings['seo_enabled'] ?? false)) ? 'checked' : '' }}
                               class="h-4 w-4 text-spotify-green focus:ring-spotify-green border-spotify-gray rounded">
                        <label for="seo_enabled" class="ml-3 text-sm font-medium text-white">Enable SEO optimization</label>
                    </div>

                    <div>
                        <label for="site_meta_description" class="block text-sm font-medium text-white">Meta Description</label>
                        <textarea name="site_meta_description" id="site_meta_description" rows="3" maxlength="160"
                                  class="mt-1 block w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">{{ old('site_meta_description', $settings['site_meta_description'] ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-spotify-light-gray">Max 160 characters for optimal SEO</p>
                    </div>

                    <div>
                        <label for="site_keywords" class="block text-sm font-medium text-white">Meta Keywords</label>
                        <input type="text" name="site_keywords" id="site_keywords" value="{{ old('site_keywords', $settings['site_keywords'] ?? '') }}"
                               class="mt-1 block w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">
                        <p class="mt-1 text-xs text-spotify-light-gray">Separate keywords with commas</p>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="bg-spotify-gray rounded-lg border border-spotify-dark-gray">
                <div class="px-6 py-4 border-b border-spotify-dark-gray">
                    <h3 class="text-lg leading-6 font-medium text-white">Social Media Links</h3>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="social_facebook" class="block text-sm font-medium text-white">Facebook URL</label>
                            <input type="url" name="social_facebook" id="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"
                                   class="mt-1 block w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">
                        </div>
                        
                        <div>
                            <label for="social_twitter" class="block text-sm font-medium text-white">Twitter URL</label>
                            <input type="url" name="social_twitter" id="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}"
                                   class="mt-1 block w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">
                        </div>
                        
                        <div>
                            <label for="social_instagram" class="block text-sm font-medium text-white">Instagram URL</label>
                            <input type="url" name="social_instagram" id="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"
                                   class="mt-1 block w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">
                        </div>
                        
                        <div>
                            <label for="social_youtube" class="block text-sm font-medium text-white">YouTube URL</label>
                            <input type="url" name="social_youtube" id="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}"
                                   class="mt-1 block w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="bg-spotify-gray rounded-lg border border-spotify-dark-gray">
                <div class="px-6 py-4 border-b border-spotify-dark-gray">
                    <h3 class="text-lg leading-6 font-medium text-white">Basic Page Content</h3>
                    <p class="text-sm text-spotify-light-gray mt-1">
                        Manage About and Contact page content. Legal pages are managed in
                        @if (Route::has('admin.pages.index'))
                            <a href="{{ route('admin.pages.index') }}" class="text-spotify-green hover:text-spotify-green-light underline">DMCA / Policy Pages</a>
                        @else
                            DMCA / Policy Pages
                        @endif
                        section.
                    </p>
                </div>
                <div class="px-6 py-4 space-y-6">
                    <div>
                        <label for="about_content" class="block text-sm font-medium text-white mb-2">About Page Content</label>
                        <textarea name="about_content" id="about_content" rows="8" 
                                  class="w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">{{ old('about_content', $settings['about_content'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="contact_content" class="block text-sm font-medium text-white mb-2">Contact Page Content</label>
                        <textarea name="contact_content" id="contact_content" rows="6" 
                                  class="w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">{{ old('contact_content', $settings['contact_content'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="footer_copyright" class="block text-sm font-medium text-white">Footer Copyright Text</label>
                        <input type="text" name="footer_copyright" id="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}"
                               class="mt-1 block w-full bg-spotify-dark-gray border-spotify-gray text-white rounded-md shadow-sm focus:ring-spotify-green focus:border-spotify-green">
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-spotify-green hover:bg-spotify-green-light text-white text-base font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-spotify-green transition-colors">
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