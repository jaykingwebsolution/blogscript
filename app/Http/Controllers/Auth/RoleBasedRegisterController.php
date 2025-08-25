<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RoleBasedRegisterController extends Controller
{
    /**
     * Show role selection page
     */
    public function showRoleSelection()
    {
        return view('auth.select-role');
    }

    /**
     * Show registration form for specific role
     */
    public function showRegisterForm($role)
    {
        if (!in_array($role, ['listener', 'artist', 'record_label'])) {
            abort(404);
        }

        return view('auth.register-role', compact('role'));
    }

    /**
     * Handle role-based registration
     */
    public function register(Request $request, $role)
    {
        if (!in_array($role, ['listener', 'artist', 'record_label'])) {
            abort(404);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required',
        ];

        // Add role-specific validation rules
        if ($role === 'artist') {
            $rules['artist_stage_name'] = 'required|string|max:255';
            $rules['artist_genre'] = 'required|string|max:255';
            $rules['bio'] = 'nullable|string|max:1000';
        }

        if ($role === 'record_label') {
            $rules['bio'] = 'required|string|max:1000';
            $rules['website'] = 'nullable|url|max:255';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'status' => $role === 'listener' ? 'approved' : 'pending',
        ];

        // Add role-specific data
        if ($role === 'artist') {
            $userData['artist_stage_name'] = $request->artist_stage_name;
            $userData['artist_genre'] = $request->artist_genre;
            $userData['bio'] = $request->bio;
        }

        if ($role === 'record_label') {
            $userData['bio'] = $request->bio;
            if ($request->website) {
                $userData['social_links'] = ['website' => $request->website];
            }
        }

        // Auto-approve listeners, others need admin approval
        if ($role === 'listener') {
            $userData['approved_at'] = now();
        }

        $user = User::create($userData);

        // Auto-login listeners, redirect others to pending page
        if ($role === 'listener') {
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Welcome to our music platform!');
        } else {
            return redirect()->route('login')
                ->with('success', 'Registration successful! Your account is pending approval. You will be notified via email once approved.');
        }
    }

    /**
     * Show pending approval page
     */
    public function showPending()
    {
        return view('auth.pending-approval');
    }
}
