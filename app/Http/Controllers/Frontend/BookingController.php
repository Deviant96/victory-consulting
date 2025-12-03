<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\NewBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $booking = Booking::create($validated);

        $recipients = User::all();
        $pushEnabled = (bool) settings('booking.notifications.push_enabled', false);

        $notification = new NewBookingNotification($booking, $pushEnabled);

        Notification::send($recipients, $notification);

        return redirect()->back()->with('success', 'Thank you! Your booking request has been received.');
    }
}
