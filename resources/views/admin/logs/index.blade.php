@extends('admin.layouts.app')

@section('title', 'Activity Log')

@section('content')
    <div class="space-y-6">
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">Last 24 hours</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['day'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Recent admin actions</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">This week</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['week'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Changes captured</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-gray-600">All time</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Entries stored</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between flex-wrap gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Audit log</p>
                    <h2 class="text-lg font-semibold text-gray-900">Admin updates & changes</h2>
                </div>
                <span class="text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">Real-time capture</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($logs as $log)
                            <tr class="hover:bg-blue-50/40 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <div class="font-semibold">{{ $log->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->created_at->format('h:ia') }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900">{{ $log->user?->name ?? 'System' }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->user?->email ?? '—' }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m9-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <div class="font-semibold">{{ $log->model_type ? class_basename($log->model_type) : 'N/A' }}</div>
                                    @if($log->model_id)
                                        <div class="text-xs text-gray-500">ID: {{ $log->model_id }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 max-w-xl">
                                    {{ $log->description ?? 'No additional details provided.' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">No admin activity recorded yet.</td>
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
