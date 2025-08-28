<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Toggle follow status for a user
     */
    public function toggle(User $user)
    {
        $currentUser = Auth::user();
        
        // Prevent users from following themselves
        if ($currentUser->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot follow yourself'
            ], 400);
        }

        $isFollowing = $currentUser->isFollowing($user);

        if ($isFollowing) {
            $currentUser->following()->detach($user->id);
            $action = 'unfollowed';
            $message = 'Unfollowed successfully';
        } else {
            $currentUser->following()->attach($user->id);
            $action = 'followed';
            $message = 'Following successfully';
        }

        return response()->json([
            'success' => true,
            'action' => $action,
            'message' => $message,
            'is_following' => !$isFollowing,
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count()
        ]);
    }

    /**
     * Get follow status for a user
     */
    public function status(User $user)
    {
        $currentUser = Auth::user();
        
        return response()->json([
            'is_following' => $currentUser ? $currentUser->isFollowing($user) : false,
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count()
        ]);
    }

    /**
     * Get user's followers
     */
    public function followers(User $user)
    {
        $followers = $user->followers()->with('profile')->paginate(20);
        
        return response()->json($followers);
    }

    /**
     * Get user's following
     */
    public function following(User $user)
    {
        $following = $user->following()->with('profile')->paginate(20);
        
        return response()->json($following);
    }
}