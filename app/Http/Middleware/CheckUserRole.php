<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // If user status is not approved (except for listeners who are auto-approved)
        if ($user->status !== 'approved' && !$user->isListener()) {
            return redirect()->route('home')->with('error', 'Your account is pending approval.');
        }

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if ($this->userHasRole($user, $role)) {
                return $next($request);
            }
        }

        // User doesn't have required role
        return redirect()->route('dashboard')->with('error', 'Access denied. You do not have permission to access this resource.');
    }

    /**
     * Check if user has specific role
     */
    private function userHasRole($user, $role): bool
    {
        return match ($role) {
            'admin' => $user->isAdmin(),
            'artist' => $user->isArtist(),
            'record_label' => $user->isRecordLabel(),
            'listener' => $user->isListener(),
            'artist_or_label' => $user->isArtist() || $user->isRecordLabel(),
            default => false,
        };
    }
}