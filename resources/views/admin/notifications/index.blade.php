@extends('admin.layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Recent notifications</h1>
                <p class="text-sm text-gray-500">Stay on top of new booking requests and other updates.</p>
            </div>
            <form method="POST" action="{{ route('admin.notifications.markAllRead') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 transition">
                    Mark all as read
                </button>
            </form>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $title = $data['title'] ?? 'Notification';
                    $message = $data['summary']
                        ?? $data['message']
                        ?? ($data['service'] ?? $data['status'] ?? 'A new update is available.');
                    $url = $data['url'] ?? null;
                @endphp
                <div class="px-6 py-4 flex items-start gap-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50/50' }}">
                    <div class="mt-1">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0 space-y-1">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-gray-900">{{ $title }}</p>
                            @if (!$notification->read_at)
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">New</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $message }}</p>
                        <div class="text-xs text-gray-500 flex items-center gap-2">
                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                            @if (isset($data['status']))
                                <span class="inline-flex items-center px-2 py-0.5 bg-gray-100 text-gray-700 rounded-md">Status: {{ ucfirst($data['status']) }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 pt-2">
                            @if ($url)
                                <a href="{{ $url }}" class="inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-800">View details</a>
                            @endif
                            <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification) }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Mark as read</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    <p class="text-lg font-semibold text-gray-700">No notifications yet</p>
                    <p class="text-sm text-gray-500">New booking requests and other updates will show up here.</p>
                </div>
            @endforelse
        </div>

        <div class="px-6 py-4">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
