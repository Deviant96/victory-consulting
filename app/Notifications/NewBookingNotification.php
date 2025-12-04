<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewBookingNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Booking $booking,
        public bool $sendEmail = true,
        public bool $sendPush = true
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = [];

        if ($this->sendEmail) {
            $channels[] = 'mail';
        }

        if ($this->sendPush) {
            $channels[] = 'database';
            $channels[] = 'broadcast';
            
            // WebPush is handled manually in the controller to avoid issues
            // with the WebPushChannel trying to access pushSubscriptions collection
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Booking Request from ' . $this->booking->name)
            ->greeting('New booking request received')
            ->line('Name: ' . $this->booking->name)
            ->line('Email: ' . $this->booking->email)
            ->lineIf($this->booking->phone, 'Phone: ' . $this->booking->phone)
            ->lineIf($this->booking->company, 'Company: ' . $this->booking->company)
            ->lineIf($this->booking->service_interest, 'Service: ' . $this->booking->service_interest)
            ->lineIf($this->booking->preferred_date, 'Preferred Date: ' . optional($this->booking->preferred_date)->format('M d, Y'))
            ->lineIf($this->booking->preferred_time, 'Preferred Time: ' . $this->booking->preferred_time)
            ->lineIf($this->booking->message, 'Message: ' . $this->booking->message)
            ->action('View booking in dashboard', route('admin.bookings.show', $this->booking))
            ->line('Thank you for using our booking form.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New booking request',
            'message' => $this->booking->service_interest
                ? 'Service: ' . $this->booking->service_interest
                : 'A new consultation request is ready to review.',
            'url' => route('admin.bookings.show', $this->booking),
            'booking_id' => $this->booking->id,
            'name' => $this->booking->name,
            'email' => $this->booking->email,
            'service' => $this->booking->service_interest,
            'preferred_date' => optional($this->booking->preferred_date)->toDateString(),
            'preferred_time' => $this->booking->preferred_time,
            'message_body' => $this->booking->message,
            'status' => $this->booking->status,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage(
            $this->toArray($notifiable) + [
                'title' => 'New booking request',
                'url' => route('admin.bookings.show', $this->booking),
            ]
        );
    }

    public function toWebPush(object $notifiable): ?WebPushMessage
    {
        if (!class_exists(WebPushMessage::class)) {
            return null;
        }

        $payload = $this->toWebPushPayload();

        return (new WebPushMessage())
            ->title($payload['title'])
            ->body($payload['body'])
            ->icon($payload['icon'])
            ->action('View booking', $payload['url'])
            ->tag($payload['tag'])
            ->data($payload);
    }

    public function toWebPushPayload(): array
    {
        return [
            'title' => 'New booking from ' . $this->booking->name,
            'body' => $this->booking->service_interest
                ? 'Service: ' . $this->booking->service_interest
                : 'A new consultation request is ready to review.',
            'url' => route('admin.bookings.show', $this->booking),
            'icon' => asset('favicon.ico'),
            'tag' => 'booking-' . $this->booking->id,
        ];
    }
}
