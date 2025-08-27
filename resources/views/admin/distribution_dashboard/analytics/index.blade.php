@extends('layouts.admin-distribution')

@section('title', 'Distribution Analytics')

@section('header-title', 'Distribution Analytics & Reports')

@section('content')
<div class="space-y-8">
    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Total Revenue</p>
                    <p class="text-2xl font-bold text-white">${{ number_format($analytics['revenue_stats']['total_revenue'], 2) }}</p>
                    <p class="text-sm text-green-400 mt-1">+{{ $analytics['revenue_stats']['monthly_growth'] }}% this month</p>
                </div>
                <div class="p-3 bg-green-500/10 rounded-lg">
                    <i class="fas fa-dollar-sign text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Active Artists</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($analytics['revenue_stats']['active_artists']) }}</p>
                    <p class="text-sm text-distro-admin-accent mt-1">Distributing music</p>
                </div>
                <div class="p-3 bg-distro-admin-accent/10 rounded-lg">
                    <i class="fas fa-users text-distro-admin-accent text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">This Month</p>
                    <p class="text-2xl font-bold text-white">{{ end($analytics['monthly_submissions']['data']) }}</p>
                    <p class="text-sm text-yellow-400 mt-1">New submissions</p>
                </div>
                <div class="p-3 bg-yellow-500/10 rounded-lg">
                    <i class="fas fa-upload text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Monthly Submissions Chart -->
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <h3 class="text-lg font-semibold text-white mb-6">Monthly Submissions</h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                @foreach($analytics['monthly_submissions']['data'] as $index => $value)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-distro-admin-accent/20 rounded-t" 
                             style="height: {{ ($value / max($analytics['monthly_submissions']['data'])) * 200 }}px">
                            <div class="w-full bg-distro-admin-accent rounded-t" 
                                 style="height: {{ ($value / max($analytics['monthly_submissions']['data'])) * 100 }}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-2">{{ $analytics['monthly_submissions']['labels'][$index] }}</div>
                        <div class="text-sm font-medium text-white">{{ $value }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Platform Distribution -->
        <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
            <h3 class="text-lg font-semibold text-white mb-6">Platform Distribution</h3>
            <div class="space-y-4">
                @foreach($analytics['platform_distribution'] as $platform => $percentage)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full bg-distro-admin-accent"></div>
                            <span class="text-white">{{ $platform }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-20 bg-distro-admin-bg rounded-full h-2">
                                <div class="bg-distro-admin-accent h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-gray-400 text-sm">{{ $percentage }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-distro-admin-card rounded-lg border border-distro-admin-border overflow-hidden">
        <div class="px-6 py-4 border-b border-distro-admin-border">
            <h3 class="text-lg font-semibold text-white">Recent Activity</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-green-500/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white">New submission approved</p>
                        <p class="text-gray-400 text-sm">"Summer Vibes" by Artist Name - 2 hours ago</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-distro-admin-accent/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-upload text-distro-admin-accent"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white">New distribution request</p>
                        <p class="text-gray-400 text-sm">"Midnight Dreams" by Label Records - 4 hours ago</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-yellow-500/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white">Submission requires review</p>
                        <p class="text-gray-400 text-sm">"Electronic Beats" by DJ Producer - 6 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection