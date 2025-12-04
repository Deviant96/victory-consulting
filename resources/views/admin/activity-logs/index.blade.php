@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('page-title', 'Activity Logs')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Admin activity</h2>
                <p class="text-sm text-gray-600">Track every change made in the admin area with the responsible account.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-100 rounded-full">
                {{ $logs->total() }} records
            </span>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ Str::of($log->action)->replace('_', ' ')->title() }}</div>
                                <div class="text-xs text-gray-500">#{{ $log->id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-800">{{ $log->description ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center text-xs font-semibold">
                                        {{ substr($log->user->name ?? 'N/A', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $log->user->name ?? 'Unknown user' }}</p>
                                        <p class="text-xs text-gray-500">{{ $log->user->email ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $subjectLabel = $log->subject_type ? class_basename($log->subject_type) : 'General';
                                @endphp
                                <div class="text-sm text-gray-900">{{ $subjectLabel }}</div>
                                @if ($log->subject_id)
                                    <div class="text-xs text-gray-500">ID: {{ $log->subject_id }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ optional($log->created_at)->timezone(config('app.timezone', 'UTC'))->format('M d, Y h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No activity has been recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
