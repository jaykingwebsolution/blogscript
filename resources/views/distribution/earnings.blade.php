@extends('layouts.app')

@section('title', 'Distribution Earnings')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Distribution Earnings
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Track your streaming royalties and earnings across all platforms
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <!-- Total Earnings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-dollar-sign text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Earnings</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($totalEarnings, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- This Month -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar-month text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Month</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($thisMonthEarnings, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pending Earnings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($pendingEarnings, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Top Platform -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-crown text-purple-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Top Platform</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $platformEarnings->keys()->first() ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Breakdown -->
        @if($platformEarnings->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 mb-8">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    Earnings by Platform
                </h3>
                <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($platformEarnings as $platform => $amount)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-spotify-green rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white capitalize">
                                    {{ str_replace('_', ' ', $platform) }}
                                </span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                ${{ number_format($amount, 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Earnings Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Recent Earnings
                </h3>
            </div>

            @if($earnings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Release
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Platform
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Territory
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Period
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Streams
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Earnings
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($earnings as $earning)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $earning->distributionRequest->song_title ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $earning->distributionRequest->artist_name ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 dark:text-white">
                                            {{ $earning->platform_display_name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $earning->territory ?: 'Worldwide' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $earning->period_description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ number_format($earning->streams) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $earning->formatted_amount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $earning->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' }}">
                                            {{ ucfirst($earning->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $earnings->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                        <i class="fas fa-chart-bar text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Earnings Yet</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Your earnings will appear here once your music starts generating royalties.
                    </p>
                    <a href="{{ route('distribution.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                        <i class="fas fa-upload mr-2"></i>
                        Upload Your First Release
                    </a>
                </div>
            @endif
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Understanding Your Earnings</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Earnings are updated monthly from streaming platforms</li>
                            <li>Pending earnings will be confirmed after platform reporting periods</li>
                            <li>Minimum payout threshold is $10.00</li>
                            <li>Payouts are processed within 5 business days of request</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection