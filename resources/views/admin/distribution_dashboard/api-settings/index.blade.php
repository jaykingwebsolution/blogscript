@extends('layouts.admin-distribution')

@section('title', 'API Settings Management')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                            <span class="text-gray-900 dark:text-white font-medium">API Settings</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Payment API Settings</h1>
                        <p class="text-gray-600 dark:text-gray-400">Configure Paystack and Flutterwave API keys for distribution payments</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.distribution.api-settings.form', ['provider' => 'paystack', 'environment' => 'test']) }}" 
                           class="px-4 py-2 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                            <i class="fas fa-plus mr-2"></i>Add API Setting
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mx-6 mt-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- API Settings -->
            <div class="p-6">
                @if($apiSettings->isEmpty())
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                            <i class="fas fa-key text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No API Settings Configured</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Configure API keys for payment providers to enable distribution payments.</p>
                        <a href="{{ route('admin.distribution.api-settings.form', ['provider' => 'paystack', 'environment' => 'test']) }}" 
                           class="inline-flex items-center px-6 py-3 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                            <i class="fas fa-plus mr-2"></i>
                            Add First API Setting
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($apiSettings as $provider => $providerSettings)
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg">
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white capitalize">
                                        {{ $provider }} Configuration
                                    </h3>
                                </div>
                                <div class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($providerSettings as $setting)
                                        <div class="p-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex-shrink-0">
                                                            @if($setting->is_active)
                                                                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                                            @else
                                                                <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $setting->provider_display_name }} - {{ $setting->environment_display_name }}
                                                            </h4>
                                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                                <span class="mr-4">
                                                                    <i class="fas fa-key mr-1"></i>
                                                                    Public Key: {{ Str::limit($setting->public_key, 20) }}...
                                                                </span>
                                                                <span>
                                                                    <i class="fas fa-lock mr-1"></i>
                                                                    Secret Key: {{ $setting->masked_secret_key }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <!-- Status Badge -->
                                                    @if($setting->is_active)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400">
                                                            Inactive
                                                        </span>
                                                    @endif

                                                    <!-- Actions -->
                                                    <div class="flex items-center space-x-1">
                                                        <form method="POST" action="{{ route('admin.distribution.api-settings.test', $setting) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="p-2 text-blue-600 hover:text-blue-800 transition-colors" 
                                                                    title="Test Connection">
                                                                <i class="fas fa-plug"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        <a href="{{ route('admin.distribution.api-settings.form', ['provider' => $setting->provider, 'environment' => $setting->environment]) }}" 
                                                           class="p-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 transition-colors" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <form method="POST" action="{{ route('admin.distribution.api-settings.toggle', $setting) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="p-2 {{ $setting->is_active ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }} transition-colors" 
                                                                    title="{{ $setting->is_active ? 'Deactivate' : 'Activate' }}">
                                                                <i class="fas fa-power-off"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        <form method="POST" action="{{ route('admin.distribution.api-settings.destroy', $setting) }}" 
                                                              class="inline" 
                                                              onsubmit="return confirm('Are you sure you want to delete this API setting?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="p-2 text-red-600 hover:text-red-800 transition-colors" 
                                                                    title="Delete">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Add Environment Button -->
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3">
                                    <div class="flex space-x-2">
                                        @if(!$providerSettings->where('environment', 'test')->count())
                                            <a href="{{ route('admin.distribution.api-settings.form', ['provider' => $provider, 'environment' => 'test']) }}" 
                                               class="text-sm text-spotify-green hover:text-spotify-green/80 transition-colors">
                                                <i class="fas fa-plus mr-1"></i>Add Test Environment
                                            </a>
                                        @endif
                                        @if(!$providerSettings->where('environment', 'live')->count())
                                            <a href="{{ route('admin.distribution.api-settings.form', ['provider' => $provider, 'environment' => 'live']) }}" 
                                               class="text-sm text-spotify-green hover:text-spotify-green/80 transition-colors">
                                                <i class="fas fa-plus mr-1"></i>Add Live Environment
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Add Other Providers -->
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">
                            <div class="space-y-3">
                                <div>
                                    <i class="fas fa-plus-circle text-3xl text-gray-400 mb-3"></i>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Add More Providers</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Configure additional payment providers</p>
                                </div>
                                <div class="flex justify-center space-x-4">
                                    @if(!$apiSettings->has('paystack'))
                                        <a href="{{ route('admin.distribution.api-settings.form', ['provider' => 'paystack', 'environment' => 'test']) }}" 
                                           class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                            <i class="fas fa-credit-card mr-2"></i>Add Paystack
                                        </a>
                                    @endif
                                    @if(!$apiSettings->has('flutterwave'))
                                        <a href="{{ route('admin.distribution.api-settings.form', ['provider' => 'flutterwave', 'environment' => 'test']) }}" 
                                           class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                            <i class="fas fa-credit-card mr-2"></i>Add Flutterwave
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">API Configuration Tips</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Always test your API keys before activating them</li>
                            <li>Use test mode for development and staging environments</li>
                            <li>Only activate live mode when ready for production</li>
                            <li>Keep your secret keys secure and never share them</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection