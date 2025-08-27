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

        // Check for reserved seeded artist emails and usernames
        if ($role === 'artist' && $this->isSeededArtistCredential($request->email, $request->artist_stage_name)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('email', 'This email or artist name is reserved and cannot be used for registration. Please choose a different email and artist name.');
            });
        }

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
     * Check if email or artist name matches seeded artist credentials
     */
    private function isSeededArtistCredential($email, $artistName)
    {
        // List of seeded artist emails that are reserved
        $seededEmails = [
            'davido@nigerianartists.com',
            'rema@nigerianartists.com',
            'asake@nigerianartists.com',
            'fireboy@nigerianartists.com',
            'joeboy@nigerianartists.com',
            'omahlay@nigerianartists.com',
            'olamide@nigerianartists.com',
            'kissdaniel@nigerianartists.com',
            'mayorkun@nigerianartists.com',
            'nairamarley@nigerianartists.com',
            'yemialade@nigerianartists.com',
            'tekno@nigerianartists.com',
            'adekunlegold@nigerianartists.com',
            'falz@nigerianartists.com',
            'patoranking@nigerianartists.com',
            'timaya@nigerianartists.com',
            '2baba@nigerianartists.com',
            'phyno@nigerianartists.com',
            'oxlade@nigerianartists.com',
            // Also check existing admin dashboard seeded artists
            'admin@blogscript.com',
            'artist@test.com',
            'producer@test.com',
            'listener@test.com',
            'label@test.com'
        ];

        // List of seeded artist stage names/usernames that are reserved
        $seededArtistNames = [
            'Davido', 'davido',
            'Rema', 'rema',
            'Asake', 'asake',
            'Fireboy DML', 'fireboy',
            'Joeboy', 'joeboy',
            'Omah Lay', 'omahlay',
            'Olamide', 'olamide',
            'Kizz Daniel', 'kizzdaniel',
            'Mayorkun', 'mayorkun',
            'Naira Marley', 'nairamarley',
            'Yemi Alade', 'yemialade',
            'Tekno', 'tekno',
            'Adekunle Gold', 'adekunlegold',
            'Falz', 'falz',
            'Patoranking', 'patoranking',
            'Timaya', 'timaya',
            '2Baba', '2baba',
            'Phyno', 'phyno',
            'Oxlade', 'oxlade',
            // Also check existing admin dashboard seeded artists
            'Burna Boy', 'burnaboy',
            'Wizkid', 'wizkidayo',
            'Tiwa Savage', 'tiwasavage',
            'DJ Johnny'
        ];

        // Check if email is in reserved list
        if ($email && in_array(strtolower($email), array_map('strtolower', $seededEmails))) {
            return true;
        }

        // Check if artist stage name is in reserved list
        if ($artistName && in_array(strtolower($artistName), array_map('strtolower', $seededArtistNames))) {
            return true;
        }

        // Additional check: see if a user with artist role already exists with this email
        // and was created through seeding (has specific pattern in password or created early)
        $existingUser = User::where('email', $email)->where('role', 'artist')->first();
        if ($existingUser && $existingUser->created_at < now()->subHours(1)) {
            return true;
        }

        return false;
    }

    /**
     * Show pending approval page
     */
    public function showPending()
    {
        return view('auth.pending-approval');
    }
}
