@extends('admin.layout')

@section('title', 'API Settings - ' . ucfirst($provider) . ' ' . ucfirst($environment))

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
                            <a href="{{ route('admin.distribution.api-settings.index') }}" 
                               class="text-gray-400 hover:text-gray-500">
                                API Settings
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-3"></i>
                            <span class="text-gray-900 dark:text-white font-medium">
                                {{ ucfirst($provider) }} {{ ucfirst($environment) }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $setting ? 'Edit' : 'Add' }} {{ ucfirst($provider) }} API Settings
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Configure {{ ucfirst($provider) }} API keys for {{ $environment }} environment
                </p>
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
            <form method="POST" action="{{ route('admin.distribution.api-settings.store') }}" class="space-y-6">
                @csrf
                
                <!-- Hidden fields -->
                <input type="hidden" name="provider" value="{{ $provider }}">
                <input type="hidden" name="environment" value="{{ $environment }}">
                
                <!-- Provider Display -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-credit-card text-2xl text-gray-600 dark:text-gray-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ ucfirst($provider) }} Configuration
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Environment: <span class="font-medium">{{ ucfirst($environment) }} Mode</span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Public Key -->
                    <div>
                        <label for="public_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Public Key <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="public_key" 
                               name="public_key" 
                               value="{{ old('public_key', $setting->public_key ?? '') }}" 
                               placeholder="{{ $provider === 'paystack' ? 'pk_test_...' : 'FLWPUBK_TEST...' }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                               required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            The public key from your {{ ucfirst($provider) }} {{ $environment }} dashboard
                        </p>
                    </div>

                    <!-- Secret Key -->
                    <div>
                        <label for="secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Secret Key <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="secret_key" 
                                   name="secret_key" 
                                   value="{{ old('secret_key', $setting && $setting->secret_key ? '••••••••••••••••' : '') }}" 
                                   placeholder="{{ $provider === 'paystack' ? 'sk_test_...' : 'FLWSECK_TEST...' }}"
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                                   required>
                            <button type="button" 
                                    onclick="toggleSecretKeyVisibility()" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="secret-key-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            The secret key from your {{ ucfirst($provider) }} {{ $environment }} dashboard
                        </p>
                        @if($setting && $setting->secret_key)
                            <p class="mt-1 text-xs text-blue-600 dark:text-blue-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                Leave unchanged to keep the current secret key
                            </p>
                        @endif
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $setting->is_active ?? false) ? 'checked' : '' }}
                               class="h-4 w-4 text-spotify-green focus:ring-spotify-green border-gray-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                            Make this API configuration active
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.distribution.api-settings.index') }}" 
                       class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>{{ $setting ? 'Update' : 'Save' }} API Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Environment Warning -->
        @if($environment === 'live')
            <div class="mt-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Live Environment Warning</h3>
                        <p class="mt-2 text-sm text-red-700 dark:text-red-400">
                            You are configuring live API keys. These will be used for real transactions. 
                            Make sure to test thoroughly in the test environment before activating.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Helpful Tips -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-blue-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Getting Your API Keys</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        @if($provider === 'paystack')
                            <p class="mb-2">To get your Paystack API keys:</p>
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Log in to your <a href="https://dashboard.paystack.com" target="_blank" class="underline hover:no-underline">Paystack Dashboard</a></li>
                                <li>Go to Settings > API Keys & Webhooks</li>
                                <li>Copy your Public Key (starts with pk_{{ $environment }}_...)</li>
                                <li>Copy your Secret Key (starts with sk_{{ $environment }}_...)</li>
                            </ol>
                        @elseif($provider === 'flutterwave')
                            <p class="mb-2">To get your Flutterwave API keys:</p>
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Log in to your <a href="https://dashboard.flutterwave.com" target="_blank" class="underline hover:no-underline">Flutterwave Dashboard</a></li>
                                <li>Go to Settings > API</li>
                                <li>Copy your Public Key (starts with FLWPUBK_{{ strtoupper($environment) }}...)</li>
                                <li>Copy your Secret Key (starts with FLWSECK_{{ strtoupper($environment) }}...)</li>
                            </ol>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSecretKeyVisibility() {
    const secretKeyInput = document.getElementById('secret_key');
    const secretKeyIcon = document.getElementById('secret-key-icon');
    
    if (secretKeyInput.type === 'password') {
        secretKeyInput.type = 'text';
        secretKeyIcon.className = 'fas fa-eye-slash text-gray-400 hover:text-gray-600';
    } else {
        secretKeyInput.type = 'password';
        secretKeyIcon.className = 'fas fa-eye text-gray-400 hover:text-gray-600';
    }
}
</script>
@endsection