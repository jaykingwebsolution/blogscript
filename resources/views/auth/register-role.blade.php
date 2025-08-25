@extends('layouts.app')

@section('title', 'Register as ' . ucfirst(str_replace('_', ' ', $role)) . ' - Music Platform')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="w-16 h-16 bg-{{ $role === 'listener' ? 'blue' : ($role === 'artist' ? 'purple' : 'indigo') }}-100 dark:bg-{{ $role === 'listener' ? 'blue' : ($role === 'artist' ? 'purple' : 'indigo') }}-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                @if($role === 'listener')
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                </svg>
                @elseif($role === 'artist')
                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"/>
                </svg>
                @else
                <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 6a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd"/>
                </svg>
                @endif
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Join as {{ ucfirst(str_replace('_', ' ', $role)) }}
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                @if($role === 'listener')
                    Start streaming and creating playlists today
                @elseif($role === 'artist')
                    Share your music with the world
                @else
                    Manage artists and distribute music professionally
                @endif
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 py-8 px-6 shadow-lg rounded-lg">
            <form method="POST" action="{{ route('register.role.submit', $role) }}" class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $role === 'record_label' ? 'Label Name' : 'Full Name' }} *
                    </label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           value="{{ old('name') }}" 
                           required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                           placeholder="{{ $role === 'record_label' ? 'Your record label name' : 'Your full name' }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Artist-specific fields -->
                @if($role === 'artist')
                <div>
                    <label for="artist_stage_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Stage Name *
                    </label>
                    <input id="artist_stage_name" 
                           name="artist_stage_name" 
                           type="text" 
                           value="{{ old('artist_stage_name') }}" 
                           required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Your stage/artist name">
                    @error('artist_stage_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="artist_genre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Primary Genre *
                    </label>
                    <input id="artist_genre" 
                           name="artist_genre" 
                           type="text" 
                           value="{{ old('artist_genre') }}" 
                           required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                           placeholder="e.g., Afrobeats, Hip Hop, R&B">
                    @error('artist_genre')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Record Label specific fields -->
                @if($role === 'record_label')
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Website
                    </label>
                    <input id="website" 
                           name="website" 
                           type="url" 
                           value="{{ old('website') }}" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                           placeholder="https://yourrecordlabel.com">
                    @error('website')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Bio for Artist and Record Label -->
                @if(in_array($role, ['artist', 'record_label']))
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $role === 'artist' ? 'Artist Bio' : 'About Your Label' }} {{ $role === 'record_label' ? '*' : '' }}
                    </label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="4" 
                              {{ $role === 'record_label' ? 'required' : '' }}
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-{{ $role === 'artist' ? 'purple' : 'indigo' }}-500 focus:border-{{ $role === 'artist' ? 'purple' : 'indigo' }}-500 dark:bg-gray-700 dark:text-white"
                              placeholder="{{ $role === 'artist' ? 'Tell us about your musical journey and style...' : 'Describe your record label and what you specialize in...' }}">{{ old('bio') }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Address *
                    </label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           value="{{ old('email') }}" 
                           required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                           placeholder="your@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password *
                    </label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Choose a strong password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Confirm Password *
                    </label>
                    <input id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           required 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Confirm your password">
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input id="terms" 
                           name="terms" 
                           type="checkbox" 
                           required 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
                    <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400">Privacy Policy</a>
                    </label>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Approval Notice for Artists and Labels -->
                @if(in_array($role, ['artist', 'record_label']))
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                Account Approval Required
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                <p>Your {{ $role === 'artist' ? 'artist' : 'record label' }} account will be reviewed by our team. You'll receive an email notification once approved.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-white bg-{{ $role === 'listener' ? 'blue' : ($role === 'artist' ? 'purple' : 'indigo') }}-600 hover:bg-{{ $role === 'listener' ? 'blue' : ($role === 'artist' ? 'purple' : 'indigo') }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $role === 'listener' ? 'blue' : ($role === 'artist' ? 'purple' : 'indigo') }}-500 font-medium transition-colors">
                        {{ $role === 'listener' ? 'Create Account' : 'Submit for Approval' }}
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Want to join as a different role?
            </p>
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 font-medium">
                Choose Different Role
            </a>
        </div>
    </div>
</div>
@endsection