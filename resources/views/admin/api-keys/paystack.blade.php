@extends('admin.layout')

@section('title', 'Paystack API Configuration')

@section('header', 'Paystack API Configuration')

@section('content')
<div class="flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Paystack API Configuration</h1>
                    <p class="text-spotify-light-gray mt-1">Configure payment gateway settings and credentials</p>
                </div>
            </div>
            <div class="mt-4 lg:mt-0">
                <a href="{{ route('admin.api-keys.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to API Keys
                </a>
            </div>
        </div>
    </div>

    <!-- TODO Notice -->
    <div class="bg-yellow-900 bg-opacity-20 border border-yellow-500 text-yellow-400 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                <p class="font-semibold">TODO: Implementation Required</p>
                <p class="text-sm">Paystack payment gateway configuration interface needs to be implemented with secure credential storage and webhook setup.</p>
            </div>
        </div>
    </div>

    <!-- Configuration Form -->
    <div class="bg-spotify-gray rounded-xl border border-spotify-gray">
        <div class="p-6 border-b border-spotify-light-gray">
            <h2 class="text-xl font-semibold text-white">Paystack Payment Settings</h2>
            <p class="text-spotify-light-gray text-sm mt-1">Configure your Paystack payment gateway credentials</p>
        </div>
        
        <form action="{{ route('admin.api-keys.update-paystack') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-6">
                <!-- Environment -->
                <div>
                    <label class="block text-white font-medium mb-2">Environment</label>
                    <select name="environment" disabled
                            class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white focus:border-spotify-green focus:ring-2 focus:ring-spotify-green focus:ring-opacity-20 focus:outline-none">
                        <option value="test" selected>Test Environment</option>
                        <option value="live">Live Environment</option>
                    </select>
                    <p class="text-sm text-spotify-light-gray mt-2">
                        Use test mode for development and testing
                    </p>
                </div>

                <!-- Public Key -->
                <div>
                    <label class="block text-white font-medium mb-2">Public Key</label>
                    <input type="text" name="public_key" 
                           class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white placeholder-spotify-light-gray focus:border-spotify-green focus:ring-2 focus:ring-spotify-green focus:ring-opacity-20 focus:outline-none"
                           placeholder="pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                           value="{{ old('public_key', 'pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx') }}" readonly>
                    <p class="text-sm text-spotify-light-gray mt-2">
                        Get this from your <a href="https://dashboard.paystack.com/#/settings/developer" target="_blank" class="text-spotify-green hover:underline">Paystack Dashboard</a>
                    </p>
                </div>

                <!-- Secret Key -->
                <div>
                    <label class="block text-white font-medium mb-2">Secret Key</label>
                    <input type="password" name="secret_key" 
                           class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white placeholder-spotify-light-gray focus:border-spotify-green focus:ring-2 focus:ring-spotify-green focus:ring-opacity-20 focus:outline-none"
                           placeholder="sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                           value="••••••••••••••••••••••••••••••••" readonly>
                    <p class="text-sm text-spotify-light-gray mt-2">
                        Keep this secret secure. It will be encrypted when stored.
                    </p>
                </div>

                <!-- Webhook URL -->
                <div>
                    <label class="block text-white font-medium mb-2">Webhook URL</label>
                    <input type="url" name="webhook_url" 
                           class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white placeholder-spotify-light-gray focus:border-spotify-green focus:ring-2 focus:ring-spotify-green focus:ring-opacity-20 focus:outline-none"
                           value="{{ url('/webhooks/paystack') }}" readonly>
                    <p class="text-sm text-spotify-light-gray mt-2">
                        Add this URL to your Paystack webhook settings
                    </p>
                </div>

                <!-- Supported Events -->
                <div>
                    <label class="block text-white font-medium mb-2">Webhook Events</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="events[]" value="charge.success" checked disabled
                                   class="rounded border-spotify-light-gray text-spotify-green focus:border-spotify-green focus:ring-spotify-green focus:ring-opacity-20">
                            <span class="ml-2 text-white">charge.success - Payment successful</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="events[]" value="charge.failed" checked disabled
                                   class="rounded border-spotify-light-gray text-spotify-green focus:border-spotify-green focus:ring-spotify-green focus:ring-opacity-20">
                            <span class="ml-2 text-white">charge.failed - Payment failed</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="events[]" value="subscription.create" checked disabled
                                   class="rounded border-spotify-light-gray text-spotify-green focus:border-spotify-green focus:ring-spotify-green focus:ring-opacity-20">
                            <span class="ml-2 text-white">subscription.create - New subscription</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="events[]" value="subscription.disable" checked disabled
                                   class="rounded border-spotify-light-gray text-spotify-green focus:border-spotify-green focus:ring-spotify-green focus:ring-opacity-20">
                            <span class="ml-2 text-white">subscription.disable - Subscription cancelled</span>
                        </label>
                    </div>
                </div>

                <!-- Currency Settings -->
                <div>
                    <label class="block text-white font-medium mb-2">Default Currency</label>
                    <select name="currency" disabled
                            class="w-full bg-spotify-black border border-spotify-light-gray rounded-lg px-4 py-3 text-white focus:border-spotify-green focus:ring-2 focus:ring-spotify-green focus:ring-opacity-20 focus:outline-none">
                        <option value="NGN" selected>NGN - Nigerian Naira</option>
                        <option value="USD">USD - US Dollar</option>
                        <option value="GHS">GHS - Ghanaian Cedi</option>
                        <option value="ZAR">ZAR - South African Rand</option>
                    </select>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="testPaystackConnection()" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Test Connection
                    </button>
                    <button type="submit" disabled
                            class="px-6 py-3 bg-spotify-green text-white rounded-lg hover:bg-spotify-green-light transition-colors opacity-50 cursor-not-allowed">
                        Save Configuration
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function testPaystackConnection() {
    alert('Testing Paystack connection... (TODO: Implement actual testing)');
}
</script>
@endsection