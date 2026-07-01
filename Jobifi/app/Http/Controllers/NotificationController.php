<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display the notifications page.
     */
   public function index(Request $request)
{
    $query = auth()->user()->notifications()->latest();

    if ($request->filter == 'unread') {
        $query->whereNull('read_at');
    }

    $notifications = $query->paginate(10);

    $unreadCount = auth()->user()
        ->unreadNotifications()
        ->count();

    return view('notifications.index', compact(
        'notifications',
        'unreadCount'
    ));
}

    /**
     * Fetch notifications via AJAX.
     */
   public function fetch(Request $request)
{
    $notifications = $request->user()
        ->notifications()
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($notification) {

            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? '',
                'message' => $notification->data['message'] ?? '',
                'type' => $notification->data['type'] ?? 'default',
                'url' => $notification->data['url'] ?? '#',
                'is_read' => !is_null($notification->read_at),
                'time' => $notification->created_at->diffForHumans(),
            ];

        });

    return response()->json([
        'success' => true,
        'unreadCount' => $request->user()->unreadNotifications()->count(),
        'notifications' => $notifications
    ]);
}
    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->markAsRead();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Delete a single notification.
     */
    public function destroy(Request $request, $id)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Delete all notifications.
     */
    public function clearAll(Request $request)
    {
        $request->user()
            ->notifications()
            ->delete();

        return response()->json([
            'success' => true
        ]);
    }
}