@extends('layouts.app')

@section('title', 'Admin - Subscriptions')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-50 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-gray-50 dark:bg-gray-900 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Subscription Management</h1>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-50 dark:bg-gray-900 divide-y divide-gray-200">
                            @forelse($subscriptions as $subscription)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" 
                                                 src="{{ $subscription->user->profile_picture ? asset('storage/' . $subscription->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($subscription->user->name) }}" 
                                                 alt="{{ $subscription->user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $subscription->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $subscription->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $subscription->plan_name === 'artist' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $subscription->plan_name === 'record_label' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $subscription->plan_name === 'premium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $subscription->plan_name === 'free' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $subscription->plan_name)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₦{{ number_format($subscription->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $subscription->status === 'expired' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $subscription->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $subscription->status === 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $subscription->expires_at ? $subscription->expires_at->format('M j, Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $subscription->created_at->format('M j, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No subscriptions found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($subscriptions->hasPages())
                <div class="mt-6">
                    {{ $subscriptions->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection