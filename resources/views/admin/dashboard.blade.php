@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
@php
    $statCards = [
        [
            'label' => 'Services',
            'value' => $stats['services'] ?? 0,
            'formatted' => number_format($stats['services'] ?? 0),
            'change' => '+ New this month',
            'color' => 'blue',
            'link' => route('admin.services.index'),
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
        [
            'label' => 'Team Members',
            'value' => $stats['team'] ?? 0,
            'formatted' => number_format($stats['team'] ?? 0),
            'change' => 'Hiring in progress',
            'color' => 'emerald',
            'link' => route('admin.team.index'),
            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        ],
        [
            'label' => 'FAQs',
            'value' => $stats['faqs'] ?? 0,
            'formatted' => number_format($stats['faqs'] ?? 0),
            'change' => 'Knowledge base',
            'color' => 'amber',
            'link' => route('admin.faqs.index'),
            'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'label' => 'Articles',
            'value' => $stats['articles'] ?? 0,
            'formatted' => number_format($stats['articles'] ?? 0),
            'change' => 'Editorial calendar',
            'color' => 'purple',
            'link' => route('admin.articles.index'),
            'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
        ],
    ];

    $quickActions = [
        [
            'title' => 'Create service',
            'description' => 'Add a new offering and publish it instantly.',
            'href' => route('admin.services.create'),
            'color' => 'blue',
            'icon' => 'M12 4v16m8-8H4',
        ],
        [
            'title' => 'Add team member',
            'description' => 'Keep your leadership and delivery roster current.',
            'href' => route('admin.team.create'),
            'color' => 'emerald',
            'icon' => 'M5 13l4 4L19 7',
        ],
        [
            'title' => 'Publish article',
            'description' => 'Share new insights with the community.',
            'href' => route('admin.articles.create'),
            'color' => 'purple',
            'icon' => 'M12 6v12m6-6H6',
        ],
        [
            'title' => 'Update settings',
            'description' => 'Refresh contact, social, and branding details.',
            'href' => route('admin.settings.contact'),
            'color' => 'amber',
            'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
        ],
    ];

    $pendingBookings = $bookingStatusCounts['pending'] ?? 0;
    $totalBookings = $stats['bookings'] ?? 0;
@endphp

<div class="space-y-8">
    <section class="grid gap-6 xl:grid-cols-3">
        <div x-data="cardState('hero')" class="xl:col-span-2 bg-gradient-to-br from-indigo-700 via-blue-700 to-sky-600 text-white rounded-3xl shadow-xl ring-1 ring-white/10 p-6 sm:p-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_45%)] pointer-events-none"></div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Admin overview</p>
                    <h1 class="text-2xl sm:text-3xl font-semibold drop-shadow">Welcome back</h1>
                    <p class="text-sm text-blue-100/90 max-w-xl">Monitor performance, curate fresh content, and keep communication flowing smoothly—all from one streamlined dashboard.</p>
                </div>
                <div class="bg-white/15 backdrop-blur border border-white/30 rounded-2xl px-4 py-3 w-full sm:w-64 shadow-lg shadow-blue-900/20">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-blue-50">Pending bookings</span>
                        <span class="text-white font-semibold">{{ number_format($pendingBookings) }}</span>
                    </div>
                    <div class="mt-3 h-2 rounded-full bg-white/25 overflow-hidden">
                        <div class="h-full bg-white rounded-full shadow-inner shadow-blue-900/40" style="width: {{ $totalBookings > 0 ? min(100, ($pendingBookings / max($totalBookings, 1)) * 100) : 12 }}%"></div>
                    </div>
                    <p class="mt-3 text-xs text-blue-50">Stay responsive to requests and keep prospects moving forward.</p>
                </div>
                <button @click="toggle" class="absolute top-2 right-2 text-blue-50/80 hover:text-white transition" title="Toggle card">
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-3" x-show="open" x-transition.opacity x-cloak>
                <div class="bg-white/15 border border-white/20 rounded-2xl p-3 shadow-sm shadow-blue-900/10">
                    <p class="text-xs text-blue-50">Services live</p>
                    <p class="text-xl font-semibold">{{ number_format($stats['services'] ?? 0) }}</p>
                </div>
                <div class="bg-white/15 border border-white/20 rounded-2xl p-3 shadow-sm shadow-blue-900/10">
                    <p class="text-xs text-blue-50">Published articles</p>
                    <p class="text-xl font-semibold">{{ number_format($stats['articles'] ?? 0) }}</p>
                </div>
                <div class="bg-white/15 border border-white/20 rounded-2xl p-3 shadow-sm shadow-blue-900/10">
                    <p class="text-xs text-blue-50">FAQs maintained</p>
                    <p class="text-xl font-semibold">{{ number_format($stats['faqs'] ?? 0) }}</p>
                </div>
                <div class="bg-white/15 border border-white/20 rounded-2xl p-3 shadow-sm shadow-blue-900/10">
                    <p class="text-xs text-blue-50">Bookings logged</p>
                    <p class="text-xl font-semibold">{{ number_format($stats['bookings'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        <div x-data="cardState('today')" class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6 flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Today</p>
                    <h3 class="text-lg font-semibold text-gray-900">Operations snapshot</h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-full">Live</span>
                    <button @click="toggle" class="text-gray-400 hover:text-gray-700 transition" title="Toggle card">
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="space-y-3" x-show="open" x-transition.opacity x-cloak>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <p class="text-sm text-gray-700">Content pieces</p>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format(($stats['articles'] ?? 0) + ($stats['faqs'] ?? 0)) }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <p class="text-sm text-gray-700">Active clients</p>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format($stats['bookings'] ?? 0) }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <p class="text-sm text-gray-700">Team collaborators</p>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">{{ number_format($stats['team'] ?? 0) }}</p>
                </div>
            </div>
            <div class="rounded-2xl bg-gray-50 border border-dashed border-gray-200 px-4 py-3" x-show="open" x-transition.opacity x-cloak>
                <p class="text-sm text-gray-700 font-medium">Next actions</p>
                <p class="text-xs text-gray-500 mt-1">Review bookings, add fresh content, and keep FAQs concise.</p>
            </div>
        </div>
    </section>

    <section x-data="cardState('stats')" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="flex items-center justify-between md:col-span-2 xl:col-span-4 mb-1" x-show="true">
            <h3 class="text-sm font-semibold text-gray-700">Snapshot</h3>
            <button @click="toggle" class="text-gray-400 hover:text-gray-700 transition" title="Toggle cards">
                <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
                <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
        <template x-if="open">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 col-span-full">
                @foreach ($statCards as $card)
                    <a href="{{ $card['link'] }}" class="group relative overflow-hidden bg-white border border-gray-200 rounded-2xl shadow-sm p-5 transition transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition bg-gradient-to-br from-{{ $card['color'] }}-50 via-white to-white pointer-events-none"></div>
                        <div class="relative flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ $card['label'] }}</p>
                                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $card['formatted'] }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $card['change'] }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-{{ $card['color'] }}-100 text-{{ $card['color'] }}-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                                </svg>
                            </div>
                        </div>
                        <div class="relative mt-4 h-2 w-full rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-{{ $card['color'] }}-400 to-{{ $card['color'] }}-500" style="width: {{ min(100, ($card['value'] > 0 ? 28 + ($card['value'] % 60) : 24)) }}%"></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </template>
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div x-data="cardState('pipeline')" class="xl:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Bookings</p>
                    <h3 class="text-lg font-semibold text-gray-900">Pipeline health</h3>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View all</a>
                    <button @click="toggle" class="text-gray-400 hover:text-gray-700 transition" title="Toggle card">
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-6 space-y-4" x-show="open" x-transition.opacity x-cloak>
                @php
                    $statusColors = [
                        'pending' => 'amber',
                        'confirmed' => 'blue',
                        'rescheduled' => 'purple',
                        'completed' => 'emerald',
                        'cancelled' => 'rose',
                    ];
                @endphp

                @foreach ($bookingStatusCounts as $status => $count)
                    @php
                        $percentage = $totalBookings > 0 ? round(($count / max($totalBookings, 1)) * 100) : 0;
                        $color = $statusColors[$status] ?? 'gray';
                    @endphp
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-{{ $color }}-500"></span>
                                <span class="capitalize text-gray-700">{{ $status }}</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $count }} <span class="text-xs text-gray-500">({{ $percentage }}%)</span></span>
                        </div>
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-{{ $color }}-400 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach

                <div class="rounded-xl bg-gray-50 border border-dashed border-gray-200 px-4 py-3">
                    <p class="text-sm font-medium text-gray-700">{{ $totalBookings > 0 ? 'Keep momentum by confirming pending bookings today.' : 'No bookings yet—share your services to start filling the pipeline.' }}</p>
                </div>
            </div>
        </div>

        <div x-data="cardState('posts')" class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Content</p>
                    <h3 class="text-lg font-semibold text-gray-900">Latest updates</h3>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.articles.index') }}" class="text-sm text-blue-600 hover:text-blue-700">Manage</a>
                    <button @click="toggle" class="text-gray-400 hover:text-gray-700 transition" title="Toggle card">
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="space-y-3" x-show="open" x-transition.opacity x-cloak>
                @forelse ($recentPosts as $post)
                    <div class="flex items-start justify-between gap-3 p-3 rounded-xl border border-gray-100 hover:border-blue-100 hover:bg-blue-50/40 transition">
                        <div class="space-y-1">
                            <p class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $post->title }}</p>
                            <p class="text-xs text-gray-500">Updated {{ optional($post->updated_at)->diffForHumans() ?? 'recently' }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $post->published ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                            {{ $post->published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No articles yet. Publish your first story to highlight recent wins.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div x-data="cardState('activity')" class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Activity</p>
                    <h3 class="text-lg font-semibold text-gray-900">Recent bookings</h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">Timeline</span>
                    <button @click="toggle" class="text-gray-400 hover:text-gray-700 transition" title="Toggle card">
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-6 space-y-4" x-show="open" x-transition.opacity x-cloak>
                @forelse ($recentBookings as $booking)
                    <div class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 hover:border-blue-100 hover:bg-blue-50/40 transition">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold">
                            {{ strtoupper(substr($booking->name ?? 'G', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-gray-900">{{ $booking->name ?? 'New booking' }}</p>
                                <span class="text-xs px-3 py-1 rounded-full border {{ ($bookingStatusCounts[$booking->status] ?? false) ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-gray-50 text-gray-600 border-gray-100' }} capitalize">{{ $booking->status ?? 'pending' }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-1">Service: {{ $booking->service_interest ?? 'General inquiry' }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ optional($booking->created_at)->diffForHumans() ?? 'Just now' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No bookings yet. Share your services to start receiving requests.</p>
                @endforelse
            </div>
        </div>

        <div x-data="cardState('actions')" class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Quick actions</p>
                    <h3 class="text-lg font-semibold text-gray-900">Get moving</h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">Shortcuts</span>
                    <button @click="toggle" class="text-gray-400 hover:text-gray-700 transition" title="Toggle card">
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3" x-show="open" x-transition.opacity x-cloak>
                @foreach ($quickActions as $action)
                    <a href="{{ $action['href'] }}" class="group border border-gray-100 rounded-2xl p-4 hover:border-{{ $action['color'] }}-200 hover:bg-{{ $action['color'] }}-50/40 transition flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <span class="p-2 rounded-lg bg-{{ $action['color'] }}-100 text-{{ $action['color'] }}-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}" />
                                </svg>
                            </span>
                            <p class="text-sm font-semibold text-gray-900">{{ $action['title'] }}</p>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $action['description'] }}</p>
                        <span class="text-xs font-semibold text-{{ $action['color'] }}-700 group-hover:translate-x-0.5 transition">Start →</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div x-data="cardState('activity-logs')" class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Governance</p>
                    <h3 class="text-lg font-semibold text-gray-900">Recent admin activity</h3>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.activity-logs.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
                    <button @click="toggle" class="text-gray-400 hover:text-gray-700 transition" title="Toggle card">
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-4 space-y-3" x-show="open" x-transition.opacity x-cloak>
                @forelse ($recentActivityLogs as $log)
                    <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 hover:border-indigo-100 hover:bg-indigo-50/40 transition">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-semibold">
                            {{ substr($log->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0 space-y-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-gray-900">{{ $log->user->name ?? 'Unknown user' }}</p>
                                <span class="text-xs text-gray-500">{{ optional($log->created_at)->diffForHumans() ?? 'Just now' }}</span>
                            </div>
                            <p class="text-sm text-gray-800">{{ Str::of($log->action)->replace('_', ' ')->title() }}</p>
                            @if ($log->description)
                                <p class="text-xs text-gray-500 line-clamp-1">{{ $log->description }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No admin activity logged yet.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cardState', (id) => ({
            id,
            open: sessionStorage.getItem(`dashboard-card-${id}`) !== 'closed',
            toggle() {
                this.open = !this.open;
                sessionStorage.setItem(`dashboard-card-${id}`, this.open ? 'open' : 'closed');
            },
        }));
    });
</script>
@endpush
