@extends('admin.layouts.app')

@section('title', 'Newsletter Subscribers')
@section('page-title', 'Newsletter Subscribers')
@section('page-description', 'Review and export newsletter signup audience.')

@section('content')
    <div class="space-y-6">
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">Total Subscribers</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">Added This Month</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['this_month'] }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">Added Today</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['today'] }}</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between flex-wrap gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Newsletter</p>
                    <h2 class="text-lg font-semibold text-gray-900">Subscribers</h2>
                </div>
                <a href="{{ route('admin.newsletter-subscribers.export') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-medium hover:bg-slate-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    Export CSV
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($subscribers as $subscriber)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3 text-gray-900 font-medium">{{ $subscriber->email }}</td>
                                <td class="px-4 py-3 text-gray-700 capitalize">{{ $subscriber->source ?? 'website' }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $subscriber->created_at?->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-500">No newsletter subscribers yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                {{ $subscribers->links() }}
            </div>
        </div>
    </div>
@endsection
