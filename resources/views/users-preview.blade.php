<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Management - Enhanced</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto py-6 px-4">
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">All Users</h2>
                    <p class="text-sm text-gray-600">Comprehensive user management with subscription and verification controls</p>
                </div>
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add User
                </button>
            </div>
        </div>

        <!-- Enhanced Users Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distribution Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-100 transition-colors" id="user-row-{{ $user->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            @if($user->artist_stage_name)
                                                <div class="text-xs text-gray-500">{{ $user->artist_stage_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                           ($user->role === 'artist' ? 'bg-blue-100 text-blue-800' :
                                           ($user->role === 'record_label' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <select onchange="assignPlan({{ $user->id }}, this.value)" 
                                                class="text-xs px-2 py-1 border border-gray-300 bg-white text-gray-900 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                                            <option value="">No Plan</option>
                                            @foreach($pricingPlans as $plan)
                                                <option value="{{ $plan->id }}" 
                                                    {{ $user->subscription_plan_id == $plan->id ? 'selected' : '' }}>
                                                    {{ $plan->name }} (${{ $plan->amount }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($user->subscriptionPlan)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $user->subscription_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($user->subscription_status) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" id="distribution-price-{{ $user->id }}">
                                    <div class="flex items-center space-x-2">
                                        <div class="relative">
                                            <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500 text-xs">$</span>
                                            <input type="number" 
                                                   value="{{ $user->distribution_price ?? '' }}" 
                                                   placeholder="0.00"
                                                   step="0.01"
                                                   min="0"
                                                   max="999999.99"
                                                   onchange="updateDistributionPrice({{ $user->id }}, this.value)"
                                                   class="pl-6 pr-2 py-1 text-xs w-20 border border-gray-300 bg-white text-gray-900 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" id="status-{{ $user->id }}">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium status-badge
                                        {{ $user->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($user->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                    @if($user->approved_at)
                                        <div class="text-xs text-gray-500 mt-1">{{ $user->approved_at->diffForHumans() }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" id="verified-{{ $user->id }}">
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium verified-badge
                                            {{ $user->verification_status === 'verified' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            @if($user->verification_status === 'verified')
                                                <i class="fas fa-check-circle mr-1"></i>Verified
                                            @else
                                                <i class="fas fa-clock mr-1"></i>Unverified
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <!-- View -->
                                        <button class="text-green-600 hover:text-green-800" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Edit -->
                                        <button class="text-blue-600 hover:text-blue-800" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Status Actions -->
                                        @if($user->status === 'pending')
                                            <button onclick="approveUser({{ $user->id }})" 
                                                    class="text-green-600 hover:text-green-800" title="Approve User">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @elseif($user->status === 'approved')
                                            <button onclick="unapproveUser({{ $user->id }})" 
                                                    class="text-yellow-600 hover:text-yellow-800" title="Unapprove User">
                                                <i class="fas fa-minus-circle"></i>
                                            </button>
                                        @endif
                                        
                                        @if($user->status !== 'suspended')
                                            <button onclick="suspendUser({{ $user->id }})" 
                                                    class="text-red-600 hover:text-red-800" title="Suspend User">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        @else
                                            <button onclick="unsuspendUser({{ $user->id }})" 
                                                    class="text-green-600 hover:text-green-800" title="Reactivate User">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @endif
                                        
                                        <!-- Verification Actions -->
                                        @if($user->verification_status === 'verified')
                                            <button onclick="unverifyUser({{ $user->id }})" 
                                                    class="text-orange-600 hover:text-orange-800" title="Remove Verification">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        @else
                                            <button onclick="verifyUser({{ $user->id }})" 
                                                    class="text-blue-600 hover:text-blue-800" title="Verify User">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        @endif

                                        <!-- Delete (only for current user's own account) -->
                                        @if($user->id != 1)
                                            <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" 
                                                    class="text-red-600 hover:text-red-800" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <span class="text-gray-400" title="Current User">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-users text-3xl mb-2"></i>
                                        <p>No users found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 px-4 py-2 rounded shadow-lg transform translate-x-full transition-transform z-50 bg-green-500 text-white">
        <span id="toastMessage"></span>
    </div>

    <script>
        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded shadow-lg transform transition-transform z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            
            toastMessage.textContent = message;
            toast.classList.remove('translate-x-full');
            
            setTimeout(() => {
                toast.classList.add('translate-x-full');
            }, 3000);
        }

        function assignPlan(userId, planId) {
            console.log('Assigning plan', planId, 'to user', userId);
            showToast('Plan assignment functionality would work here');
        }

        function updateDistributionPrice(userId, price) {
            console.log('Updating distribution price to', price, 'for user', userId);
            showToast(`Distribution price updated: $${price || '0.00'}`);
        }

        function approveUser(userId) {
            console.log('Approving user', userId);
            showToast('User approved successfully!');
        }

        function unapproveUser(userId) {
            console.log('Unapproving user', userId);
            showToast('User marked as unapproved successfully!');
        }

        function suspendUser(userId) {
            console.log('Suspending user', userId);
            showToast('User suspended successfully!');
        }

        function unsuspendUser(userId) {
            console.log('Reactivating user', userId);
            showToast('User reactivated successfully!');
        }

        function verifyUser(userId) {
            console.log('Verifying user', userId);
            showToast('User verified successfully!');
        }

        function unverifyUser(userId) {
            console.log('Unverifying user', userId);
            showToast('User verification removed successfully!');
        }

        function deleteUser(userId, userName) {
            console.log('Deleting user', userId, userName);
            if (confirm(`Are you sure you want to delete user "${userName}"?`)) {
                showToast('User would be deleted here');
            }
        }
    </script>
</body>
</html>