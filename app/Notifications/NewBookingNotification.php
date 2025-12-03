<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking, public bool $pushEnabled = false)
    {
        $this->pushEnabled = $pushEnabled ?: (bool) settings('booking.notifications.push_enabled', false);
    }

    public function via(object $notifiable): array
    {
        $channels = ['mail', 'database'];

        if ($this->pushEnabled) {
            $channels[] = 'broadcast';

            if (class_exists('\\NotificationChannels\\WebPush\\WebPushChannel')) {
                $channels[] = 'webpush';
            }
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Booking Request')
            ->greeting('Hello!')
            ->line('A new booking was submitted on the site.')
            ->line('Name: ' . $this->booking->name)
            ->line('Email: ' . $this->booking->email)
            ->lineIf($this->booking->phone, 'Phone: ' . $this->booking->phone)
            ->lineIf($this->booking->subject, 'Subject: ' . $this->booking->subject)
            ->lineIf($this->booking->message, 'Message: ' . $this->booking->message)
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'name' => $this->booking->name,
            'email' => $this->booking->email,
            'phone' => $this->booking->phone,
            'subject' => $this->booking->subject,
            'message' => $this->booking->message,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => 'New Booking Request',
            'body' => $this->booking->name . ' submitted a new booking.',
            'booking' => $this->toArray($notifiable),
        ]);
    }

    public function toWebPush(object $notifiable, $notification = null): array
    {
        return [
            'title' => 'New Booking Request',
            'body' => $this->booking->name . ' submitted a new booking.',
            'data' => [
                'booking_id' => $this->booking->id,
            ],
        ];
    }

    public function onWebPushRoute($subscription): self
    {
        $this->pushEnabled = true;

        return $this;
    }
}
