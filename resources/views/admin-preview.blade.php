@extends('layouts.app')

@section('title', 'Admin Dashboard Preview')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard Preview</h1>
                <div class="flex items-center space-x-4">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Demo Mode</span>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Enhanced Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Content Statistics -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">♪</div>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500 truncate">Total Music</p>
                            <p class="text-lg font-semibold text-gray-900">1,247</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white font-semibold">👥</div>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500 truncate">Total Users</p>
                            <p class="text-lg font-semibold text-gray-900">8,532</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">💰</div>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500 truncate">Revenue</p>
                            <p class="text-lg font-semibold text-gray-900">₦2,457,500.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">📊</div>
                        </div>
                        <div class="ml-5">
                            <p class="text-sm font-medium text-gray-500 truncate">Subscriptions</p>
                            <p class="text-lg font-semibold text-gray-900">456</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signup Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Today</p>
                            <p class="text-2xl font-bold text-green-600">23</p>
                        </div>
                        <div class="text-green-500">📈</div>
                    </div>
                    <p class="text-xs text-gray-400">New signups</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">This Week</p>
                            <p class="text-2xl font-bold text-blue-600">187</p>
                        </div>
                        <div class="text-blue-500">📊</div>
                    </div>
                    <p class="text-xs text-gray-400">New signups</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">This Month</p>
                            <p class="text-2xl font-bold text-purple-600">743</p>
                        </div>
                        <div class="text-purple-500">📅</div>
                    </div>
                    <p class="text-xs text-gray-400">New signups</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Pending Items -->
            <div class="lg:col-span-2">
                <!-- Pending Approvals -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pending Approvals</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Pending Users -->
                            <div class="block p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors cursor-pointer">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">12</div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Users</p>
                                        <p class="text-xs text-gray-500">Pending approval</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Uploads -->
                            <div class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors cursor-pointer">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">7</div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Uploads</p>
                                        <p class="text-xs text-gray-500">Pending review</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Verifications -->
                            <div class="block p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors cursor-pointer">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">3</div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Verifications</p>
                                        <p class="text-xs text-gray-500">Pending review</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Trending -->
                            <div class="block p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors cursor-pointer">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">5</div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Trending</p>
                                        <p class="text-xs text-gray-500">Pending review</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample User Management Table -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent User Activity</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">J</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">John Artist</div>
                                                <div class="text-xs text-gray-500">DJ Johnny</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Artist</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button class="text-blue-600 hover:text-blue-900" title="View"><i class="fas fa-eye"></i></button>
                                            <button class="text-green-600 hover:text-green-900" title="Edit"><i class="fas fa-edit"></i></button>
                                            <button class="text-yellow-600 hover:text-yellow-900" title="Suspend"><i class="fas fa-ban"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">S</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Sarah Producer</div>
                                                <div class="text-xs text-gray-500">Sound Wave Records</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Record Label</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button class="text-blue-600 hover:text-blue-900" title="View"><i class="fas fa-eye"></i></button>
                                            <button class="text-green-600 hover:text-green-900" title="Approve"><i class="fas fa-check"></i></button>
                                            <button class="text-red-600 hover:text-red-900" title="Reject"><i class="fas fa-times"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <button class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fas fa-user-plus mr-2"></i>Create User
                            </button>
                            <button class="block w-full bg-purple-600 text-white text-center py-3 rounded-lg hover:bg-purple-700 transition-colors font-medium">
                                <i class="fas fa-music mr-2"></i>Add Music
                            </button>
                            <button class="block w-full bg-green-600 text-white text-center py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                                <i class="fas fa-microphone mr-2"></i>Add Artist
                            </button>
                            <button class="block w-full bg-orange-600 text-white text-center py-3 rounded-lg hover:bg-orange-700 transition-colors font-medium">
                                <i class="fas fa-bell mr-2"></i>Send Notification
                            </button>
                        </div>
                    </div>
                </div>

                <!-- User Role Distribution -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">User Distribution</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-gray-500"></div>
                                    <span class="ml-2 text-sm font-medium text-gray-700">Listeners</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">6,342</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="ml-2 text-sm font-medium text-gray-700">Artists</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">1,847</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                    <span class="ml-2 text-sm font-medium text-gray-700">Record Labels</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">287</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="ml-2 text-sm font-medium text-gray-700">Editors</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">56</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection