@extends('layouts.admin-distribution')

@section('title', 'Distribution Pricing Management')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-spotify-green/10 rounded-full">
                        <i class="fas fa-tags text-spotify-green text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Distribution Pricing Management</h1>
                        <p class="text-gray-600 dark:text-gray-400">Manage distribution pricing plans with different durations</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.distribution.dashboard') }}" 
                       class="px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('admin.distribution.pricing.create') }}" 
                       class="px-4 py-2 bg-spotify-green text-white font-medium rounded-lg hover:bg-spotify-green/90 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add New Plan
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                        <i class="fas fa-tags text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Plans</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pricingPlans->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900/20 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available Plans</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pricingPlans->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                        <i class="fas fa-dollar-sign text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Min Price</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            @if($pricingPlans->count())
                                ₦{{ number_format($pricingPlans->min('price'), 2) }}
                            @else
                                --
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 dark:bg-orange-900/20 rounded-lg">
                        <i class="fas fa-chart-line text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Max Price</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            @if($pricingPlans->count())
                                ₦{{ number_format($pricingPlans->max('price'), 2) }}
                            @else
                                --
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribution Pricing Plans Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($pricingPlans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Plan Name</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($pricingPlans as $plan)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-spotify-green/10 rounded-lg flex items-center justify-center mr-4">
                                                <i class="fas fa-tag text-spotify-green"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $plan->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if(str_contains(strtolower($plan->duration), 'lifetime')) bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                            @elseif(str_contains(strtolower($plan->duration), 'year')) bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @endif">
                                            {{ $plan->duration }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $plan->formatted_price }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $plan->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.distribution.pricing.edit', $plan) }}" 
                                               class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.distribution.pricing.destroy', $plan) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 ml-2"
                                                        onclick="return confirm('Are you sure you want to delete this pricing plan?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500 mb-4">
                        <i class="fas fa-tags text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No pricing plans found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Get started by creating your first distribution pricing plan.</p>
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('admin.distribution.pricing.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Create First Plan
                        </a>
                        <button onclick="generateRandomPlan()" 
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <i class="fas fa-magic mr-2"></i>
                            Generate Random Plan
                        </button>
                    </div>
                </div>
            @endif
        </div>

        @if($pricingPlans->count() > 0)
            <!-- Quick Actions -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <button onclick="generateRandomPlan()" 
                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-magic mr-2"></i>
                        Generate Random Plan
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function generateRandomPlan() {
    if (confirm('Generate a random distribution pricing plan for testing purposes?')) {
        fetch('{{ route("admin.distribution.pricing.generate-random") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error generating random plan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // For now, just redirect to create page as fallback
            window.location.href = '{{ route("admin.distribution.pricing.create") }}';
        });
    }
}
</script>
@endsection