@extends('admin.layout')

@section('title', 'Edit Distribution Pricing Plan')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('admin.distribution.dashboard') }}" 
                           class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-arrow-left mr-2"></i>Distribution Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-3"></i>
                            <a href="{{ route('admin.distribution.pricing.index') }}" 
                               class="text-gray-400 hover:text-gray-500">
                                Pricing Plans
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-3"></i>
                            <span class="text-gray-900 dark:text-white font-medium">Edit {{ $distributionPricing->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Distribution Pricing Plan</h1>
                <p class="text-gray-600 dark:text-gray-400">Update the distribution pricing plan details</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-lg p-4 mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="font-medium">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside ml-6">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('admin.distribution.pricing.update', $distributionPricing) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Plan Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Plan Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $distributionPricing->name) }}" 
                               placeholder="e.g., Basic Distribution, Premium Distribution"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                               required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">A descriptive name for the distribution plan</p>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Price (₦) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">₦</span>
                            </div>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price', $distributionPricing->price) }}" 
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                   required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">The price in Nigerian Naira</p>
                    </div>
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Duration <span class="text-red-500">*</span>
                    </label>
                    <select id="duration" 
                            name="duration" 
                            onchange="toggleCustomDuration()"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                            required>
                        <option value="">Select Duration</option>
                        <option value="6 months" {{ (old('duration', $distributionPricing->duration) === '6 months') ? 'selected' : '' }}>6 Months</option>
                        <option value="1 year" {{ (old('duration', $distributionPricing->duration) === '1 year') ? 'selected' : '' }}>1 Year</option>
                        <option value="lifetime" {{ (old('duration', $distributionPricing->duration) === 'lifetime') ? 'selected' : '' }}>Lifetime</option>
                        <option value="custom" {{ (!in_array(old('duration', $distributionPricing->duration), ['6 months', '1 year', 'lifetime']) && old('duration', $distributionPricing->duration)) ? 'selected' : '' }}>Custom</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">How long the distribution service will be active</p>
                </div>

                <!-- Custom Duration (Hidden by default) -->
                <div id="customDurationDiv" class="{{ (!in_array(old('duration', $distributionPricing->duration), ['6 months', '1 year', 'lifetime']) && old('duration', $distributionPricing->duration)) ? '' : 'hidden' }}">
                    <label for="custom_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Custom Duration <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="custom_duration" 
                           name="custom_duration" 
                           value="{{ (!in_array(old('duration', $distributionPricing->duration), ['6 months', '1 year', 'lifetime']) && old('duration', $distributionPricing->duration)) ? old('custom_duration', $distributionPricing->duration) : old('custom_duration') }}" 
                           placeholder="e.g., 2 years, 18 months, 5 years"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter a custom duration (e.g., "2 years", "18 months")</p>
                </div>

                <!-- Created/Updated Info -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Created:</span>
                            <span class="text-gray-600 dark:text-gray-400">{{ $distributionPricing->created_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Last Updated:</span>
                            <span class="text-gray-600 dark:text-gray-400">{{ $distributionPricing->updated_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.distribution.pricing.index') }}" 
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>Update Pricing Plan
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-red-200 dark:border-red-800 p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-400">Danger Zone</h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p>Deleting this pricing plan is permanent and cannot be undone. Users who have purchased this plan will not be affected.</p>
                    </div>
                    <div class="mt-4">
                        <form method="POST" action="{{ route('admin.distribution.pricing.destroy', $distributionPricing) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors"
                                    onclick="return confirm('Are you sure you want to delete this pricing plan? This action cannot be undone.')">
                                <i class="fas fa-trash mr-2"></i>Delete Pricing Plan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCustomDuration() {
    const durationSelect = document.getElementById('duration');
    const customDurationDiv = document.getElementById('customDurationDiv');
    const customDurationInput = document.getElementById('custom_duration');
    
    if (durationSelect.value === 'custom') {
        customDurationDiv.classList.remove('hidden');
        customDurationInput.required = true;
    } else {
        customDurationDiv.classList.add('hidden');
        customDurationInput.required = false;
        if (durationSelect.value !== '') {
            customDurationInput.value = '';
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleCustomDuration();
});
</script>
@endsection