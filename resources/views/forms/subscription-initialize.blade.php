{{--
    Simple Subscription Initialization Form
    Used in dashboard and other subscription pages
    Usage: @include('forms.subscription-initialize', ['plan' => 'artist'])
--}}

@php
    $planOptions = [
        'artist' => [
            'name' => 'Artist Plan', 
            'amount' => 500000, // 5000 NGN in kobo
            'features' => ['Upload music', 'Artist profile', 'Basic analytics']
        ],
        'record_label' => [
            'name' => 'Record Label Plan', 
            'amount' => 1000000, // 10000 NGN in kobo
            'features' => ['Manage multiple artists', 'Advanced analytics', 'Distribution rights']
        ],
        'premium' => [
            'name' => 'Premium Plan', 
            'amount' => 200000, // 2000 NGN in kobo
            'features' => ['Ad-free listening', 'Offline downloads', 'High quality audio']
        ]
    ];
    
    $selectedPlan = $planOptions[$plan] ?? $planOptions['premium'];
@endphp

<form method="POST" action="{{ route('subscription.initialize') }}" class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
    @csrf
    <input type="hidden" name="plan" value="{{ $plan }}">
    
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            Subscribe to {{ $selectedPlan['name'] }}
        </h3>
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            ₦{{ number_format($selectedPlan['amount'] / 100) }} per month
        </p>
        
        @if(isset($selectedPlan['features']))
            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1 mb-4">
                @foreach($selectedPlan['features'] as $feature)
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    @auth
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Email Address
            </label>
            <input type="email" 
                   name="email" 
                   value="{{ auth()->user()->email }}" 
                   readonly 
                   class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-600 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-white">
        </div>
    @else
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Email Address
            </label>
            <input type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                   placeholder="Enter your email address">
            @error('email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    @endauth

    <button type="submit" 
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition-colors">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
        Pay ₦{{ number_format($selectedPlan['amount'] / 100) }} - Subscribe Now
    </button>
</form>