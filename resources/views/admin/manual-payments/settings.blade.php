@extends('admin.layout')

@section('title', 'Bank Details Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Bank Details Settings</h1>
            <p class="text-gray-600">Configure bank account details for manual payments</p>
        </div>
        <a href="{{ route('admin.manual-payments.index') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            Back to Payments
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <!-- Settings Form -->
    <div class="bg-gray-50 dark:bg-gray-900 shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Bank Account Information</h2>
            <p class="text-sm text-gray-500">This information will be displayed to users making manual payments</p>
        </div>
        
        <form method="POST" action="{{ route('admin.manual-payments.update-settings') }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="bank_account_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Account Name *
                    </label>
                    <input type="text" 
                           id="bank_account_name" 
                           name="bank_account_name" 
                           value="{{ old('bank_account_name', $bankDetails['account_name']) }}"
                           required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., MusicStream Limited">
                    @error('bank_account_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Account Number *
                    </label>
                    <input type="text" 
                           id="bank_account_number" 
                           name="bank_account_number" 
                           value="{{ old('bank_account_number', $bankDetails['account_number']) }}"
                           required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., 1234567890">
                    @error('bank_account_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Bank Name *
                </label>
                <input type="text" 
                       id="bank_name" 
                       name="bank_name" 
                       value="{{ old('bank_name', $bankDetails['bank_name']) }}"
                       required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="e.g., First Bank of Nigeria">
                @error('bank_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="payment_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                    Payment Instructions
                </label>
                <textarea id="payment_instructions" 
                          name="payment_instructions" 
                          rows="4"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Additional instructions for users making manual payments...">{{ old('payment_instructions', $bankDetails['instructions']) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Optional additional instructions that will be shown to users</p>
                @error('payment_instructions')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.manual-payments.index') }}" 
                   class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Save Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Card -->
    <div class="bg-gray-50 dark:bg-gray-900 shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Preview</h2>
            <p class="text-sm text-gray-500">How users will see the bank details</p>
        </div>
        
        <div class="p-6">
            <div class="bg-gray-50 rounded-lg p-4 max-w-md">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Bank Transfer Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Account Name:</span>
                        <span class="text-gray-900 font-mono" id="preview-account-name">{{ $bankDetails['account_name'] ?: 'Not set' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Account Number:</span>
                        <span class="text-gray-900 font-mono" id="preview-account-number">{{ $bankDetails['account_number'] ?: 'Not set' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Bank:</span>
                        <span class="text-gray-900" id="preview-bank-name">{{ $bankDetails['bank_name'] ?: 'Not set' }}</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-3 border-t border-gray-200" id="preview-instructions-container" style="{{ $bankDetails['instructions'] ? '' : 'display: none;' }}">
                    <p class="text-yellow-700 text-xs bg-yellow-50 p-2 rounded" id="preview-instructions">
                        {{ $bankDetails['instructions'] ?: '' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview updates
document.getElementById('bank_account_name').addEventListener('input', function() {
    document.getElementById('preview-account-name').textContent = this.value || 'Not set';
});

document.getElementById('bank_account_number').addEventListener('input', function() {
    document.getElementById('preview-account-number').textContent = this.value || 'Not set';
});

document.getElementById('bank_name').addEventListener('input', function() {
    document.getElementById('preview-bank-name').textContent = this.value || 'Not set';
});

document.getElementById('payment_instructions').addEventListener('input', function() {
    const container = document.getElementById('preview-instructions-container');
    const preview = document.getElementById('preview-instructions');
    
    if (this.value.trim()) {
        container.style.display = 'block';
        preview.textContent = this.value;
    } else {
        container.style.display = 'none';
    }
});
</script>
@endsection