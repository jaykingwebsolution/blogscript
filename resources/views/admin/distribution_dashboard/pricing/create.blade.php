@extends('admin.layout')

@section('title', 'Add New Distribution Pricing Plan')

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
                            <span class="text-gray-900 dark:text-white font-medium">Add New Plan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Distribution Pricing Plan</h1>
                <p class="text-gray-600 dark:text-gray-400">Create a new distribution pricing plan with specific duration</p>
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
            <form method="POST" action="{{ route('admin.distribution.pricing.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Plan Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Plan Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
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
                                   value="{{ old('price') }}" 
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
                        <option value="6 months" {{ old('duration') === '6 months' ? 'selected' : '' }}>6 Months</option>
                        <option value="1 year" {{ old('duration') === '1 year' ? 'selected' : '' }}>1 Year</option>
                        <option value="lifetime" {{ old('duration') === 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                        <option value="custom" {{ old('duration') === 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">How long the distribution service will be active</p>
                </div>

                <!-- Custom Duration (Hidden by default) -->
                <div id="customDurationDiv" class="hidden">
                    <label for="custom_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Custom Duration <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="custom_duration" 
                           name="custom_duration" 
                           value="{{ old('custom_duration') }}" 
                           placeholder="e.g., 2 years, 18 months, 5 years"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter a custom duration (e.g., "2 years", "18 months")</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.distribution.pricing.index') }}" 
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>Create Pricing Plan
                    </button>
                </div>
            </form>
        </div>

        <!-- Helpful Tips -->
        <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-blue-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Pricing Tips</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Consider market competitive rates when setting prices</li>
                            <li>Longer duration plans typically offer better value</li>
                            <li>Use clear, descriptive names that users can understand</li>
                            <li>Price should reflect the value and duration of the service</li>
                        </ul>
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
        customDurationInput.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleCustomDuration();
});
</script>
@endsection