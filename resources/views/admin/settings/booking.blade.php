@extends('admin.layouts.app')
    
@section('title', 'Booking Notifications')
@section('page-title', 'Booking Notifications')
@section('page-description', 'Control how the team is alerted when a new booking is submitted.')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white shadow rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Booking Notifications</h1>
                    <p class="text-gray-600 mt-1">Control how the team is alerted when a new booking is submitted.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.booking.update') }}" class="space-y-8">
                @csrf

                <div class="border border-gray-200 rounded-xl p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Email notification</h2>
                            <p class="text-sm text-gray-600 mt-1">Send booking alerts to a dedicated inbox (not tied to user profiles).</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
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
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-700">{{ $emailEnabled ? 'On' : 'Off' }}</span>
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

                <div class="border border-gray-200 rounded-xl p-5 space-y-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Push notification</h2>
                            <p class="text-sm text-gray-600 mt-1">Send a browser/OS notification to everyone on the admin team who has allowed alerts.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
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
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-700">{{ $pushEnabled ? 'On' : 'Off' }}</span>
                        </label>
                    </div>
                    <div id="booking-push-browser-warning" class="hidden px-3 py-2 bg-yellow-50 border border-yellow-200 rounded-md text-sm text-yellow-800 mb-3">
                        <strong>⚠️ Chrome Browser Detected:</strong> If subscription fails, try using <strong>Microsoft Edge</strong> or <strong>Firefox</strong> instead.
                    </div>
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <p class="text-xs text-gray-500">Manage your push notification subscription for new booking alerts.</p>
                        <div class="flex items-center gap-3">
                            <button id="booking-push-subscribe" type="button" class="inline-flex items-center gap-2 rounded-md border border-blue-600 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 2a6 6 0 00-6 6v2.586l-.707.707A1 1 0 004 13h12a1 1 0 00.707-1.707L16 10.586V8a6 6 0 00-6-6zm0 16a2 2 0 01-2-2h4a2 2 0 01-2 2z" /></svg>
                                Subscribe to push alerts
                            </button>
                            <button id="booking-push-unsubscribe" type="button" class="hidden inline-flex items-center gap-2 rounded-md border border-red-600 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 2a6 6 0 00-6 6v2.586l-.707.707A1 1 0 004 13h12a1 1 0 00.707-1.707L16 10.586V8a6 6 0 00-6-6zm0 16a2 2 0 01-2-2h4a2 2 0 01-2 2z" /></svg>
                                Unsubscribe
                            </button>
                            <span id="booking-push-status" class="text-xs text-gray-600"></span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                        Save preferences
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        (() => {
            const subscribeButton = document.getElementById('booking-push-subscribe');
            const unsubscribeButton = document.getElementById('booking-push-unsubscribe');
            const statusEl = document.getElementById('booking-push-status');
            const browserWarning = document.getElementById('booking-push-browser-warning');
            const pushEnabled = @json(filter_var(settings('booking.notifications.push.enabled', true), FILTER_VALIDATE_BOOL));
            const vapidPublicKey = @json(config('webpush.vapid.public_key'));
            const subscribeUrl = @json(route('push-subscriptions.store'));
            const unsubscribeUrl = @json(route('push-subscriptions.destroy'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            if (!subscribeButton || !pushEnabled) {
                return;
            }

            // Show warning for Chrome users
            const isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
            const isEdge = /Edg/.test(navigator.userAgent);
            if (isChrome && !isEdge && browserWarning) {
                browserWarning.classList.remove('hidden');
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

            // Check if already subscribed on page load
            const checkSubscriptionStatus = async () => {
                try {
                    const registration = await navigator.serviceWorker.register('{{ asset('service-worker.js') }}', {
                        scope: '{{ url('/') }}/'
                    });
                    const subscription = await registration.pushManager.getSubscription();
                    
                    if (subscription) {
                        showSubscribedState();
                    } else {
                        showUnsubscribedState();
                    }
                } catch (error) {
                    console.log('Could not check subscription status:', error);
                }
            };

            const showSubscribedState = () => {
                subscribeButton.classList.add('hidden');
                unsubscribeButton.classList.remove('hidden');
                setStatus('You are subscribed to push notifications.');
            };

            const showUnsubscribedState = () => {
                subscribeButton.classList.remove('hidden');
                subscribeButton.disabled = false;
                subscribeButton.textContent = 'Subscribe to push alerts';
                subscribeButton.classList.remove('border-green-600', 'text-green-700', 'bg-green-50', 'cursor-default');
                subscribeButton.classList.add('border-blue-600', 'text-blue-700', 'hover:bg-blue-50');
                unsubscribeButton.classList.add('hidden');
                setStatus('');
            };

            checkSubscriptionStatus();

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
                try {
                    if (!vapidPublicKey || !subscribeUrl || !csrfToken) {
                        setStatus('Push keys are missing. Check configuration.', true);
                        console.error('Missing configuration:', { vapidPublicKey: !!vapidPublicKey, subscribeUrl: !!subscribeUrl, csrfToken: !!csrfToken });
                        return;
                    }

                    subscribeButton.disabled = true;
                    setStatus('Requesting permission...');

                    console.log('Registering service worker...');
                    const registration = await navigator.serviceWorker.register('{{ asset('service-worker.js') }}', {
                        scope: '{{ url('/') }}/'
                    });
                    console.log('Service worker registered:', registration);
                    console.log('Service worker scope:', registration.scope);
                    
                    await registration.update();
                    const ready = await navigator.serviceWorker.ready;
                    console.log('Service worker ready:', ready.active.state);
                    
                    const permission = await Notification.requestPermission();
                    console.log('Permission result:', permission);

                    if (permission !== 'granted') {
                        setStatus('Permission was denied.', true);
                        subscribeButton.disabled = false;
                        return;
                    }

                    setStatus('Creating subscription...');

                    // Unsubscribe from any existing subscription first
                    const existingSubscription = await registration.pushManager.getSubscription();
                    if (existingSubscription) {
                        console.log('Unsubscribing from existing subscription...');
                        await existingSubscription.unsubscribe();
                    }

                    // Create new subscription with updated VAPID key
                    console.log('Subscribing with VAPID key...');
                    const applicationServerKey = urlBase64ToUint8Array(vapidPublicKey);
                    console.log('Application server key length:', applicationServerKey.length);
                    
                    // Wait a bit for service worker to fully stabilize
                    await new Promise(resolve => setTimeout(resolve, 500));
                    
                    const activeSubscription = await registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: applicationServerKey,
                    });
                    
                    console.log('Subscription created:', activeSubscription);

                    setStatus('Saving subscription...');
                    const response = await fetch(subscribeUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(activeSubscription),
                    });

                    if (!response.ok) {
                        throw new Error('Failed to save subscription: ' + response.statusText);
                    }

                    console.log('Subscription saved successfully');
                    
                    showSubscribedState();
                    setStatus('Subscribed! You will get push alerts for new bookings.');
                } catch (error) {
                    console.error('Subscription error:', error);
                    let errorMsg = error.message;
                    if (error.name === 'AbortError' && error.message.includes('push service')) {
                        errorMsg = 'Push service error. Try using Microsoft Edge or Firefox browser instead.';
                    }
                    setStatus('Error: ' + errorMsg, true);
                    subscribeButton.disabled = false;
                    return;
                }
            };

            const unsubscribe = async () => {
                try {
                    unsubscribeButton.disabled = true;
                    setStatus('Unsubscribing...');

                    const registration = await navigator.serviceWorker.register('{{ asset('service-worker.js') }}', {
                        scope: '{{ url('/') }}/'
                    });
                    const subscription = await registration.pushManager.getSubscription();

                    if (subscription) {
                        // Unsubscribe from browser
                        await subscription.unsubscribe();
                        console.log('Unsubscribed from browser push service');

                        // Delete from server
                        const response = await fetch(unsubscribeUrl, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({ endpoint: subscription.endpoint }),
                        });

                        if (!response.ok) {
                            throw new Error('Failed to delete subscription from server: ' + response.statusText);
                        }

                        console.log('Subscription deleted from server');
                    }

                    showUnsubscribedState();
                    setStatus('Unsubscribed successfully.');
                } catch (error) {
                    console.error('Unsubscribe error:', error);
                    setStatus('Error: ' + error.message, true);
                    unsubscribeButton.disabled = false;
                }
            };

            subscribeButton.addEventListener('click', () => {
                subscribe().catch((error) => {
                    console.error(error);
                    setStatus('Could not subscribe. Check console for details.', true);
                    subscribeButton.disabled = false;
                });
            });

            unsubscribeButton.addEventListener('click', () => {
                if (confirm('Are you sure you want to unsubscribe from push notifications?')) {
                    unsubscribe().catch((error) => {
                        console.error(error);
                        setStatus('Could not unsubscribe. Check console for details.', true);
                        unsubscribeButton.disabled = false;
                    });
                }
            });
        })();
    </script>
@endpush
