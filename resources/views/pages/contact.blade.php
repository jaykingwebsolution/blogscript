@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Contact Us</h1>
                <p class="text-xl text-gray-600 dark:text-gray-300">Get in touch with us for any questions, feedback, or collaboration opportunities</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Contact Form -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Send us a message</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-100 dark:bg-green-900/50 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                <input type="text" 
                                       id="subject" 
                                       name="subject" 
                                       value="{{ old('subject') }}" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('subject') border-red-500 @enderror">
                                @error('subject')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                <textarea id="message" 
                                          name="message" 
                                          rows="6" 
                                          required
                                          placeholder="Please describe your message in detail..."
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Dynamic Contact Information -->
                <div class="space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Contact Information</h2>
                        <div class="prose prose-gray dark:prose-invert">
                            {!! $content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection