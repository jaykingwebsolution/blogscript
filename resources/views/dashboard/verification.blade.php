@extends('layouts.app')

@section('title', 'Verification Status - MusicStream')

@section('content')
<div class="min-h-screen bg-black text-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-900 via-purple-900 to-gray-900 px-8 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-br from-purple-500 to-blue-600 p-4 rounded-full">
                    @if(auth()->user()->isVerified())
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m5.414-4.414a2 2 0 00-2.828 0L10 11.172l-2.586-2.586a2 2 0 00-2.828 2.828l4 4a2 2 0 002.828 0l8-8a2 2 0 000-2.828z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <h1 class="text-4xl font-bold">
                        @if(Auth::user()->isArtist())
                            Artist Verification
                        @elseif(Auth::user()->isRecordLabel())
                            Record Label Verification
                        @else
                            Profile Verification
                        @endif
                    </h1>
                    <p class="text-gray-300 text-xl">Get your blue checkmark badge</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-8 py-8">
        @if(session('success'))
            <div class="bg-green-900/50 border border-green-500 text-green-300 px-6 py-4 rounded-lg mb-8">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-900/50 border border-red-500 text-red-300 px-6 py-4 rounded-lg mb-8">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Current Status Card -->
        <div class="bg-gray-900 rounded-xl p-8 border border-gray-800 mb-8">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Verification Status
            </h2>
            
            <div class="flex items-center">
                @if(auth()->user()->isVerified())
                    <div class="flex items-center bg-green-900/50 text-green-400 px-4 py-3 rounded-full">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xl font-bold">✓ Verified 
                            @if(Auth::user()->isArtist())
                                Artist
                            @elseif(Auth::user()->isRecordLabel())
                                Record Label
                            @endif
                        </span>
                    </div>
                @else
                    <div class="flex items-center bg-gray-800/50 text-gray-400 px-4 py-3 rounded-full">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8 9.414l1.707 1.707a1 1 0 001.414-1.414L10.414 9l.707-.707a1 1 0 00-1.414-1.414L9 7.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xl font-bold">Not Verified</span>
                    </div>
                @endif
            </div>
            
            @if(!auth()->user()->isVerified())
                <p class="mt-4 text-gray-300">
                    Get your blue checkmark to show your audience you're legitimate and gain access to exclusive features.
                </p>
            @endif
        </div>

        @if(!auth()->user()->isVerified())
            <!-- Application Form -->
            <div class="bg-gray-900 rounded-xl p-8 border border-gray-800 mb-8">
                <h2 class="text-2xl font-bold mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                    Apply for Verification
                </h2>
                
                @php
                    $hasPendingRequest = $requests->where('status', 'pending')->isNotEmpty();
                    $activeDays = auth()->user()->created_at->diffInDays(now());
                @endphp

                @if($activeDays < 30)
                    <div class="bg-yellow-900/50 border border-yellow-500 rounded-lg p-6 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold text-yellow-400">Account Too New</h3>
                                <div class="mt-2 text-yellow-300">
                                    <p>Your account must be active for at least 30 days before applying for verification. You've been active for {{ $activeDays }} days.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($hasPendingRequest)
                    <div class="bg-blue-900/50 border border-blue-500 rounded-lg p-6 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold text-blue-400">Request Pending</h3>
                                <div class="mt-2 text-blue-300">
                                    <p>Your verification request is being reviewed. We'll notify you once a decision is made.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <form method="POST" action="{{ route('dashboard.verification.store') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="message" class="block text-lg font-semibold text-gray-300 mb-3">
                                Why do you deserve verification? *
                            </label>
                            <textarea name="message" id="message" rows="6" required
                                      class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Tell us about your music career, achievements, social media following, notable releases, industry recognition, or any other reasons why you should be verified...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="bg-gradient-to-r from-purple-500 to-blue-600 hover:from-purple-600 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-lg transition-all transform hover:scale-105 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Submit Verification Request
                        </button>
                    </form>
                @endif
            </div>
        @endif

        <!-- Request History -->
        @if($requests->isNotEmpty())
        <div class="bg-gray-900 rounded-xl p-8 border border-gray-800 mb-8">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l.09 8.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Request History
            </h2>
            <div class="space-y-4">
                @foreach($requests as $request)
                <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                    {{ $request->status === 'approved' ? 'bg-green-900/50 text-green-400 border border-green-500' : '' }}
                                    {{ $request->status === 'pending' ? 'bg-yellow-900/50 text-yellow-400 border border-yellow-500' : '' }}
                                    {{ $request->status === 'rejected' ? 'bg-red-900/50 text-red-400 border border-red-500' : '' }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                                <span class="ml-4 text-sm text-gray-400">
                                    {{ $request->created_at->format('M j, Y g:i A') }}
                                </span>
                            </div>
                            
                            <p class="text-gray-300 mb-3">{{ $request->message }}</p>
                            
                            @if($request->admin_notes && $request->status === 'rejected')
                                <div class="mt-4 p-4 bg-red-900/30 border border-red-500/50 rounded-lg">
                                    <p class="text-red-300"><strong>Admin Response:</strong> {{ $request->admin_notes }}</p>
                                </div>
                            @endif
                            
                            @if($request->reviewed_at)
                                <p class="mt-2 text-xs text-gray-500">
                                    Reviewed {{ $request->reviewed_at->format('M j, Y g:i A') }}
                                    @if($request->reviewer)
                                        by {{ $request->reviewer->name }}
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Verification Benefits -->
        <div class="bg-gradient-to-br from-purple-900/50 to-blue-900/50 rounded-xl p-8 border border-purple-500/50">
            <h3 class="text-2xl font-bold text-purple-300 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Verification Benefits
            </h3>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-purple-200">
                <li class="flex items-center bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-purple-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Blue checkmark badge on your profile
                </li>
                <li class="flex items-center bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-purple-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Increased credibility and trust
                </li>
                <li class="flex items-center bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-purple-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Higher search ranking priority
                </li>
                <li class="flex items-center bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-purple-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Eligibility for trending features
                </li>
                <li class="flex items-center bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-purple-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Enhanced distribution options
                </li>
                <li class="flex items-center bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-purple-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Priority customer support
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection