<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function show(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        $this->authorizeNotification($request, $notification);

        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        $url = data_get($notification->data, 'url');

        return $url
            ? redirect($url)
            : redirect()->route('admin.dashboard');
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()?->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    private function authorizeNotification(Request $request, DatabaseNotification $notification): void
    {
        if (
            $notification->notifiable_id !== $request->user()->id ||
            $notification->notifiable_type !== get_class($request->user())
        ) {
            abort(403);
        }
    }
}
