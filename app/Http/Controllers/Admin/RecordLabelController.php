<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RecordLabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->role !== 'admin') {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of record labels.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'record_label')
                    ->withCount('music')
                    ->latest();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $recordLabels = $query->paginate(15)->withQueryString();
        
        // Get statistics
        $stats = [
            'total_labels' => User::where('role', 'record_label')->count(),
            'active_labels' => User::where('role', 'record_label')->where('status', 'approved')->count(),
            'pending_labels' => User::where('role', 'record_label')->where('status', 'pending')->count(),
            'suspended_labels' => User::where('role', 'record_label')->where('status', 'suspended')->count(),
        ];
        
        return view('admin.record-labels.index', compact('recordLabels', 'stats'));
    }

    /**
     * Show the form for creating a new record label.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.record-labels.create');
    }

    /**
     * Store a newly created record label in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
            'status' => 'required|in:approved,pending,suspended'
        ]);

        $validated['role'] = 'record_label';
        $validated['password'] = Hash::make($validated['password']);
        
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        if ($validated['status'] === 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = Auth::id();
        }

        User::create($validated);

        return redirect()->route('admin.record-labels.index')
                         ->with('success', 'Record label created successfully.');
    }

    /**
     * Display the specified record label.
     * 
     * @param  User  $recordLabel
     * @return \Illuminate\Http\Response
     */
    public function show(User $recordLabel)
    {
        if ($recordLabel->role !== 'record_label') {
            abort(404);
        }
        
        $recordLabel->loadCount('music');
        
        return view('admin.record-labels.show', compact('recordLabel'));
    }

    /**
     * Show the form for editing the specified record label.
     * 
     * @param  User  $recordLabel
     * @return \Illuminate\Http\Response
     */
    public function edit(User $recordLabel)
    {
        if ($recordLabel->role !== 'record_label') {
            abort(404);
        }
        
        return view('admin.record-labels.edit', compact('recordLabel'));
    }

    /**
     * Update the specified record label in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $recordLabel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $recordLabel)
    {
        if ($recordLabel->role !== 'record_label') {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $recordLabel->id,
            'password' => 'nullable|string|min:8|confirmed',
            'bio' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
            'status' => 'required|in:approved,pending,suspended'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        if ($validated['status'] === 'approved' && $recordLabel->status !== 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = Auth::id();
        }

        $recordLabel->update($validated);

        return redirect()->route('admin.record-labels.index')
                         ->with('success', 'Record label updated successfully.');
    }

    /**
     * Remove the specified record label from storage.
     * 
     * @param  User  $recordLabel
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $recordLabel)
    {
        if ($recordLabel->role !== 'record_label') {
            abort(404);
        }
        
        // Check if record label has music or artists associated
        $musicCount = $recordLabel->music()->count();
        
        if ($musicCount > 0) {
            return redirect()->back()
                           ->with('error', 'Cannot delete record label with associated music. Please transfer or remove music first.');
        }

        $recordLabel->delete();

        return redirect()->route('admin.record-labels.index')
                         ->with('success', 'Record label deleted successfully.');
    }

    /**
     * Approve a record label for active status.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $recordLabel = User::where('role', 'record_label')->findOrFail($id);
        
        $recordLabel->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Record label approved successfully.');
    }

    /**
     * Suspend a record label account.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function suspend($id)
    {
        $recordLabel = User::where('role', 'record_label')->findOrFail($id);
        
        $recordLabel->update(['status' => 'suspended']);

        return redirect()->back()->with('success', 'Record label suspended successfully.');
    }
}