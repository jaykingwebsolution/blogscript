@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.plans.index') }}" class="text-purple-600 hover:text-purple-800 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Plan: {{ $plan->name }}</h1>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('admin.plans.update', $plan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Plan Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Plan Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $plan->name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                               placeholder="e.g., Artist Pro Plan" required>
                    </div>

                    <!-- Plan Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Plan Type</label>
                        <select id="type" name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            <option value="">Select Plan Type</option>
                            <option value="free" {{ old('type', $plan->type) == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="artist" {{ old('type', $plan->type) == 'artist' ? 'selected' : '' }}>Artist</option>
                            <option value="record_label" {{ old('type', $plan->type) == 'record_label' ? 'selected' : '' }}>Record Label</option>
                            <option value="premium" {{ old('type', $plan->type) == 'premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                        <div class="flex">
                            <select name="currency" class="px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="NGN" {{ old('currency', $plan->currency) == 'NGN' ? 'selected' : '' }}>₦</option>
                                <option value="USD" {{ old('currency', $plan->currency) == 'USD' ? 'selected' : '' }}>$</option>
                                <option value="EUR" {{ old('currency', $plan->currency) == 'EUR' ? 'selected' : '' }}>€</option>
                            </select>
                            <input type="number" id="price" name="price" value="{{ old('price', $plan->price) }}" step="0.01" min="0"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                   placeholder="0.00">
                        </div>
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-2">Duration (Days)</label>
                        <input type="number" id="duration_days" name="duration_days" value="{{ old('duration_days', $plan->duration_days) }}" min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                               placeholder="30">
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $plan->sort_order) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                               placeholder="0">
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                              placeholder="Brief description of the plan">{{ old('description', $plan->description) }}</textarea>
                </div>

                <!-- Features -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                    <div id="features-container">
                        @php
                            $features = old('features', $plan->features ?? ['']);
                            $features = is_array($features) ? $features : [''];
                            $features = empty($features) ? [''] : $features;
                        @endphp
                        @foreach($features as $feature)
                            <div class="flex items-center mb-2 feature-row">
                                <input type="text" name="features[]" value="{{ $feature }}" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent mr-2" 
                                       placeholder="Feature description">
                                <button type="button" onclick="removeFeature(this)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-feature" class="mt-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                        <i class="fas fa-plus mr-2"></i>Add Feature
                    </button>
                </div>

                <!-- Active Status -->
                <div class="mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Plan is active</span>
                    </label>
                </div>

                <!-- Subscriber Information -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Current Subscribers</h3>
                    <p class="text-blue-700">
                        This plan has <strong>{{ $plan->subscriptions()->where('status', 'active')->count() }}</strong> active subscribers.
                        @if($plan->subscriptions()->where('status', 'active')->count() > 0)
                            <br><small class="text-blue-600">Changes to pricing will only affect new subscriptions.</small>
                        @endif
                    </p>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.plans.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md">
                        Cancel
                    </a>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md">
                        Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addFeature() {
    const container = document.getElementById('features-container');
    const featureRow = document.createElement('div');
    featureRow.className = 'flex items-center mb-2 feature-row';
    featureRow.innerHTML = `
        <input type="text" name="features[]" 
               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent mr-2" 
               placeholder="Feature description">
        <button type="button" onclick="removeFeature(this)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(featureRow);
}

function removeFeature(button) {
    const featureRows = document.querySelectorAll('.feature-row');
    if (featureRows.length > 1) {
        button.closest('.feature-row').remove();
    }
}

document.getElementById('add-feature').addEventListener('click', addFeature);
</script>
@endsection