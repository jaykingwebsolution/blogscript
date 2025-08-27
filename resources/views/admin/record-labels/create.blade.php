@extends('admin.layout')

@section('title', 'Add New Record Label')

@section('header', 'Add New Record Label')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.record-labels.index') }}" class="w-10 h-10 bg-spotify-gray rounded-lg flex items-center justify-center hover:bg-spotify-light-gray transition-colors">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">Add New Record Label</h1>
                <p class="text-spotify-light-gray mt-1">Register a new record label on the platform</p>
            </div>
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

    <!-- Form Card -->
    <div class="bg-spotify-gray rounded-xl border border-spotify-gray p-6">
        <form action="{{ route('admin.record-labels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-white mb-2">Label Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="Enter record label name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="contact@label.com">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-2">Password *</label>
                        <input type="password" id="password" name="password" required
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="Enter password">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-white mb-2">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="Confirm password">
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Additional Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="bio" class="block text-sm font-medium text-white mb-2">Bio/Description</label>
                        <textarea id="bio" name="bio" rows="4"
                                  class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                                  placeholder="Brief description of the record label">{{ old('bio') }}</textarea>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-white mb-2">Status</label>
                        <select id="status" name="status"
                                class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Social Links Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Social Links (Optional)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="social_links_website" class="block text-sm font-medium text-white mb-2">Website</label>
                        <input type="url" id="social_links_website" name="social_links[website]" value="{{ old('social_links.website') }}"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="https://www.label.com">
                    </div>
                    <div>
                        <label for="social_links_instagram" class="block text-sm font-medium text-white mb-2">Instagram</label>
                        <input type="url" id="social_links_instagram" name="social_links[instagram]" value="{{ old('social_links.instagram') }}"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="https://instagram.com/label">
                    </div>
                    <div>
                        <label for="social_links_twitter" class="block text-sm font-medium text-white mb-2">Twitter</label>
                        <input type="url" id="social_links_twitter" name="social_links[twitter]" value="{{ old('social_links.twitter') }}"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="https://twitter.com/label">
                    </div>
                    <div>
                        <label for="social_links_facebook" class="block text-sm font-medium text-white mb-2">Facebook</label>
                        <input type="url" id="social_links_facebook" name="social_links[facebook]" value="{{ old('social_links.facebook') }}"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="https://facebook.com/label">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-6 border-t border-spotify-light-gray">
                <div class="mb-4 sm:mb-0">
                    <p class="text-sm text-spotify-light-gray">* Required fields</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.record-labels.index') }}" 
                       class="px-6 py-3 bg-spotify-black text-white border border-spotify-light-gray rounded-lg hover:bg-spotify-gray transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-spotify-green text-white rounded-lg hover:bg-spotify-green-light transition-colors">
                        Create Record Label
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection