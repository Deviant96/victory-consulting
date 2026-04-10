<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class NewsletterSubscriptionController extends Controller
{
    public function index(): View
    {
        $subscribers = NewsletterSubscription::query()
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => NewsletterSubscription::count(),
            'this_month' => NewsletterSubscription::where('created_at', '>=', now()->startOfMonth())->count(),
            'today' => NewsletterSubscription::whereDate('created_at', now()->toDateString())->count(),
        ];

        return view('admin.newsletter-subscribers.index', compact('subscribers', 'stats'));
    }

    public function export(): Response
    {
        $subscribers = NewsletterSubscription::query()
            ->orderBy('created_at', 'desc')
            ->get(['email', 'source', 'created_at']);

        $output = fopen('php://temp', 'r+');
        fputcsv($output, ['Email', 'Source', 'Subscribed At']);

        foreach ($subscribers as $subscriber) {
            fputcsv($output, [
                $subscriber->email,
                $subscriber->source ?? 'website',
                optional($subscriber->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter_subscribers_' . now()->format('Ymd_His') . '.csv"',
        ]);
    }
}
