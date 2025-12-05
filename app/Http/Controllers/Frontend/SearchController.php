<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Return a lightweight search index for the public site.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $services = Service::published()
            ->select(['id', 'title', 'slug', 'summary'])
            ->orderBy('title')
            ->get()
            ->map(fn ($service) => [
                'title' => $service->title,
                'subtitle' => $service->summary,
                'url' => route('services.show', $service->slug),
                'type' => 'Service',
            ]);

        $team = TeamMember::select(['id', 'name', 'position'])
            ->orderBy('name')
            ->get()
            ->map(fn ($member) => [
                'title' => $member->name,
                'subtitle' => $member->position,
                'url' => route('team'),
                'type' => 'Team',
            ]);

        $articles = BlogPost::published()
            ->select(['id', 'title', 'slug', 'category', 'excerpt'])
            ->latest('published_at')
            ->latest('created_at')
            ->get()
            ->map(fn ($post) => [
                'title' => $post->title,
                'subtitle' => $post->category ?? $post->excerpt,
                'url' => route('blog.show', $post->slug),
                'type' => 'Article',
            ]);

        $contacts = collect([
            [
                'title' => 'Contact page',
                'subtitle' => 'Reach out to our team',
                'url' => route('contact'),
                'type' => 'Contact',
            ],
            [
                'title' => settings('site.phone'),
                'subtitle' => 'Call our team',
                'url' => settings('site.phone') ? 'tel:' . settings('site.phone') : null,
                'type' => 'Phone',
            ],
            [
                'title' => settings('site.email'),
                'subtitle' => 'Send us an email',
                'url' => settings('site.email') ? 'mailto:' . settings('site.email') : null,
                'type' => 'Email',
            ],
            [
                'title' => settings('site.address'),
                'subtitle' => 'Visit or mail us',
                'url' => settings('site.address') ? route('contact') . '#location' : null,
                'type' => 'Address',
            ],
            [
                'title' => 'LinkedIn',
                'subtitle' => 'Connect with us',
                'url' => settings('social.linkedin'),
                'type' => 'Social',
            ],
            [
                'title' => 'Twitter',
                'subtitle' => 'Follow our updates',
                'url' => settings('social.twitter'),
                'type' => 'Social',
            ],
            [
                'title' => 'Facebook',
                'subtitle' => 'Join our community',
                'url' => settings('social.facebook'),
                'type' => 'Social',
            ],
        ])->filter(fn ($contact) => filled($contact['title']) && filled($contact['url']))->values();

        return response()->json([
            'services' => $services,
            'team' => $team,
            'articles' => $articles,
            'contacts' => $contacts,
        ]);
    }
}
