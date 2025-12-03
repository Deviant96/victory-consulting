<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\NewBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Services\WebPushService;

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

        // Send email notification separately to avoid WebPush channel issues
        if ($sendEmail && $notificationEmail) {
            $emailNotification = new NewBookingNotification($booking, true, false);
            Notification::route('mail', $notificationEmail)->notify($emailNotification);
        }

        // Send push notifications to admin users
        if ($sendPush) {
            $admins = User::with('pushSubscriptions')->get();
            
            // Only send notifications to admins who have push subscriptions
            $adminsWithSubscriptions = $admins->filter(fn($admin) => $admin->pushSubscriptions->isNotEmpty());
            
            if ($adminsWithSubscriptions->isNotEmpty()) {
                $pushNotification = new NewBookingNotification($booking, false, true);
                
                // Send database and broadcast notifications
                Notification::send($adminsWithSubscriptions, $pushNotification);

                // Send web push notifications manually
                $webPushPayload = $pushNotification->toWebPushPayload();
                $webPushService = app(WebPushService::class);

                foreach ($adminsWithSubscriptions as $admin) {
                    foreach ($admin->pushSubscriptions as $subscription) {
                        $webPushService->send($subscription, $webPushPayload);
                    }
                }
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Your consultation request has been submitted. We will confirm the details shortly.');
    }
}
