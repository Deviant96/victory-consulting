@extends('admin.layouts.app')

@section('title', 'Drafts')
@section('page-title', 'Email — Drafts')

@section('content')
<div class="space-y-4">
    @if($error)
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
            <svg class="w-10 h-10 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm font-semibold text-red-700 mb-1">Connection Failed</p>
            <p class="text-sm text-red-600">{{ $error }}</p>
            <p class="mt-3 text-xs text-red-500">Update <code class="bg-red-100 px-1 rounded">TITAN_IMAP_*</code> variables in your <code class="bg-red-100 px-1 rounded">.env</code> file, then run <code class="bg-red-100 px-1 rounded">php artisan config:clear</code>.</p>
            <a href="{{ $titanUrl }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-1 mt-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 transition">
                Open Titan Email ↗
            </a>
        </div>
    @else
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Drafts</h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $total }} draft{{ $total !== 1 ? 's' : '' }}</p>
                </div>
                <a href="{{ $titanUrl }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-1 text-xs px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Open in Titan
                </a>
            </div>
            @forelse($messages as $message)
                @php
                    $uid = $message->getUid();
                    $to = $message->getTo()->first();
                    $subject = $message->getSubject()->first() ?? '(no subject)';
                    $date = $message->getDate()->first();
                @endphp
                <a href="{{ route('admin.email.show', ['uid' => $uid, 'folder' => 'drafts']) }}"
                   class="flex items-start gap-4 px-6 py-4 border-b border-gray-50 hover:bg-amber-50/30 transition group">
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-sm text-amber-700 font-medium truncate">Draft</span>
                            <span class="text-xs text-gray-400 flex-shrink-0">
                                {{ $date ? \Carbon\Carbon::parse($date)->diffForHumans() : '' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-800 truncate mt-0.5">{{ $subject }}</p>
                        @if($to)
                            <p class="text-xs text-gray-400 mt-0.5">To: {{ $to->mail }}</p>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-amber-400 flex-shrink-0 mt-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <p class="text-sm">No drafts saved</p>
                </div>
            @endforelse
        </div>

        @if($total > $perPage)
            <div class="flex items-center justify-between px-1">
                <span class="text-sm text-gray-500">
                    Showing {{ (($page - 1) * $perPage) + 1 }}–{{ min($page * $perPage, $total) }} of {{ $total }}
                </span>
                <div class="flex gap-2">
                    @if($page > 1)
                        <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}"
                           class="px-3 py-1.5 text-sm bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            ← Previous
                        </a>
                    @endif
                    @if($page * $perPage < $total)
                        <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}"
                           class="px-3 py-1.5 text-sm bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            Next →
                        </a>
                    @endif
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
