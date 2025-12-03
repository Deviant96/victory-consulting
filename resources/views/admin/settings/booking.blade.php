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
                        <label class="inline-flex items-center cursor-pointer space-x-3">
                            @php
                                $emailEnabled = filter_var(old('booking.notifications.email.enabled', $settings['booking.notifications.email.enabled'] ?? true), FILTER_VALIDATE_BOOL);
                            @endphp
                            <input type="hidden" name="booking[notifications][email][enabled]" value="0">
                            <input
                                type="checkbox"
                                name="booking[notifications][email][enabled]"
                                value="1"
                                class="sr-only peer"
                                {{ $emailEnabled ? 'checked' : '' }}
                            >
                            <span class="toggle-track relative inline-flex h-7 w-14 items-center rounded-full border border-gray-300 bg-gray-200 transition peer-checked:bg-blue-600 peer-focus:ring peer-focus:ring-blue-200">
                                <span class="toggle-thumb absolute left-1 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-6"></span>
                            </span>
                            <span class="text-sm text-gray-700" aria-hidden="true">{{ $emailEnabled ? 'On' : 'Off' }}</span>
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

                <div class="border border-gray-200 rounded-lg p-5 space-y-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Push notification</h2>
                            <p class="text-sm text-gray-600 mt-1">Send a browser/OS notification to everyone on the admin team who has allowed alerts.</p>
                        </div>
                        <label class="inline-flex items-center cursor-pointer space-x-3">
                            @php
                                $pushEnabled = filter_var(old('booking.notifications.push.enabled', $settings['booking.notifications.push.enabled'] ?? true), FILTER_VALIDATE_BOOL);
                            @endphp
                            <input type="hidden" name="booking[notifications][push][enabled]" value="0">
                            <input
                                type="checkbox"
                                name="booking[notifications][push][enabled]"
                                value="1"
                                class="sr-only peer"
                                {{ $pushEnabled ? 'checked' : '' }}
                            >
                            <span class="toggle-track relative inline-flex h-7 w-14 items-center rounded-full border border-gray-300 bg-gray-200 transition peer-checked:bg-blue-600 peer-focus:ring peer-focus:ring-blue-200">
                                <span class="toggle-thumb absolute left-1 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-6"></span>
                            </span>
                            <span class="text-sm text-gray-700" aria-hidden="true">{{ $pushEnabled ? 'On' : 'Off' }}</span>
                        </label>
                    </div>
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <p class="text-xs text-gray-500">Click "Subscribe to push alerts" to allow notifications in your browser.</p>
                        <div class="flex items-center gap-3">
                            <button id="booking-push-subscribe" type="button" class="inline-flex items-center gap-2 rounded-md border border-blue-600 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 2a6 6 0 00-6 6v2.586l-.707.707A1 1 0 004 13h12a1 1 0 00.707-1.707L16 10.586V8a6 6 0 00-6-6zm0 16a2 2 0 01-2-2h4a2 2 0 01-2 2z" /></svg>
                                Subscribe to push alerts
                            </button>
                            <span id="booking-push-status" class="text-xs text-gray-600"></span>
                        </div>
                    </div>
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
    /* Make sure the custom toggles are always visible, even when off */
    .toggle-track { box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05); }
    .toggle-thumb { box-shadow: 0 1px 2px rgba(0, 0, 0, 0.12); }
</style>
@endpush

@push('scripts')
    <script>
        (() => {
            const subscribeButton = document.getElementById('booking-push-subscribe');
            const statusEl = document.getElementById('booking-push-status');
            const pushEnabled = @json(filter_var(settings('booking.notifications.push.enabled', true), FILTER_VALIDATE_BOOL));
            const vapidPublicKey = @json(config('webpush.vapid.public_key'));
            const subscribeUrl = @json(route('push-subscriptions.store'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            if (!subscribeButton || !pushEnabled) {
                return;
            }

            const unsupported = !('serviceWorker' in navigator) || !('PushManager' in window) || !('Notification' in window);

            const setStatus = (message, isError = false) => {
                if (!statusEl) return;
                statusEl.textContent = message;
                statusEl.classList.toggle('text-red-600', isError);
            };

            if (unsupported) {
                subscribeButton.disabled = true;
                setStatus('Push not supported in this browser.', true);
                return;
            }

            const urlBase64ToUint8Array = (base64String) => {
                const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
                const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
                const rawData = window.atob(base64);
                const outputArray = new Uint8Array(rawData.length);

                for (let i = 0; i < rawData.length; ++i) {
                    outputArray[i] = rawData.charCodeAt(i);
                }

                return outputArray;
            };

            const subscribe = async () => {
                if (!vapidPublicKey || !subscribeUrl || !csrfToken) {
                    setStatus('Push keys are missing. Check configuration.', true);
                    return;
                }

                subscribeButton.disabled = true;
                setStatus('Requesting permission...');

                const registration = await navigator.serviceWorker.register('/service-worker.js');
                const permission = await Notification.requestPermission();

                if (permission !== 'granted') {
                    setStatus('Permission was denied.', true);
                    subscribeButton.disabled = false;
                    return;
                }

                const existingSubscription = await registration.pushManager.getSubscription();
                const activeSubscription = existingSubscription ?? await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array(vapidPublicKey),
                });

                await fetch(subscribeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(activeSubscription),
                });

                setStatus('Subscribed! You will get push alerts for new bookings.');
            };

            subscribeButton.addEventListener('click', () => {
                subscribe().catch((error) => {
                    console.error(error);
                    setStatus('Could not subscribe. Check console for details.', true);
                    subscribeButton.disabled = false;
                });
            });
        })();
    </script>
@endpush
