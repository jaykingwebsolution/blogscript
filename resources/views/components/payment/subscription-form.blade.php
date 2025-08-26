{{-- 
    Subscription Payment Initialization Form Component
    Usage: @include('components.payment.subscription-form', ['planKey' => 'artist', 'planDetails' => $planDetails])
--}}

@props(['planKey', 'planDetails', 'buttonText' => 'Subscribe Now', 'buttonClass' => 'w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg transition-colors font-medium'])

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="text-center mb-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $planDetails['name'] ?? ucfirst($planKey) }} Plan</h3>
        <div class="text-3xl font-bold text-purple-600 mb-2">
            ₦{{ number_format($planDetails['amount'] / 100) }}<span class="text-lg text-gray-500">/{$planDetails['billing'] ?? 'month'}</span>
        </div>
        @if(isset($planDetails['description']))
            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $planDetails['description'] }}</p>
        @endif
    </div>

    <!-- Paystack Payment Form -->
    <form method="POST" action="{{ route('subscription.initialize') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="plan" value="{{ $planKey }}">
        
        <!-- Email (auto-filled for authenticated users) -->
        <div>
            <label for="email_{{ $planKey }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Email Address
            </label>
            <input type="email" 
                   id="email_{{ $planKey }}" 
                   name="email" 
                   value="{{ auth()->user()->email ?? old('email') }}" 
                   required 
                   readonly="{{ auth()->check() ? 'readonly' : '' }}"
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white {{ auth()->check() ? 'bg-gray-50 dark:bg-gray-600' : '' }}">
        </div>

        <!-- Amount Display -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Amount to Pay
            </label>
            <div class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                ₦{{ number_format($planDetails['amount'] / 100) }} NGN
            </div>
        </div>

        <!-- Features List (if provided) -->
        @if(isset($planDetails['features']) && is_array($planDetails['features']))
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Plan Features:</h4>
                <ul class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                    @foreach($planDetails['features'] as $feature)
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Submit Button -->
        <button type="submit" 
                class="{{ $buttonClass }}"
                onclick="return confirm('Proceed with payment of ₦{{ number_format($planDetails['amount'] / 100) }}?')">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            {{ $buttonText }}
        </button>
    </form>

    <!-- Security Notice -->
    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-medium">Secure Payment</p>
                <p class="mt-1">Payments are processed securely through Paystack. Your card details are never stored on our servers.</p>
            </div>
        </div>
    </div>
</div>