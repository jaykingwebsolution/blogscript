@extends('admin.layout')

@section('title', 'Create Pricing Plan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.pricing.index') }}" class="text-spotify-green hover:text-spotify-green-light mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-white">Create New Pricing Plan</h1>
        </div>

        @if($errors->any())
            <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-400 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-spotify-gray rounded-lg shadow-lg border border-spotify-light-gray p-8">
            <form action="{{ route('admin.pricing.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Plan Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-white mb-2">Plan Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               class="w-full px-3 py-2 border border-spotify-light-gray bg-spotify-black text-white rounded-md focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent" 
                               placeholder="e.g., Premium Distribution Plan" required>
                    </div>

                    <!-- Plan Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-white mb-2">Plan Type</label>
                        <select id="type" name="type" class="w-full px-3 py-2 border border-spotify-light-gray bg-spotify-black text-white rounded-md focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent" required>
                            <option value="">Select Plan Type</option>
                            <option value="one_time" {{ old('type') == 'one_time' ? 'selected' : '' }}>One-time Payment</option>
                            <option value="recurring" {{ old('type') == 'recurring' ? 'selected' : '' }}>Recurring Subscription</option>
                        </select>
                    </div>

                    <!-- Interval (shown only for recurring plans) -->
                    <div id="interval-section" style="display: {{ old('type') == 'recurring' ? 'block' : 'none' }};">
                        <label for="interval" class="block text-sm font-medium text-white mb-2">Billing Interval</label>
                        <select id="interval" name="interval" class="w-full px-3 py-2 border border-spotify-light-gray bg-spotify-black text-white rounded-md focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent">
                            <option value="">Select Interval</option>
                            <option value="monthly" {{ old('interval') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('interval') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-white mb-2">Price</label>
                        <div class="flex">
                            <select name="currency" class="px-3 py-2 border border-spotify-light-gray bg-spotify-black text-white rounded-l-md focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent">
                                <option value="USD" {{ old('currency', 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="NGN" {{ old('currency') == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                            </select>
                            <input type="number" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0"
                                   class="flex-1 px-3 py-2 border border-spotify-light-gray bg-spotify-black text-white rounded-r-md focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent" 
                                   placeholder="0.00" required>
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-spotify-green bg-spotify-black border-spotify-light-gray rounded focus:ring-spotify-green">
                            <span class="ml-2 text-sm text-white">Plan is active</span>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-white mb-2">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="w-full px-3 py-2 border border-spotify-light-gray bg-spotify-black text-white rounded-md focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent" 
                              placeholder="Brief description of the plan">{{ old('description') }}</textarea>
                </div>

                <!-- Features -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-white mb-2">Features</label>
                    <div id="features-container">
                        @php
                            $oldFeatures = old('features');
                            $featuresText = '';
                            if (is_array($oldFeatures)) {
                                $featuresText = implode("\n", $oldFeatures);
                            } elseif (is_string($oldFeatures)) {
                                $featuresText = $oldFeatures;
                            }
                        @endphp
                        <textarea name="features" rows="5"
                                  class="w-full px-3 py-2 border border-spotify-light-gray bg-spotify-black text-white rounded-md focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-transparent"
                                  placeholder="Enter features, one per line">{{ $featuresText }}</textarea>
                        <p class="text-sm text-spotify-light-gray mt-1">Enter each feature on a new line</p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.pricing.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white px-6 py-2 rounded-md transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-spotify-green hover:bg-spotify-green-light text-white px-6 py-2 rounded-md transition-colors">
                        Create Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Show/hide interval field based on plan type
document.getElementById('type').addEventListener('change', function() {
    const intervalSection = document.getElementById('interval-section');
    const intervalField = document.getElementById('interval');
    
    if (this.value === 'recurring') {
        intervalSection.style.display = 'block';
        intervalField.required = true;
    } else {
        intervalSection.style.display = 'none';
        intervalField.required = false;
        intervalField.value = '';
    }
});
</script>
@endsection