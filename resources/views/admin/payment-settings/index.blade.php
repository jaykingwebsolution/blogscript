@extends('admin.layout')

@section('title', 'Payment Settings')
@section('header', 'Payment Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Paystack Payment Configuration</h2>
            <button onclick="testConnection()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Test Connection
            </button>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Test Mode Active</h3>
                    <p class="text-sm text-yellow-700 mt-1">Demo keys are pre-configured for testing. Replace with live keys for production.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.payment-settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Payment Environment -->
            <div>
                <label for="payment_environment" class="block text-sm font-medium text-gray-700 mb-2">Payment Environment</label>
                <select name="payment_environment" id="payment_environment" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="test" {{ $paymentSettings['payment_environment'] == 'test' ? 'selected' : '' }}>Test (Demo Keys)</option>
                    <option value="live" {{ $paymentSettings['payment_environment'] == 'live' ? 'selected' : '' }}>Live (Production Keys)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Switch to live mode only when ready for production payments</p>
            </div>

            <!-- Paystack Public Key -->
            <div>
                <label for="paystack_public_key" class="block text-sm font-medium text-gray-700 mb-2">
                    Paystack Public Key
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="paystack_public_key" 
                       id="paystack_public_key" 
                       value="{{ $paymentSettings['paystack_public_key'] }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="pk_test_..." 
                       required>
                <p class="text-xs text-gray-500 mt-1">Your Paystack public key (starts with pk_test_ for test mode)</p>
                @error('paystack_public_key')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Paystack Secret Key -->
            <div>
                <label for="paystack_secret_key" class="block text-sm font-medium text-gray-700 mb-2">
                    Paystack Secret Key
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" 
                           name="paystack_secret_key" 
                           id="paystack_secret_key" 
                           value="{{ $paymentSettings['paystack_secret_key'] }}"
                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="sk_test_..." 
                           required>
                    <button type="button" onclick="toggleSecretKey()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" id="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Your Paystack secret key (starts with sk_test_ for test mode)</p>
                @error('paystack_secret_key')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Merchant Email -->
            <div>
                <label for="paystack_merchant_email" class="block text-sm font-medium text-gray-700 mb-2">
                    Merchant Email
                    <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="paystack_merchant_email" 
                       id="paystack_merchant_email" 
                       value="{{ $paymentSettings['paystack_merchant_email'] }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="merchant@example.com" 
                       required>
                <p class="text-xs text-gray-500 mt-1">Email associated with your Paystack account</p>
                @error('paystack_merchant_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Demo Keys Info -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-800 mb-2">Demo Keys Information</h3>
                <div class="space-y-2 text-xs text-gray-600">
                    <p><strong>Public Key:</strong> pk_test_demo_key_replace_with_yours</p>
                    <p><strong>Secret Key:</strong> sk_test_demo_key_replace_with_yours</p>
                    <p class="text-blue-600">These demo keys allow testing payment flows without actual charges. Replace with your real Paystack keys.</p>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Payment Settings
                </button>
            </div>
        </form>

        <!-- Connection Test Result -->
        <div id="test-result" class="mt-6 hidden">
            <!-- Result will be inserted here -->
        </div>
    </div>

    <!-- Instructions Card -->
    <div class="mt-8 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Setup Instructions</h3>
        <div class="prose text-sm text-gray-600">
            <ol class="list-decimal list-inside space-y-2">
                <li>Sign up for a Paystack account at <a href="https://paystack.com" target="_blank" class="text-blue-600 hover:underline">paystack.com</a></li>
                <li>Navigate to Settings → API Keys & Webhooks in your Paystack dashboard</li>
                <li>Copy your Test Public Key and Test Secret Key</li>
                <li>Paste them in the form above and save</li>
                <li>Use the "Test Connection" button to verify your keys work</li>
                <li>Switch to Live keys only when ready for production</li>
            </ol>
        </div>
    </div>
</div>

<script>
function toggleSecretKey() {
    const input = document.getElementById('paystack_secret_key');
    const icon = document.getElementById('eye-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
    }
}

function testConnection() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Testing...';
    button.disabled = true;

    fetch('{{ route("admin.payment-settings.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        const resultDiv = document.getElementById('test-result');
        resultDiv.className = `mt-6 p-4 rounded-lg ${data.success ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'}`;
        resultDiv.innerHTML = `
            <div class="flex">
                <svg class="w-5 h-5 ${data.success ? 'text-green-400' : 'text-red-400'} mr-2" fill="currentColor" viewBox="0 0 20 20">
                    ${data.success ? 
                        '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>' :
                        '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>'
                    }
                </svg>
                <div>
                    <h3 class="text-sm font-medium ${data.success ? 'text-green-800' : 'text-red-800'}">${data.success ? 'Connection Successful' : 'Connection Failed'}</h3>
                    <p class="text-sm ${data.success ? 'text-green-700' : 'text-red-700'} mt-1">${data.message}</p>
                </div>
            </div>
        `;
        resultDiv.classList.remove('hidden');
    })
    .catch(error => {
        const resultDiv = document.getElementById('test-result');
        resultDiv.className = 'mt-6 p-4 rounded-lg bg-red-50 border border-red-200';
        resultDiv.innerHTML = `
            <div class="flex">
                <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Connection Error</h3>
                    <p class="text-sm text-red-700 mt-1">Network error occurred while testing connection.</p>
                </div>
            </div>
        `;
        resultDiv.classList.remove('hidden');
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}
</script>
@endsection