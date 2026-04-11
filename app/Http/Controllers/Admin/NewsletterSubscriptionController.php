<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsletterSubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $source = $request->input('source');

        $query = NewsletterSubscription::query()->latest();

        if ($search) {
            $query->where('email', 'like', '%' . $search . '%');
        }

        if ($source) {
            $query->where('source', $source);
        }

        $subscribers = $query->paginate(20)->withQueryString();

        $aggregate = NewsletterSubscription::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as this_month,
            SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as today
        ", [now()->startOfMonth(), now()->toDateString()])->first();

        $stats = [
            'total'      => (int) $aggregate->total,
            'this_month' => (int) $aggregate->this_month,
            'today'      => (int) $aggregate->today,
        ];

        $sources = NewsletterSubscription::query()
            ->whereNotNull('source')
            ->distinct()
            ->orderBy('source')
            ->pluck('source');

        return view('admin.newsletter-subscribers.index', compact('subscribers', 'stats', 'sources', 'search', 'source'));
    }

    public function destroy(NewsletterSubscription $newsletterSubscriber): RedirectResponse
    {
        $newsletterSubscriber->delete();

        return redirect()->route('admin.newsletter-subscribers.index')
            ->with('success', 'Subscriber removed successfully.');
    }

    public function export(Request $request): Response
    {
        $search = $request->input('search');
        $source = $request->input('source');

        $query = NewsletterSubscription::query()->orderBy('created_at', 'desc');

        if ($search) {
            $query->where('email', 'like', '%' . $search . '%');
        }

        if ($source) {
            $query->where('source', $source);
        }

        $subscribers = $query->get(['email', 'source', 'created_at']);

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
