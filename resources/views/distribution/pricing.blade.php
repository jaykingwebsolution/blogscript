@extends('layouts.app')

@section('title', 'Distribution Pricing Plans')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Distribution Pricing
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Choose the perfect plan for your music distribution needs. All plans include worldwide distribution to 150+ digital stores.
            </p>
        </div>

        <!-- Pricing Cards -->
        @if($distributionPlans->count() > 0)
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($distributionPlans as $plan)
                    <div class="relative bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 {{ $plan->isPopular() ? 'ring-2 ring-spotify-green shadow-xl transform scale-105' : 'shadow-lg' }}">
                        @if($plan->isPopular())
                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                <span class="bg-spotify-green text-white px-4 py-1 rounded-full text-sm font-medium">
                                    Most Popular
                                </span>
                            </div>
                        @endif
                        
                        <div class="p-8">
                            <div class="text-center mb-8">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $plan->type_display_name }}
                                </h3>
                                <div class="mb-4">
                                    <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                        {{ $plan->formatted_price }}
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-400 ml-1">
                                        /{{ $plan->duration }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ $plan->description }}
                                </p>
                            </div>

                            <ul class="space-y-4 mb-8">
                                @foreach($plan->formatted_features as $feature)
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-spotify-green mr-3 mt-0.5 flex-shrink-0"></i>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <a href="{{ route('distribution.plans.purchase', $plan) }}" 
                               class="w-full px-6 py-4 {{ $plan->isPopular() ? 'bg-spotify-green hover:bg-spotify-green/90' : 'bg-gray-900 hover:bg-gray-800' }} text-white rounded-lg transition-colors font-medium text-center block text-lg">
                                Get Started
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                    <i class="fas fa-tag text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Plans Available</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Distribution plans are being configured. Please check back later.
                </p>
            </div>
        @endif

        <!-- FAQ Section -->
        <div class="mt-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Frequently Asked Questions
                </h2>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            How long does distribution take?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Your music typically goes live on streaming platforms within 3-5 business days after approval. Some platforms may take up to 7 days.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Do I keep the rights to my music?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Yes, you retain 100% ownership of your music and master recordings. We only handle the distribution process.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            When do I get paid?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Royalty payments are processed monthly, typically within the first week of each month for the previous month's earnings.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Can I upgrade or downgrade my plan?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            You can upgrade your plan at any time. Changes will take effect immediately, and you'll be charged the prorated difference.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection