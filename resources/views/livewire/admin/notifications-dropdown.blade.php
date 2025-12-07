<div x-data="{ open: false }" class="relative" wire:poll.30s="loadNotifications">
    <button
        @click="open = !open"
        @click.away="open = false"
        @keydown.escape.window="open = false"
        class="relative p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition"
        aria-label="Notifications"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>

        @if ($unreadCount > 0)
            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-semibold leading-none text-white bg-red-500 rounded-full ring-2 ring-white">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-96 max-w-[90vw] bg-white rounded-xl shadow-2xl border border-gray-200 z-50"
        style="display: none;"
    >
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <div>
                <p class="text-sm font-semibold text-gray-900">Notifications</p>
                <p class="text-xs text-gray-500">{{ $unreadCount }} unread</p>
            </div>

            @if ($notifications->isNotEmpty())
                <button 
                    wire:click="markAllAsRead" 
                    class="text-xs font-medium text-indigo-600 hover:text-indigo-800"
                    @click="open = false"
                >
                    Mark all as read
                </button>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse ($notifications as $notification)
                @php
                    $data = $notification->data ?? [];
                    $bookingId = $data['booking_id'] ?? null;
                    $url = $bookingId ? route('admin.bookings.show', $bookingId) : null;
                    $title = 'Notification';
                    $description = $data['message'] ?? 'Open for more details.';

                    if ($notification->type === \App\Notifications\NewBookingNotification::class) {
                        $title = 'New booking from ' . ($data['name'] ?? 'Client');
                        $description = $data['service'] ?? 'A consultation request is ready to review.';
                    }

                    $statusStyles = [
                        'pending' => ['badge' => 'bg-amber-100 text-amber-800', 'dot' => 'bg-amber-400'],
                        'confirmed' => ['badge' => 'bg-green-100 text-green-800', 'dot' => 'bg-green-500'],
                        'completed' => ['badge' => 'bg-blue-100 text-blue-800', 'dot' => 'bg-blue-500'],
                    ];

                    $statusStyle = $statusStyles[$data['status'] ?? ''] ?? ['badge' => 'bg-gray-100 text-gray-700', 'dot' => 'bg-gray-400'];
                @endphp

                <a
                    href="{{ $url ?? '#' }}"
                    wire:click="markAsRead('{{ $notification->id }}')"
                    @click="open = false"
                    class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50"
                >
                    <div class="mt-0.5">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $title }}</p>
                            <span class="text-[11px] text-gray-500 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">{{ $description }}</p>

                        <div class="flex items-center gap-2 mt-2 text-[11px] text-gray-500">
                            @if (!empty($data['preferred_date']))
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ \Illuminate\Support\Carbon::parse($data['preferred_date'])->format('M j, Y') }}</span>
                                </span>
                            @endif

                            @if (!empty($data['preferred_time']))
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $data['preferred_time'] }}</span>
                                </span>
                            @endif

                            @if (!empty($data['status']))
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full capitalize {{ $statusStyle['badge'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
                                    {{ $data['status'] }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if (is_null($notification->read_at))
                        <span class="mt-1 w-2 h-2 rounded-full bg-indigo-500"></span>
                    @endif
                </a>
            @empty
                <div class="px-4 py-6 text-center text-sm text-gray-500">
                    No notifications yet.
                </div>
            @endforelse
        </div>
    </div>
</div>
