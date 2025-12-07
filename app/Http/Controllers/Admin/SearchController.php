<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Faq;
use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\BusinessSolution;
use App\Models\WhyChooseItem;
use App\Models\Language;
use App\Models\TranslationKey;
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
            [
                'type' => 'business_solutions',
                'label' => 'Business Solutions',
                'items' => $this->searchBusinessSolutions($query),
            ],
            [
                'type' => 'why_choose',
                'label' => 'Why Choose Items',
                'items' => $this->searchWhyChooseItems($query),
            ],
            [
                'type' => 'languages',
                'label' => 'Languages',
                'items' => $this->searchLanguages($query),
            ],
            [
                'type' => 'translations',
                'label' => 'Translations',
                'items' => $this->searchTranslations($query),
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

    private function searchBusinessSolutions($query)
    {
        return BusinessSolution::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($solution) => [
                'id' => $solution->id,
                'title' => $solution->title,
                'subtitle' => $solution->is_active ? 'Active' : 'Inactive',
                'url' => route('admin.business-solutions.edit', $solution),
            ])
            ->toArray();
    }

    private function searchWhyChooseItems($query)
    {
        return WhyChooseItem::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'title' => $item->title,
                'subtitle' => $item->is_active ? 'Active' : 'Inactive',
                'url' => route('admin.why-choose-items.edit', $item),
            ])
            ->toArray();
    }

    private function searchLanguages($query)
    {
        return Language::where('code', 'LIKE', "%{$query}%")
            ->orWhere('label', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($language) => [
                'id' => $language->id,
                'title' => $language->label . ' (' . strtoupper($language->code) . ')',
                'subtitle' => $language->is_active ? 'Active' : 'Inactive',
                'url' => route('admin.languages.edit', $language),
            ])
            ->toArray();
    }

    private function searchTranslations($query)
    {
        return TranslationKey::where('key', 'LIKE', "%{$query}%")
            ->orWhere('group', 'LIKE', "%{$query}%")
            ->orWhereHas('values', function ($q) use ($query) {
                $q->where('value', 'LIKE', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(fn($translation) => [
                'id' => $translation->id,
                'title' => $translation->key,
                'subtitle' => $translation->group ? 'Group: ' . $translation->group : 'No group',
                'url' => route('admin.translations.edit', $translation),
            ])
            ->toArray();
    }
}
