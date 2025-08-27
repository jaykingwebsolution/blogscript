@extends('admin.layout')

@section('title', 'Manage Subscription Plans')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Subscription Plans</h1>
        <a href="{{ route('admin.plans.create') }}" class="bg-spotify-green hover:bg-spotify-green-light text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>Create New Plan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-400 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($plans as $plan)
            <div class="bg-gray-50 dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ $plan->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $plan->type_display }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($plan->is_active)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">Inactive</span>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <div class="text-3xl font-bold text-purple-600">
                        @if($plan->isFree())
                            Free
                        @else
                            {{ $plan->currency }} {{ number_format($plan->price, 2) }}
                            <span class="text-sm font-normal text-gray-600 dark:text-gray-400">/{{ $plan->duration_days }} days</span>
                        @endif
                    </div>
                </div>

                @if($plan->description)
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Str::limit($plan->description, 100) }}</p>
                @endif

                @if($plan->features && count($plan->features) > 0)
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Features:</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            @foreach(array_slice($plan->features, 0, 3) as $feature)
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    {{ $feature }}
                                </li>
                            @endforeach
                            @if(count($plan->features) > 3)
                                <li class="text-gray-400 dark:text-gray-500">+{{ count($plan->features) - 3 }} more features</li>
                            @endif
                        </ul>
                    </div>
                @endif

                <div class="flex justify-between items-center mt-6">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $plan->subscriptions()->where('status', 'active')->count() }} subscribers
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.plans.edit', $plan) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($plan->subscriptions()->where('status', 'active')->count() == 0)
                            <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 dark:text-gray-500 text-6xl mb-4">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-600 dark:text-gray-400 mb-2">No Plans Found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Create your first subscription plan to get started.</p>
                <a href="{{ route('admin.plans.create') }}" class="bg-spotify-green hover:bg-spotify-green-light text-white px-6 py-3 rounded-lg font-medium">
                    Create Plan
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection