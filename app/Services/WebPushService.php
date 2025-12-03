<?php

namespace App\Services;

use App\Models\PushSubscription;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class WebPushService
{
    public function send(PushSubscription $subscription, array $payload): bool
    {
        if (!class_exists(WebPush::class) || !class_exists(Subscription::class)) {
            return false;
        }

        $vapid = config('webpush.vapid');

        if (!($vapid['public_key'] ?? null) || !($vapid['private_key'] ?? null)) {
            return false;
        }

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => $vapid['subject'] ?? 'mailto:admin@localhost',
                'publicKey' => $vapid['public_key'],
                'privateKey' => $vapid['private_key'],
            ],
        ]);

        $webPush->setReuseVAPIDHeaders(true);

        $endpoint = Subscription::create([
            'endpoint' => $subscription->endpoint,
            'publicKey' => $subscription->public_key,
            'authToken' => $subscription->auth_token,
            'contentEncoding' => $subscription->content_encoding,
        ]);

        $jsonPayload = json_encode($payload, JSON_THROW_ON_ERROR);
        $webPush->queueNotification($endpoint, $jsonPayload);

        foreach ($webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                $message = $report->getReason() ?? 'Push delivery failed';
                Log::warning('Web push delivery failed', [
                    'endpoint' => Str::limit($subscription->endpoint, 60),
                    'reason' => $message,
                ]);

                return false;
            }
        }

        return true;
    }
}
