<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\UserNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $notifications = AdminNotification::latest()->paginate(15);
            return view('admin.notifications.index', compact('notifications'));
        } else {
            // Return JSON for AJAX requests
            if (request()->ajax()) {
                $notifications = AdminNotification::getActiveForUser(auth()->user())->take(10);
                return response()->json([
                    'notifications' => $notifications->map(function($notification) {
                        return [
                            'id' => $notification->id,
                            'title' => $notification->title,
                            'message' => Str::limit($notification->message, 80),
                            'type' => $notification->type,
                            'icon_class' => $notification->icon_class,
                            'action_url' => $notification->action_url,
                            'created_at' => $notification->created_at->diffForHumans(),
                        ];
                    }),
                    'count' => AdminNotification::getActiveForUser(auth()->user())->count()
                ]);
            }
            
            $notifications = AdminNotification::getActiveForUser(auth()->user())->take(50);
            return view('dashboard.notifications', compact('notifications'));
        }
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:feature,trending_song,trending_artist,general',
            'is_global' => 'boolean',
            'target_roles' => 'nullable|array',
            'target_roles.*' => 'in:listener,artist,record_label,admin',
            'action_url' => 'nullable|url',
            'icon' => 'nullable|string',
            'expires_at' => 'nullable|date|after:now'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $validator->validated();
        $data['is_global'] = $request->has('is_global') || empty($data['target_roles']);
        $data['is_active'] = true;

        $notification = AdminNotification::create($data);

        return redirect()->route('admin.notifications.index')
                       ->with('success', 'Notification created successfully!');
    }

    public function show(AdminNotification $adminNotification)
    {
        return view('admin.notifications.show', compact('adminNotification'));
    }

    public function edit(AdminNotification $adminNotification)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        return view('admin.notifications.edit', compact('adminNotification'));
    }

    public function update(Request $request, AdminNotification $adminNotification)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:feature,trending_song,trending_artist,general',
            'is_global' => 'boolean',
            'target_roles' => 'nullable|array',
            'target_roles.*' => 'in:listener,artist,record_label,admin',
            'action_url' => 'nullable|url',
            'icon' => 'nullable|string',
            'expires_at' => 'nullable|date|after:now',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $validator->validated();
        $data['is_global'] = $request->has('is_global') || empty($data['target_roles']);
        $data['is_active'] = $request->has('is_active');

        $adminNotification->update($data);

        return redirect()->route('admin.notifications.index')
                       ->with('success', 'Notification updated successfully!');
    }

    public function destroy(AdminNotification $adminNotification)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $adminNotification->delete();

        return redirect()->route('admin.notifications.index')
                       ->with('success', 'Notification deleted successfully!');
    }

    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('notification_id');
        $user = auth()->user();

        if (!$notificationId) {
            return response()->json(['error' => 'Notification ID required'], 400);
        }

        $notification = AdminNotification::find($notificationId);
        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        // Create or update user notification record
        UserNotification::updateOrCreate([
            'user_id' => $user->id,
            'admin_notification_id' => $notificationId,
        ], [
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
        $activeNotifications = AdminNotification::getActiveForUser($user);

        foreach ($activeNotifications as $notification) {
            UserNotification::updateOrCreate([
                'user_id' => $user->id,
                'admin_notification_id' => $notification->id,
            ], [
                'is_read' => true,
                'read_at' => now()
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = AdminNotification::getActiveForUser(auth()->user())->count();
        return response()->json(['count' => $count]);
    }
}
