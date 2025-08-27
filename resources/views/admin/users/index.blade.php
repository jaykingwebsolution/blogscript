@extends('admin.layout')

@section('title', 'User Management')
@section('header', 'User Management')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">All Users</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive user management with subscription and verification controls</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-spotify-green hover:bg-spotify-green-light text-white px-4 py-2 rounded-md transition-colors">
            <i class="fas fa-plus mr-2"></i>Add User
        </a>
    </div>
</div>

<!-- Filter and Search -->
<div class="bg-gray-50 dark:bg-gray-900 shadow rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-spotify-green">
        </div>
        <div>
            <select name="role" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-spotify-green">
                <option value="">All Roles</option>
                <option value="listener" {{ request('role') == 'listener' ? 'selected' : '' }}>Listener</option>
                <option value="artist" {{ request('role') == 'artist' ? 'selected' : '' }}>Artist</option>
                <option value="record_label" {{ request('role') == 'record_label' ? 'selected' : '' }}>Record Label</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-spotify-green">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="bg-spotify-green hover:bg-spotify-green-light text-white px-4 py-2 rounded-md transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Enhanced Users Table -->
<div class="bg-gray-50 dark:bg-gray-900 shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Plan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Distribution Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Verified</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50 dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" id="user-row-{{ $user->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-spotify-green to-spotify-green-light rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                    @if($user->artist_stage_name)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->artist_stage_name }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 
                                   ($user->role === 'artist' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' :
                                   ($user->role === 'record_label' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300')) }}">
                                {{ ucwords(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <select onchange="assignPlan({{ $user->id }}, this.value)" 
                                        class="text-xs px-2 py-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded focus:outline-none focus:ring-1 focus:ring-spotify-green">
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
                                        {{ $user->subscription_status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
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
                                           class="pl-6 pr-2 py-1 text-xs w-20 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded focus:outline-none focus:ring-1 focus:ring-spotify-green">
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap" id="status-{{ $user->id }}">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium status-badge
                                {{ $user->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                   ($user->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                            @if($user->approved_at)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->approved_at->diffForHumans() }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap" id="verified-{{ $user->id }}">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium verified-badge
                                    {{ $user->verification_status === 'verified' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
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
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="text-spotify-green hover:text-spotify-green-light" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Edit -->
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if($user->id !== Auth::id())
                                    <!-- Status Actions -->
                                    @if($user->status === 'pending')
                                        <button onclick="approveUser({{ $user->id }})" 
                                                class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300" title="Approve User">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @elseif($user->status === 'approved')
                                        <button onclick="unapproveUser({{ $user->id }})" 
                                                class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300" title="Unapprove User">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                    @endif
                                    
                                    @if($user->status !== 'suspended')
                                        <button onclick="suspendUser({{ $user->id }})" 
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Suspend User">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @else
                                        <button onclick="unsuspendUser({{ $user->id }})" 
                                                class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300" title="Reactivate User">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @endif
                                    
                                    <!-- Verification Actions -->
                                    @if($user->role === 'artist' && $user->verification_status !== 'verified')
                                        <button onclick="verifyUser({{ $user->id }})" 
                                                class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300" title="Verify Artist (Override 30-day rule)">
                                            <i class="fas fa-certificate"></i>
                                        </button>
                                    @elseif($user->verification_status === 'verified')
                                        <button onclick="unverifyUser({{ $user->id }})" 
                                                class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300" title="Remove Verification">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    @endif
                                    
                                    <!-- Delete -->
                                    @if(!$user->isAdmin() || Auth::user()->isAdmin())
                                        <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" 
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Delete User">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                @else
                                    <span class="text-gray-400 dark:text-gray-500" title="Current User">
                                        <i class="fas fa-user"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $userTableColumnCount }}" class="px-6 py-8 text-center">
                            <div class="text-gray-500 dark:text-gray-400">
                                <i class="fas fa-users text-3xl mb-2"></i>
                                <p>No users found.</p>
                                @if(request()->hasAny(['search', 'role', 'status']))
                                    <p class="text-sm mt-1">Try adjusting your filters.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if(isset($users) && method_exists($users, 'links'))
    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>
@endif

<!-- Quick Stats -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-4">
    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-600 dark:text-green-300"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Approved</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $users->where('status', 'approved')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 dark:text-yellow-300"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $users->where('status', 'pending')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                <i class="fas fa-ban text-red-600 dark:text-red-300"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Suspended</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $users->where('status', 'suspended')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                <i class="fas fa-certificate text-purple-600 dark:text-purple-300"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Verified</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $users->where('verification_status', 'verified')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg shadow">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-blue-600 dark:text-blue-300"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $users->total() ?? $users->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2" id="modalTitle">Confirm Action</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4" id="modalMessage">Are you sure you want to perform this action?</p>
            <div class="flex space-x-3">
                <button onclick="executeAction()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded" id="confirmBtn">
                    Confirm
                </button>
                <button onclick="closeModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Toast -->
<div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transform translate-x-full transition-transform z-50">
    <span id="toastMessage"></span>
</div>

<script>
    let currentAction = null;
    let currentUserId = null;

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

    // Show confirmation modal
    function showModal(title, message, action, userId) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalMessage').textContent = message;
        document.getElementById('confirmModal').classList.remove('hidden');
        currentAction = action;
        currentUserId = userId;
    }

    // Close modal
    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        currentAction = null;
        currentUserId = null;
    }

    // Execute confirmed action
    function executeAction() {
        if (currentAction && currentUserId) {
            currentAction(currentUserId);
        }
        closeModal();
    }

    // User management functions
    function approveUser(userId) {
        makeRequest(`/admin/users/${userId}/approve`, 'POST', (data) => {
            updateStatusBadge(userId, 'approved', 'Approved');
            showToast('User approved successfully!');
        });
    }

    function unapproveUser(userId) {
        makeRequest(`/admin/users/${userId}/unapprove`, 'POST', (data) => {
            updateStatusBadge(userId, 'pending', 'Pending');
            showToast('User marked as unapproved successfully!');
        });
    }

    function suspendUser(userId) {
        makeRequest(`/admin/users/${userId}/suspend`, 'POST', (data) => {
            updateStatusBadge(userId, 'suspended', 'Suspended');
            showToast('User suspended successfully!');
        });
    }

    function unsuspendUser(userId) {
        makeRequest(`/admin/users/${userId}/unsuspend`, 'POST', (data) => {
            updateStatusBadge(userId, 'approved', 'Approved');
            showToast('User reactivated successfully!');
        });
    }

    function verifyUser(userId) {
        makeRequest(`/admin/users/${userId}/verify`, 'POST', (data) => {
            updateVerificationBadge(userId, true);
            showToast('Artist verified successfully! (30-day rule overridden)');
        });
    }

    function unverifyUser(userId) {
        makeRequest(`/admin/users/${userId}/unverify`, 'POST', (data) => {
            updateVerificationBadge(userId, false);
            showToast('User verification removed successfully!');
        });
    }

    function assignPlan(userId, planId) {
        const formData = new FormData();
        formData.append('plan_id', planId);
        
        makeRequest(`/admin/users/${userId}/assign-plan`, 'POST', (data) => {
            showToast(`Subscription plan updated to: ${data.plan_name}`);
        }, formData);
    }

    function updateDistributionPrice(userId, price) {
        const formData = new FormData();
        formData.append('distribution_price', price);
        
        makeRequest(`/admin/users/${userId}/update-distribution-price`, 'POST', (data) => {
            showToast(`Distribution price updated: $${data.distribution_price || '0.00'}`);
        }, formData);
    }

    function deleteUser(userId, userName) {
        showModal(
            'Delete User',
            `Are you sure you want to permanently delete "${userName}"? This action cannot be undone.`,
            (id) => {
                makeRequest(`/admin/users/${id}`, 'DELETE', () => {
                    document.getElementById(`user-row-${id}`).remove();
                    showToast('User deleted successfully!');
                });
            },
            userId
        );
    }

    // Update status badge
    function updateStatusBadge(userId, status, statusText) {
        const statusElement = document.querySelector(`#status-${userId} .status-badge`);
        if (statusElement) {
            statusElement.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium status-badge ${
                status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                (status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300')
            }`;
            statusElement.textContent = statusText;
        }
    }

    // Update verification badge
    function updateVerificationBadge(userId, isVerified) {
        const verifiedElement = document.querySelector(`#verified-${userId} .verified-badge`);
        if (verifiedElement) {
            verifiedElement.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium verified-badge ${
                isVerified ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
            }`;
            verifiedElement.innerHTML = isVerified 
                ? '<i class="fas fa-check-circle mr-1"></i>Verified'
                : '<i class="fas fa-clock mr-1"></i>Unverified';
        }
    }

    // Generic AJAX request function
    function makeRequest(url, method, callback, formData = null) {
        const options = {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        };

        if (formData) {
            options.body = formData;
        } else if (method === 'POST' || method === 'PUT') {
            options.headers['Content-Type'] = 'application/json';
        }

        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callback(data);
                } else {
                    showToast(data.message || 'An error occurred', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred while processing the request', 'error');
            });
    }
</script>

@endsection