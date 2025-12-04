<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Faq;
use App\Models\BlogPost;
use App\Models\Booking;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (empty($query)) {
            return response()->json([]);
        }

        $results = [
            [
                'type' => 'services',
                'label' => 'Services',
                'items' => $this->searchServices($query),
            ],
            [
                'type' => 'team',
                'label' => 'Team Members',
                'items' => $this->searchTeamMembers($query),
            ],
            [
                'type' => 'faqs',
                'label' => 'FAQs',
                'items' => $this->searchFaqs($query),
            ],
            [
                'type' => 'articles',
                'label' => 'Articles',
                'items' => $this->searchArticles($query),
            ],
            [
                'type' => 'bookings',
                'label' => 'Bookings',
                'items' => $this->searchBookings($query),
            ],
        ];

        return response()->json($results);
    }

    private function searchServices($query)
    {
        return Service::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($service) => [
                'id' => $service->id,
                'title' => $service->title,
                'subtitle' => $service->published ? 'Published' : 'Draft',
                'url' => route('admin.services.edit', $service),
            ])
            ->toArray();
    }

    private function searchTeamMembers($query)
    {
        return TeamMember::where('name', 'LIKE', "%{$query}%")
            ->orWhere('position', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($member) => [
                'id' => $member->id,
                'title' => $member->name,
                'subtitle' => $member->position,
                'url' => route('admin.team.edit', $member),
            ])
            ->toArray();
    }

    private function searchFaqs($query)
    {
        return Faq::where('question', 'LIKE', "%{$query}%")
            ->orWhere('answer', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($faq) => [
                'id' => $faq->id,
                'title' => $faq->question,
                'subtitle' => $faq->published ? 'Published' : 'Draft',
                'url' => route('admin.faqs.edit', $faq),
            ])
            ->toArray();
    }

    private function searchArticles($query)
    {
        return BlogPost::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($article) => [
                'id' => $article->id,
                'title' => $article->title,
                'subtitle' => $article->published_at ? 'Published' : 'Draft',
                'url' => route('admin.articles.edit', $article),
            ])
            ->toArray();
    }

    private function searchBookings($query)
    {
        return Booking::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('company', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($booking) => [
                'id' => $booking->id,
                'title' => $booking->name,
                'subtitle' => ucfirst($booking->status) . ' • ' . $booking->email,
                'url' => route('admin.bookings.show', $booking),
            ])
            ->toArray();
    }
}
