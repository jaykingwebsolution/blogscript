@extends('layouts.app')

@section('title', 'Verification Status')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Artist Verification</h1>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Current Status -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Verification Status</h2>
                    <div class="flex items-center">
                        @if(auth()->user()->isVerified())
                            <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-green-700 font-semibold">Verified Artist ✓</span>
                        @else
                            <svg class="w-6 h-6 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8 9.414l1.707 1.707a1 1 0 001.414-1.414L10.414 9l.707-.707a1 1 0 00-1.414-1.414L9 7.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-600">Not Verified</span>
                        @endif
                    </div>
                    
                    @if(!auth()->user()->isVerified())
                        <p class="mt-2 text-sm text-gray-600">
                            Get your blue checkmark to show your audience you're a legitimate artist.
                        </p>
                    @endif
                </div>

                @if(!auth()->user()->isVerified())
                    <!-- Application Form -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Apply for Verification</h2>
                        
                        @php
                            $hasPendingRequest = $requests->where('status', 'pending')->isNotEmpty();
                            $activeDays = auth()->user()->created_at->diffInDays(now());
                        @endphp

                        @if($activeDays < 30)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Account Too New</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>Your account must be active for at least 30 days before applying for verification. You've been active for {{ $activeDays }} days.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($hasPendingRequest)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Request Pending</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Your verification request is being reviewed. We'll notify you once a decision is made.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form method="POST" action="{{ route('dashboard.verification.store') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                        Why do you deserve verification? *
                                    </label>
                                    <textarea name="message" id="message" rows="4" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                                              placeholder="Tell us about your music career, achievements, social media following, or any other reasons why you should be verified...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-md transition-colors">
                                    Submit Verification Request
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                <!-- Request History -->
                @if($requests->isNotEmpty())
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Request History</h2>
                    <div class="space-y-4">
                        @foreach($requests as $request)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        <span class="ml-3 text-sm text-gray-500">
                                            {{ $request->created_at->format('M j, Y g:i A') }}
                                        </span>
                                    </div>
                                    
                                    <p class="mt-2 text-sm text-gray-700">{{ $request->message }}</p>
                                    
                                    @if($request->admin_notes && $request->status === 'rejected')
                                        <div class="mt-2 p-3 bg-red-50 rounded">
                                            <p class="text-sm text-red-800"><strong>Admin Response:</strong> {{ $request->admin_notes }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($request->reviewed_at)
                                        <p class="mt-1 text-xs text-gray-500">
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
                <div class="mt-8 bg-purple-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-purple-900 mb-4">Verification Benefits</h3>
                    <ul class="space-y-2 text-sm text-purple-800">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Blue checkmark badge on your profile
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Increased credibility and trust
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Higher search ranking
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Eligibility for trending features
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection