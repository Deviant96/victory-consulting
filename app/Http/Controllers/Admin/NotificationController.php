<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAllRead(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user) {
            $user->unreadNotifications()->update(['read_at' => now()]);
        }

        return redirect()->back();
    }
}
