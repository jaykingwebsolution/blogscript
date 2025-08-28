@props(['user'])

@auth
<div class="follow-button-container" data-user-id="{{ $user->id }}">
    <button 
        class="follow-btn bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full font-medium transition-all duration-200 flex items-center space-x-2"
        onclick="toggleFollow({{ $user->id }})"
        data-following="false"
    >
        <svg class="w-4 h-4 follow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        <span class="follow-text">Follow</span>
    </button>
    
    <div class="follow-stats mt-2 text-sm text-gray-400">
        <span class="followers-count">{{ $user->followers_count ?? 0 }}</span> followers • 
        <span class="following-count">{{ $user->following_count ?? 0 }}</span> following
    </div>
</div>

<style>
.following {
    background-color: #4B5563 !important;
}
.following:hover {
    background-color: #EF4444 !important;
}
.following .follow-text {
    display: none;
}
.following .unfollow-text {
    display: inline;
}
.unfollow-text {
    display: none;
}
</style>

<script>
function toggleFollow(userId) {
    const container = document.querySelector(`[data-user-id="${userId}"]`);
    const button = container.querySelector('.follow-btn');
    const followText = container.querySelector('.follow-text');
    const followersCount = container.querySelector('.followers-count');
    const followIcon = container.querySelector('.follow-icon');
    
    // Disable button during request
    button.disabled = true;
    button.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span>Processing...</span>';
    
    fetch(`/users/${userId}/follow`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const isFollowing = data.is_following;
            
            // Update button state
            button.dataset.following = isFollowing;
            
            if (isFollowing) {
                button.classList.remove('bg-purple-600', 'hover:bg-purple-700');
                button.classList.add('bg-gray-600', 'hover:bg-red-600', 'following');
                followIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
                button.innerHTML = '<svg class="w-4 h-4 follow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span class="follow-text">Following</span><span class="unfollow-text">Unfollow</span>';
            } else {
                button.classList.remove('bg-gray-600', 'hover:bg-red-600', 'following');
                button.classList.add('bg-purple-600', 'hover:bg-purple-700');
                followIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>';
                button.innerHTML = '<svg class="w-4 h-4 follow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg><span class="follow-text">Follow</span>';
            }
            
            // Update counts
            followersCount.textContent = data.followers_count;
        } else {
            alert(data.message || 'An error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    })
    .finally(() => {
        button.disabled = false;
    });
}

// Initialize follow status on page load
document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.follow-button-container');
    containers.forEach(container => {
        const userId = container.dataset.userId;
        fetch(`/users/${userId}/follow-status`)
            .then(response => response.json())
            .then(data => {
                const button = container.querySelector('.follow-btn');
                const followersCount = container.querySelector('.followers-count');
                const followingCount = container.querySelector('.following-count');
                const followIcon = container.querySelector('.follow-icon');
                
                // Update counts
                followersCount.textContent = data.followers_count;
                followingCount.textContent = data.following_count;
                
                // Update button state
                if (data.is_following) {
                    button.dataset.following = true;
                    button.classList.remove('bg-purple-600', 'hover:bg-purple-700');
                    button.classList.add('bg-gray-600', 'hover:bg-red-600', 'following');
                    followIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
                    button.innerHTML = '<svg class="w-4 h-4 follow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span class="follow-text">Following</span><span class="unfollow-text">Unfollow</span>';
                }
            })
            .catch(error => console.error('Error loading follow status:', error));
    });
});
</script>
@else
<div class="follow-button-container">
    <a href="{{ route('login') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full font-medium transition-colors flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        <span>Follow</span>
    </a>
    
    <div class="follow-stats mt-2 text-sm text-gray-400">
        <span>{{ $user->followers_count ?? 0 }}</span> followers • 
        <span>{{ $user->following_count ?? 0 }}</span> following
    </div>
</div>
@endauth