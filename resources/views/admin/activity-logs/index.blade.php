@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('content')
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between flex-wrap gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">System</p>
                    <h2 class="text-lg font-semibold text-gray-900">Admin activity log</h2>
                    <p class="text-sm text-gray-600">Track every change made inside the admin dashboard.</p>
                </div>
                <form method="GET" class="flex items-center gap-3 flex-wrap">
                    <div class="flex items-center gap-2">
                        <label for="action" class="text-xs font-semibold text-gray-600">Action</label>
                        <input type="text" id="action" name="action" value="{{ request('action') }}"
                               class="text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Search action">
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="admin" class="text-xs font-semibold text-gray-600">Admin</label>
                        <select id="admin" name="admin" class="text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All</option>
                            @foreach ($admins as $admin)
                                <option value="{{ $admin->id }}" @selected(request('admin') == $admin->id)>{{ $admin->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Filter
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($logs as $log)
                            <tr class="hover:bg-blue-50/40 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $log->created_at?->format('M d, Y h:i A') ?? '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-sm font-semibold text-slate-700">
                                            {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $log->user->name ?? 'System' }}</p>
                                            <p class="text-xs text-gray-500">{{ $log->user->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $log->action }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    @if($log->subject_type)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                            {{ class_basename($log->subject_type) }}
                                        </span>
                                        @if($log->subject_id)
                                            <span class="text-xs text-gray-500 ml-2">#{{ $log->subject_id }}</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $log->description ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">No activity has been recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
