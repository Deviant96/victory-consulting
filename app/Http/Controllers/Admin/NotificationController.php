<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, DatabaseNotification $notification)
    {
        abort_if($notification->notifiable_id !== $request->user()->getKey(), 403);

        $notification->markAsRead();

        $redirectUrl = $notification->data['url'] ?? null;

        return $redirectUrl
            ? redirect()->to($redirectUrl)
            : to_route('admin.notifications.index')->with('success', 'Notification marked as read.');
    }

    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}
