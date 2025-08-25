@extends('admin.layout')

@section('title', 'Manual Payment Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manual Payment #{{ $manualPayment->id }}</h1>
            <p class="text-gray-600">Review payment submission from {{ $manualPayment->user->name }}</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Information -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Payment Information</h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Reference</label>
                            <p class="text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded">{{ $manualPayment->transaction_reference }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                            <p class="text-gray-900 font-semibold text-lg text-green-600">{{ $manualPayment->formatted_amount }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Type</label>
                            <p class="text-gray-900 capitalize">{{ $manualPayment->payment_type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Plan</label>
                            <p class="text-gray-900">{{ $manualPayment->plan->name }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Submitted On</label>
                        <p class="text-gray-900">{{ $manualPayment->created_at->format('M d, Y \a\t H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">User Information</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-600">
                                {{ strtoupper(substr($manualPayment->user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $manualPayment->user->name }}</h3>
                            <p class="text-gray-500">{{ $manualPayment->user->email }}</p>
                            <p class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $manualPayment->user->role) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Proof -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">Payment Proof</h2>
                    @if($manualPayment->payment_proof)
                        <a href="{{ route('admin.manual-payments.download', $manualPayment) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Download Receipt
                        </a>
                    @endif
                </div>
                
                <div class="p-6">
                    @if($manualPayment->payment_proof)
                        <div class="border border-gray-200 rounded-lg p-4">
                            @if(Str::endsWith($manualPayment->payment_proof, ['.jpg', '.jpeg', '.png', '.gif']))
                                <img src="{{ $manualPayment->payment_proof_url }}" 
                                     alt="Payment Receipt" 
                                     class="max-w-full h-auto rounded-lg shadow-sm">
                            @else
                                <div class="flex items-center space-x-3">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <p class="text-gray-900 font-medium">PDF Receipt</p>
                                        <p class="text-gray-500 text-sm">Click download to view the receipt</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-500 italic">No payment proof uploaded</p>
                    @endif
                </div>
            </div>

            <!-- Admin Notes (if reviewed) -->
            @if($manualPayment->admin_notes)
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Admin Notes</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900">{{ $manualPayment->admin_notes }}</p>
                            @if($manualPayment->reviewer)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <p class="text-sm text-gray-500">
                                        Reviewed by {{ $manualPayment->reviewer->name }} on {{ $manualPayment->reviewed_at->format('M d, Y \a\t H:i') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Status</h2>
                </div>
                
                <div class="p-6 text-center">
                    @if($manualPayment->status === 'pending')
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-yellow-700 font-semibold text-lg">Pending Review</p>
                        <p class="text-gray-500 text-sm mt-1">Awaiting admin approval</p>
                    @elseif($manualPayment->status === 'approved')
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-green-700 font-semibold text-lg">Approved</p>
                        <p class="text-gray-500 text-sm mt-1">Payment has been approved</p>
                    @else
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <p class="text-red-700 font-semibold text-lg">Rejected</p>
                        <p class="text-gray-500 text-sm mt-1">Payment has been rejected</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if($manualPayment->isPending())
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Actions</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <!-- Approve Form -->
                        <form method="POST" action="{{ route('admin.manual-payments.approve', $manualPayment) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="approve_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Approval Notes (Optional)
                                </label>
                                <textarea id="approve_notes" 
                                          name="admin_notes" 
                                          rows="3"
                                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                          placeholder="Optional notes for approval..."></textarea>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors"
                                    onclick="return confirm('Are you sure you want to approve this payment?')">
                                Approve Payment
                            </button>
                        </form>

                        <hr class="border-gray-200">

                        <!-- Reject Button -->
                        <button onclick="showRejectModal()" 
                                class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                            Reject Payment
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
@if($manualPayment->isPending())
<div id="reject-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Payment</h3>
            <form method="POST" action="{{ route('admin.manual-payments.reject', $manualPayment) }}">
                @csrf
                <div class="mb-4">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for rejection (required)
                    </label>
                    <textarea id="admin_notes" 
                              name="admin_notes" 
                              rows="4" 
                              required
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Explain why this payment is being rejected..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="hideRejectModal()"
                            class="px-4 py-2 text-gray-500 hover:text-gray-700">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Reject Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('reject-modal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
    document.getElementById('admin_notes').value = '';
}

// Close modal when clicking outside
document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endif
@endsection