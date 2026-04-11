@extends('admin.layouts.app')

@section('title', 'Newsletter Subscribers')
@section('page-title', 'Newsletter Subscribers')
@section('page-description', 'Review and export newsletter signup audience.')

@section('content')
    <div class="space-y-6">

        {{-- Flash message --}}
        @if (session('success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stats --}}
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">Total Subscribers</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">Added This Month</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ number_format($stats['this_month']) }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">Added Today</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($stats['today']) }}</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="p-4 border-b border-gray-200 flex items-center justify-between flex-wrap gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Newsletter</p>
                    <h2 class="text-lg font-semibold text-gray-900">Subscribers</h2>
                </div>
                <a href="{{ route('admin.newsletter-subscribers.export', array_filter(['search' => $search, 'source' => $source])) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-medium hover:bg-slate-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    Export CSV
                </a>
            </div>

            {{-- Search & Filter --}}
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <form method="GET" action="{{ route('admin.newsletter-subscribers.index') }}" class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-48">
                        <label for="search" class="block text-xs font-medium text-gray-500 mb-1">Search Email</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="e.g. john@example.com"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400"
                        >
                    </div>
                    @if ($sources->isNotEmpty())
                    <div class="min-w-40">
                        <label for="source" class="block text-xs font-medium text-gray-500 mb-1">Source</label>
                        <select
                            id="source"
                            name="source"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400"
                        >
                            <option value="">All Sources</option>
                            @foreach ($sources as $src)
                                <option value="{{ $src }}" @selected($source === $src)>{{ ucfirst($src) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-slate-800 text-white text-sm font-medium hover:bg-slate-700 transition">
                            Filter
                        </button>
                        @if ($search || $source)
                            <a href="{{ route('admin.newsletter-subscribers.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-100 transition">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed At</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($subscribers as $i => $subscriber)
                            @php
                                $srcColors = [
                                    'website' => 'bg-blue-100 text-blue-700',
                                    'api'     => 'bg-purple-100 text-purple-700',
                                    'import'  => 'bg-yellow-100 text-yellow-700',
                                    'manual'  => 'bg-gray-100 text-gray-700',
                                ];
                                $srcLabel = $subscriber->source ?? 'website';
                                $srcClass = $srcColors[$srcLabel] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 text-gray-400 text-sm">{{ $subscribers->firstItem() + $i }}</td>
                                <td class="px-4 py-3 text-gray-900 font-medium">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $subscriber->email }}</span>
                                        <button
                                            type="button"
                                            title="Copy email"
                                            onclick="navigator.clipboard.writeText('{{ $subscriber->email }}').then(() => { this.classList.add('text-emerald-500'); setTimeout(() => this.classList.remove('text-emerald-500'), 1200); })"
                                            class="text-gray-300 hover:text-gray-500 transition"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-4 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $srcClass }}">
                                        {{ ucfirst($srcLabel) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-sm">{{ $subscriber->created_at?->format('M d, Y H:i') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Remove {{ $subscriber->email }} from the subscriber list?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm transition">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    {{ ($search || $source) ? 'No subscribers match the current filters.' : 'No newsletter subscribers yet.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination footer --}}
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 flex items-center justify-between flex-wrap gap-2">
                @if ($subscribers->total() > 0)
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-medium text-gray-700">{{ $subscribers->firstItem() }}</span>
                        &ndash;
                        <span class="font-medium text-gray-700">{{ $subscribers->lastItem() }}</span>
                        of
                        <span class="font-medium text-gray-700">{{ number_format($subscribers->total()) }}</span>
                        {{ Str::plural('subscriber', $subscribers->total()) }}
                    </p>
                @else
                    <span></span>
                @endif
                <div>{{ $subscribers->links() }}</div>
            </div>
        </div>
    </div>
@endsection
