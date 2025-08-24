@extends('layouts.app')

@section('title', $video->title . ' - Video')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Video Header -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Video Player -->
                    <x-video-player :video="$video" />

                    <!-- Video Info -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $video->title }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            @if($video->category)
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $video->category->name }}
                                </span>
                            @endif
                            @if($video->duration)
                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm">
                                    {{ $video->duration }}
                                </span>
                            @endif
                            <span class="text-gray-500 text-sm">
                                {{ $video->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        @if($video->tags->count() > 0)
                            <div class="mb-4">
                                @foreach($video->tags as $tag)
                                    <span class="inline-block bg-gray-700 text-white px-2 py-1 rounded-full text-xs mr-1 mb-1">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if($video->description)
                            <div class="border-t pt-4">
                                <h2 class="text-lg font-semibold text-gray-900 mb-2">Description</h2>
                                <div class="text-gray-700 prose max-w-none">
                                    {!! nl2br(e($video->description)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="mt-8 lg:mt-0">
                    <!-- Related Videos -->
                    @if($relatedVideos->count() > 0)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Related Videos</h2>
                            <div class="space-y-4">
                                @foreach($relatedVideos as $related)
                                    <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                        <div class="flex-shrink-0 relative">
                                            <img src="{{ $related->thumbnail_url ?? '/images/default-video.jpg' }}" 
                                                 alt="{{ $related->title }}" 
                                                 class="w-20 h-14 rounded object-cover">
                                            @if($related->duration)
                                                <div class="absolute bottom-1 right-1 bg-black bg-opacity-75 text-white px-1 py-0.5 rounded text-xs">
                                                    {{ $related->duration }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-900 text-sm line-clamp-2">
                                                <a href="{{ route('videos.show', $related->slug) }}" class="hover:text-primary">
                                                    {{ $related->title }}
                                                </a>
                                            </h4>
                                            @if($related->category)
                                                <p class="text-xs text-gray-600 mt-1">{{ $related->category->name }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-1">{{ $related->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t">
                                <a href="{{ route('videos.index') }}" class="text-primary hover:text-primary/80 font-medium">
                                    Browse All Videos →
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection