@extends('admin.layouts.app')

@section('title', 'Booking Notifications')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Booking Notifications</h1>
                    <p class="text-gray-600 mt-1">Control how the team is alerted when a new booking is submitted.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.booking.update') }}" class="space-y-8">
                @csrf

                <div class="border border-gray-200 rounded-lg p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Email notification</h2>
                            <p class="text-sm text-gray-600 mt-1">Send booking alerts to a dedicated inbox (not tied to user profiles).</p>
                        </div>
                        <label class="inline-flex items-center cursor-pointer">
                            @php
                                $emailEnabled = filter_var(old('booking.notifications.email.enabled', $settings['booking.notifications.email.enabled'] ?? true), FILTER_VALIDATE_BOOL);
                            @endphp
                            <input type="hidden" name="booking[notifications][email][enabled]" value="0">
                            <input
                                type="checkbox"
                                name="booking[notifications][email][enabled]"
                                value="1"
                                class="sr-only"
                                {{ $emailEnabled ? 'checked' : '' }}
                            >
                            <span class="relative inline-block w-12 h-6 transition rounded-full bg-gray-300">
                                <span class="dot absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition translate-x-0" aria-hidden="true"></span>
                            </span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notification email address</label>
                        <input type="email"
                               name="booking[notifications][email][address]"
                               value="{{ old('booking.notifications.email.address', $settings['booking.notifications.email.address'] ?? '') }}"
                               placeholder="alerts@yourcompany.com"
                               class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('booking.notifications.email.address')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">We'll route all booking emails to this inbox.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Push notification</h2>
                            <p class="text-sm text-gray-600 mt-1">Send an in-dashboard alert to everyone on the admin team.</p>
                        </div>
                        <label class="inline-flex items-center cursor-pointer">
                            @php
                                $pushEnabled = filter_var(old('booking.notifications.push.enabled', $settings['booking.notifications.push.enabled'] ?? true), FILTER_VALIDATE_BOOL);
                            @endphp
                            <input type="hidden" name="booking[notifications][push][enabled]" value="0">
                            <input
                                type="checkbox"
                                name="booking[notifications][push][enabled]"
                                value="1"
                                class="sr-only"
                                {{ $pushEnabled ? 'checked' : '' }}
                            >
                            <span class="relative inline-block w-12 h-6 transition rounded-full bg-gray-300">
                                <span class="dot absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition translate-x-0" aria-hidden="true"></span>
                            </span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">New bookings will appear in the notification center for signed-in admins.</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-md shadow-sm transition">
                        Save preferences
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Simple toggle animation */
    input[type="checkbox"]:checked + span { background-color: #2563eb; }
    input[type="checkbox"]:checked + span .dot { transform: translateX(1.5rem); }
</style>
@endpush
