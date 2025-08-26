@extends('admin.layout')

@section('title', 'Add New Distribution Pricing Plan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center space-x-2 text-gray-500 mb-2">
            <a href="{{ route('admin.distribution-pricing.index') }}" class="hover:text-gray-700">Distribution Pricing</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span>Add New Plan</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Add New Distribution Pricing Plan</h1>
        <p class="text-gray-600">Create a new distribution pricing plan with specific duration</p>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.distribution-pricing.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Plan Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Plan Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="e.g., Basic Distribution, Premium Distribution"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                           required>
                    <p class="mt-1 text-xs text-gray-500">A descriptive name for the distribution plan</p>
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                        Duration <span class="text-red-500">*</span>
                    </label>
                    <select id="duration" 
                            name="duration" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                            required>
                        <option value="">Select Duration</option>
                        <option value="6 months" {{ old('duration') == '6 months' ? 'selected' : '' }}>6 Months</option>
                        <option value="1 year" {{ old('duration') == '1 year' ? 'selected' : '' }}>1 Year</option>
                        <option value="lifetime" {{ old('duration') == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                        <option value="custom" {{ old('duration') == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Distribution plan duration</p>
                </div>
            </div>

            <!-- Custom Duration Input (hidden by default) -->
            <div id="custom-duration" class="hidden">
                <label for="custom_duration_input" class="block text-sm font-medium text-gray-700 mb-2">
                    Custom Duration <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="custom_duration_input" 
                       name="custom_duration" 
                       value="{{ old('custom_duration') }}" 
                       placeholder="e.g., 18 months, 2 years"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                <p class="mt-1 text-xs text-gray-500">Enter custom duration (e.g., "18 months", "2 years")</p>
            </div>

            <!-- Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Price (₦) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">₦</span>
                        </div>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}" 
                               step="0.01"
                               min="0"
                               placeholder="0.00"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                               required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Price in Nigerian Naira</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between pt-6">
                <a href="{{ route('admin.distribution-pricing.index') }}" 
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back to List</span>
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Create Plan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const durationSelect = document.getElementById('duration');
    const customDurationDiv = document.getElementById('custom-duration');
    const customDurationInput = document.getElementById('custom_duration_input');
    
    durationSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customDurationDiv.classList.remove('hidden');
            customDurationInput.required = true;
        } else {
            customDurationDiv.classList.add('hidden');
            customDurationInput.required = false;
            customDurationInput.value = '';
        }
    });
    
    // Check on page load
    if (durationSelect.value === 'custom') {
        customDurationDiv.classList.remove('hidden');
        customDurationInput.required = true;
    }
});
</script>
@endsection