@extends('layouts.app')

@section('title', 'My Distribution Submissions')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-spotify-green/10 rounded-full">
                        <i class="fas fa-list-alt text-spotify-green text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Distribution Submissions</h1>
                        <p class="text-gray-600 dark:text-gray-400">Track your music distribution requests and their status</p>
                    </div>
                </div>
                <a href="{{ route('distribution.create') }}" 
                   class="px-4 py-2 bg-spotify-green text-white font-medium rounded-lg hover:bg-spotify-green/90 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Submit New Music
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Submissions List -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Music</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Artist/Genre</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Release Date</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($submission->cover_image)
                                                <img src="{{ asset('storage/' . $submission->cover_image) }}" 
                                                     alt="{{ $submission->song_title }}" 
                                                     class="w-12 h-12 rounded-lg object-cover mr-4">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-music text-gray-400 dark:text-gray-500"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $submission->song_title }}</div>
                                                @if($submission->audio_file)
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        <i class="fas fa-file-audio mr-1"></i>Audio uploaded
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $submission->artist_name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $submission->genre }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $submission->release_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $submission->status_color }}">
                                            @if($submission->status === 'pending')
                                                <i class="fas fa-clock mr-1"></i>
                                            @elseif($submission->status === 'approved')
                                                <i class="fas fa-check mr-1"></i>
                                            @else
                                                <i class="fas fa-times mr-1"></i>
                                            @endif
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $submission->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('distribution.show', $submission) }}" 
                                           class="text-spotify-green hover:text-spotify-green/80 mr-4">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $submissions->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500 mb-4">
                        <i class="fas fa-music text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No submissions yet</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">You haven't submitted any music for distribution.</p>
                    <a href="{{ route('distribution.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-spotify-green text-white font-medium rounded-lg hover:bg-spotify-green/90 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Submit Your First Track
                    </a>
                </div>
            @endif
        </div>

        <!-- Status Guide -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mt-8">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Status Guide</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-1"></i>Pending
                    </span>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Your submission is under review by our team.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check mr-1"></i>Approved
                    </span>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Your music has been approved and will be distributed to streaming platforms.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-times mr-1"></i>Declined
                    </span>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Your submission needs revision. Check the details for feedback.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection