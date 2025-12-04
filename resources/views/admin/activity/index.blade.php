@extends('admin.layouts.app')

@section('title', 'Activity Log')
@section('page-title', 'Activity Log')
@section('page-description', 'Track changes made by administrators across the dashboard.')

@section('content')
    <div class="space-y-6">
        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6 flex flex-col gap-2">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Admin activity</h2>
                    <p class="text-sm text-slate-600">Every update is captured with the admin who made it and when it happened.</p>
                </div>
                <div class="text-right text-sm text-slate-500">
                    <p class="font-medium text-slate-700">Total entries: {{ number_format($activities->total()) }}</p>
                    <p>Showing {{ $activities->count() ? $activities->firstItem() : 0 }} - {{ $activities->count() ? $activities->lastItem() : 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">When</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Changes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($activities as $activity)
                            @php
                                $subjectLabel = $activity->subject?->title
                                    ?? $activity->subject?->name
                                    ?? $activity->subject?->question
                                    ?? ($activity->subject?->id ? 'ID #' . $activity->subject->id : '—');
                            @endphp
                            <tr class="hover:bg-slate-50/70">
                                <td class="px-6 py-4 align-top text-sm text-slate-700">
                                    <div class="font-medium text-slate-900">{{ $activity->created_at->format('M d, Y H:i') }}</div>
                                    <div class="text-xs text-slate-500">{{ $activity->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 align-top text-sm text-slate-700">
                                    <div class="font-semibold text-slate-900">{{ $activity->user->name ?? 'System' }}</div>
                                    <div class="text-xs text-slate-500">{{ $activity->user->email ?? 'No email recorded' }}</div>
                                </td>
                                <td class="px-6 py-4 align-top text-sm text-slate-700">
                                    {{ $activity->action }}
                                </td>
                                <td class="px-6 py-4 align-top text-sm text-slate-700">
                                    <div class="font-medium text-slate-900">{{ $subjectLabel }}</div>
                                    <div class="text-xs text-slate-500">{{ $activity->subject_type ? class_basename($activity->subject_type) : 'General' }}</div>
                                </td>
                                <td class="px-6 py-4 align-top text-sm text-slate-700">
                                    {{ $activity->description ?? '—' }}
                                </td>
                                <td class="px-6 py-4 align-top text-sm text-slate-700">
                                    @if ($activity->changes)
                                        <dl class="space-y-2 text-xs text-slate-700">
                                            @foreach ($activity->changes as $field => $change)
                                                <div class="border border-slate-200 rounded-lg px-3 py-2 bg-slate-50">
                                                    <dt class="font-semibold text-slate-800">{{ ucfirst(str_replace('_', ' ', $field)) }}</dt>
                                                    <dd class="mt-1 text-slate-600">
                                                        <span class="text-slate-500">From:</span> {{ $change['from'] === null || $change['from'] === '' ? '—' : $change['from'] }}
                                                    </dd>
                                                    <dd class="text-slate-600">
                                                        <span class="text-slate-500">To:</span> {{ $change['to'] === null || $change['to'] === '' ? '—' : $change['to'] }}
                                                    </dd>
                                                </div>
                                            @endforeach
                                        </dl>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">
                                    No activity has been recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
@endsection
