@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Welcome, {{ auth()->user()->name }}!</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Profile Card -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium">Profile</p>
                                <p class="text-xs opacity-75">{{ ucfirst(auth()->user()->role) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.profile') }}" class="mt-4 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded text-sm transition-colors">
                            Edit Profile
                        </a>
                    </div>

                    <!-- Subscription Card -->
                    <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg p-6 text-white">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium">Subscription</p>
                                <p class="text-xs opacity-75">
                                    @if(auth()->user()->hasActiveSubscription())
                                        {{ ucfirst(auth()->user()->subscription->plan_name) }} Plan
                                    @else
                                        Free Plan
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.subscription') }}" class="mt-4 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded text-sm transition-colors">
                            Manage
                        </a>
                    </div>

                    @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                    <!-- Music Upload Card -->
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg p-6 text-white">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium">Music</p>
                                <p class="text-xs opacity-75">Upload & Manage</p>
                            </div>
                        </div>
                        <a href="{{ route('artist.music.index') }}" class="mt-4 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded text-sm transition-colors">
                            My Music
                        </a>
                    </div>

                    <!-- Verification Card -->
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-600 rounded-lg p-6 text-white">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium">Verification</p>
                                <p class="text-xs opacity-75">
                                    @if(auth()->user()->isVerified())
                                        Verified ✓
                                    @else
                                        Apply Now
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.verification') }}" class="mt-4 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded text-sm transition-colors">
                            View Status
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('dashboard.profile') }}" class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Update Profile</span>
                        </a>

                        @if(auth()->user()->isArtist() || auth()->user()->isRecordLabel())
                        <a href="{{ route('artist.music.create') }}" class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Upload Music</span>
                        </a>
                        @endif

                        <a href="{{ route('dashboard.subscription') }}" class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Upgrade Plan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection