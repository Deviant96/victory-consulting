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
            'company' => 'nullable|string|max:255',
            'service_interest' => 'nullable|string|max:255',
            'preferred_date' => 'nullable|date',
            'preferred_time' => 'nullable|string|max:100',
            'message' => 'nullable|string',
        ]);

        $booking = Booking::create($validated);

        $sendEmail = filter_var(settings('booking.notifications.email.enabled', true), FILTER_VALIDATE_BOOL);
        $notificationEmail = settings('booking.notifications.email.address', config('mail.from.address'));
        $sendPush = filter_var(settings('booking.notifications.push.enabled', true), FILTER_VALIDATE_BOOL);

        $notification = new NewBookingNotification($booking, $sendEmail, $sendPush);

        if ($sendEmail && $notificationEmail) {
            Notification::route('mail', $notificationEmail)->notify($notification);
        }

        if ($sendPush) {
            $admins = User::all();
            Notification::send($admins, $notification);
        }

        return redirect()
            ->back()
            ->with('success', 'Your consultation request has been submitted. We will confirm the details shortly.');
    }
}
