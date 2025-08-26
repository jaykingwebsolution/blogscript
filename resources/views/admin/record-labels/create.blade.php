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

    <!-- TODO Notice -->
    <div class="bg-yellow-900 bg-opacity-20 border border-yellow-500 text-yellow-400 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                <p class="font-semibold">TODO: Implementation Required</p>
                <p class="text-sm">This record label creation form requires backend implementation, validation rules, and database integration.</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-spotify-gray rounded-xl border border-spotify-gray p-6">
        <form action="{{ route('admin.record-labels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="label_name" class="block text-sm font-medium text-white mb-2">Label Name *</label>
                        <input type="text" id="label_name" name="label_name" required
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="Enter record label name">
                    </div>
                    <div>
                        <label for="established_year" class="block text-sm font-medium text-white mb-2">Established Year</label>
                        <input type="number" id="established_year" name="established_year" min="1900" max="2024"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="2020">
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-white mb-2">Description</label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                                  placeholder="Brief description of the record label"></textarea>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-white mb-2">Contact Person *</label>
                        <input type="text" id="contact_name" name="contact_name" required
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="Full name">
                    </div>
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-white mb-2">Email Address *</label>
                        <input type="email" id="contact_email" name="contact_email" required
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="contact@label.com">
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-white mb-2">Phone Number</label>
                        <input type="tel" id="contact_phone" name="contact_phone"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="+1 234 567 8900">
                    </div>
                    <div>
                        <label for="website" class="block text-sm font-medium text-white mb-2">Website</label>
                        <input type="url" id="website" name="website"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="https://www.label.com">
                    </div>
                </div>
            </div>

            <!-- Business Details Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Business Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="business_type" class="block text-sm font-medium text-white mb-2">Business Type</label>
                        <select id="business_type" name="business_type"
                                class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none">
                            <option value="">Select business type</option>
                            <option value="independent">Independent Label</option>
                            <option value="major">Major Label</option>
                            <option value="subsidiary">Subsidiary</option>
                            <option value="distribution">Distribution Company</option>
                        </select>
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-medium text-white mb-2">Country</label>
                        <input type="text" id="country" name="country"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="United States">
                    </div>
                    <div>
                        <label for="tax_id" class="block text-sm font-medium text-white mb-2">Tax ID / Registration Number</label>
                        <input type="text" id="tax_id" name="tax_id"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="123-45-6789">
                    </div>
                    <div>
                        <label for="genres" class="block text-sm font-medium text-white mb-2">Primary Genres</label>
                        <input type="text" id="genres" name="genres"
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="Hip Hop, R&B, Pop (comma separated)">
                    </div>
                </div>
            </div>

            <!-- Logo Upload Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Brand Assets</h2>
                <div>
                    <label for="logo" class="block text-sm font-medium text-white mb-2">Logo</label>
                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-spotify-light-gray border-dashed rounded-lg hover:border-spotify-green transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-spotify-light-gray" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-spotify-light-gray">
                                <label for="logo" class="relative cursor-pointer rounded-md font-medium text-spotify-green hover:text-spotify-green-light focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="logo" name="logo" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-spotify-light-gray">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Settings Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">Account Settings</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-white mb-2">Username *</label>
                        <input type="text" id="username" name="username" required
                               class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none"
                               placeholder="unique_label_username">
                        <p class="text-xs text-spotify-light-gray mt-1">This will be used for login and public profile URL</p>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-white mb-2">Initial Status</label>
                        <select id="status" name="status"
                                class="w-full bg-spotify-black border border-spotify-light-gray text-white px-4 py-3 rounded-lg focus:border-spotify-green focus:outline-none">
                            <option value="pending">Pending Approval</option>
                            <option value="approved">Approved</option>
                            <option value="suspended">Suspended</option>
                        </select>
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