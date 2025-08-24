@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary/10 to-accent/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">About BlogScript</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Your premier destination for the latest in music, entertainment news, and cultural content from Nigeria and beyond.</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                <div class="prose text-gray-700 space-y-4">
                    <p>Founded in 2024, BlogScript emerged from a passion for sharing the rich musical heritage and vibrant entertainment culture of Nigeria with the world. We recognized the need for a platform that not only showcases emerging and established artists but also keeps our audience informed about the latest trends in entertainment.</p>
                    
                    <p>Our team consists of dedicated music enthusiasts, journalists, and content creators who are committed to delivering high-quality content that resonates with our diverse audience. From the bustling streets of Lagos to the creative hubs of Abuja, we capture the essence of Nigerian entertainment culture.</p>
                    
                    <p>What started as a small blog has grown into a comprehensive platform featuring music releases, artist interviews, industry news, and exclusive content that you won't find anywhere else.</p>
                </div>
            </div>
            <div class="relative">
                <img src="/images/about-hero.jpg" alt="About BlogScript" class="rounded-lg shadow-lg w-full h-96 object-cover" onerror="this.src='/images/default-about.jpg'">
            </div>
        </div>

        <!-- Mission & Vision -->
        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-primary mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900">Our Mission</h3>
                </div>
                <p class="text-gray-700">To provide a comprehensive platform that celebrates African music and entertainment, connecting artists with their audience while keeping everyone informed about the latest industry developments.</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-accent mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900">Our Vision</h3>
                </div>
                <p class="text-gray-700">To become the leading digital destination for African entertainment content, fostering a global community that appreciates and supports the continent's rich cultural creativity.</p>
            </div>
        </div>

        <!-- What We Offer -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">What We Offer</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm12-3c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Music Content</h3>
                    <p class="text-gray-600">Latest music releases, albums, mixtapes, and exclusive tracks from both emerging and established artists.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-accent/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Entertainment News</h3>
                    <p class="text-gray-600">Breaking news, celebrity updates, industry insights, and exclusive interviews with your favorite stars.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Video Content</h3>
                    <p class="text-gray-600">Music videos, behind-the-scenes footage, artist interviews, and exclusive video content.</p>
                </div>
            </div>
        </div>

        <!-- Values -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Our Core Values</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">Authenticity</h3>
                    <p class="text-gray-600 text-sm">We stay true to our roots and present genuine content that reflects our culture.</p>
                </div>
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">Quality</h3>
                    <p class="text-gray-600 text-sm">We maintain high standards in everything we publish, from music to news content.</p>
                </div>
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">Innovation</h3>
                    <p class="text-gray-600 text-sm">We embrace new technologies and creative approaches to content delivery.</p>
                </div>
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">Community</h3>
                    <p class="text-gray-600 text-sm">We foster a supportive environment for artists and fans to connect and grow.</p>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="bg-gradient-to-r from-primary to-accent rounded-lg p-8 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Join Our Community</h2>
            <p class="text-xl mb-6">Ready to be part of the BlogScript family? Connect with us and stay updated on the latest in entertainment.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Get In Touch
                </a>
                <a href="{{ route('register') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors">
                    Join Now
                </a>
            </div>
        </div>
    </div>
</div>
@endsection