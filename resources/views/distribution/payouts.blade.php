@extends('layouts.app')

@section('title', 'Distribution Payouts')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Payout Management
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Request payouts and track your payment history
            </p>
        </div>

        <!-- Balance Overview -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <!-- Available Balance -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-wallet text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available Balance</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            ${{ number_format($availableBalance, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Earnings -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Earnings</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($totalEarnings, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Paid Out -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-money-bill-transfer text-purple-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Paid Out</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($totalPayouts, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pending Payouts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($pendingPayouts, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Payout Section -->
        @if($availableBalance >= 10)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Request Payout
                    </h3>
                    <button onclick="togglePayoutForm()" 
                            class="px-4 py-2 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                        <i class="fas fa-plus mr-2"></i>New Payout Request
                    </button>
                </div>

                <!-- Payout Form (Hidden by default) -->
                <div id="payout-form" class="hidden border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <form method="POST" action="{{ route('distribution.payout.request') }}" class="space-y-6">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Payout Amount <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">$</span>
                                    </div>
                                    <input type="number" 
                                           id="amount" 
                                           name="amount" 
                                           value="{{ old('amount') }}" 
                                           placeholder="0.00"
                                           step="0.01"
                                           min="10"
                                           max="{{ $availableBalance }}"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                           required>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Minimum: $10.00 | Available: ${{ number_format($availableBalance, 2) }}
                                </p>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label for="method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select id="method" 
                                        name="method" 
                                        onchange="updatePaymentFields()"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                        required>
                                    <option value="">Select Payment Method</option>
                                    <option value="bank_transfer" {{ old('method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="paypal" {{ old('method') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="mobile_money" {{ old('method') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                </select>
                            </div>
                        </div>

                        <!-- Payment Details (Dynamic based on method) -->
                        <div id="payment-details">
                            <!-- Bank Transfer Fields -->
                            <div id="bank-details" class="hidden">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Bank Account Details</h4>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <input type="text" name="payment_details[account_name]" placeholder="Account Holder Name" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <input type="text" name="payment_details[account_number]" placeholder="Account Number" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <input type="text" name="payment_details[bank_name]" placeholder="Bank Name" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <input type="text" name="payment_details[routing_number]" placeholder="Routing Number (Optional)" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                            </div>

                            <!-- PayPal Fields -->
                            <div id="paypal-details" class="hidden">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">PayPal Details</h4>
                                <input type="email" name="payment_details[paypal_email]" placeholder="PayPal Email Address" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>

                            <!-- Mobile Money Fields -->
                            <div id="mobile-details" class="hidden">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Mobile Money Details</h4>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <select name="payment_details[provider]" 
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                        <option value="">Select Provider</option>
                                        <option value="mtn">MTN Mobile Money</option>
                                        <option value="airtel">Airtel Money</option>
                                        <option value="vodafone">Vodafone Cash</option>
                                    </select>
                                    <input type="text" name="payment_details[phone_number]" placeholder="Phone Number" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" 
                                    onclick="togglePayoutForm()" 
                                    class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 bg-spotify-green text-white rounded-lg hover:bg-spotify-green/90 transition-colors font-medium">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Payout Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-yellow-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Minimum Payout Not Met</h3>
                        <p class="mt-2 text-sm text-yellow-700 dark:text-yellow-400">
                            You need at least $10.00 in available balance to request a payout. 
                            Current balance: ${{ number_format($availableBalance, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Payout History -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Payout History
                </h3>
            </div>

            @if($payouts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Method
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Reference
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Completed
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($payouts as $payout)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $payout->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $payout->formatted_amount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $payout->method_display_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $payout->status_color }}">
                                            {{ ucfirst($payout->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">
                                        {{ $payout->transaction_reference ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $payout->completed_at ? $payout->completed_at->format('M j, Y') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $payouts->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                        <i class="fas fa-money-bill-wave text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Payouts Yet</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Your payout history will appear here once you request your first payout.
                    </p>
                </div>
            @endif
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Payout Information</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Minimum payout amount is $10.00</li>
                            <li>Payouts are processed within 5 business days</li>
                            <li>Bank transfers may take 1-3 additional days to reflect in your account</li>
                            <li>PayPal payouts are typically instant once processed</li>
                            <li>Mobile money payouts are processed same-day</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePayoutForm() {
    const form = document.getElementById('payout-form');
    form.classList.toggle('hidden');
}

function updatePaymentFields() {
    const method = document.getElementById('method').value;
    const bankDetails = document.getElementById('bank-details');
    const paypalDetails = document.getElementById('paypal-details');
    const mobileDetails = document.getElementById('mobile-details');

    // Hide all details
    bankDetails.classList.add('hidden');
    paypalDetails.classList.add('hidden');
    mobileDetails.classList.add('hidden');

    // Show relevant details
    if (method === 'bank_transfer') {
        bankDetails.classList.remove('hidden');
    } else if (method === 'paypal') {
        paypalDetails.classList.remove('hidden');
    } else if (method === 'mobile_money') {
        mobileDetails.classList.remove('hidden');
    }
}
</script>
@endsection