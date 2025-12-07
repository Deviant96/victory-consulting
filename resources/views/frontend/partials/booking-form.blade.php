<div class="bg-white rounded-lg shadow-md p-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm text-blue-600 font-semibold">{{ t('frontend.booking.badge', 'Book a consultation') }}</p>
            <h2 class="text-3xl font-bold text-gray-900">{{ t('frontend.booking.heading', 'Reserve time with our team') }}</h2>
            <p class="text-gray-600">{{ t('frontend.booking.subheading', "Share a few details and we'll confirm the best time for you.") }}</p>
        </div>
        <div class="hidden md:flex items-center justify-center w-14 h-14 rounded-full bg-blue-50 text-blue-700 font-bold text-lg">
            <span>24/7</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ t('frontend.booking.name_label', 'Full name *') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                       placeholder="Alex Morgan">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ t('frontend.booking.email_label', 'Work email *') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                       placeholder="you@company.com">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ t('frontend.booking.phone_label', 'Phone') }}</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                       placeholder="+1 (555) 123-4567">
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">{{ t('frontend.booking.company_label', 'Company') }}</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Acme Inc.">
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label for="service_interest" class="block text-sm font-medium text-gray-700 mb-1">{{ t('frontend.booking.service_label', 'Service of interest') }}</label>
                <select name="service_interest" id="service_interest"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled @selected(! old('service_interest'))>{{ t('frontend.booking.service_placeholder', 'Select a service') }}</option>
                    @forelse(($services ?? collect()) as $service)
                        <option value="{{ $service->title }}" @selected(old('service_interest') === $service->title)>
                            {{ $service->title }}
                        </option>
                    @empty
                        <option value="" disabled>{{ t('frontend.booking.no_services', 'No services available') }}</option>
                    @endforelse
                    <option value="Custom" @selected(old('service_interest') === 'Custom')>{{ t('frontend.booking.custom_option', 'Custom') }}</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="preferred_date" class="block text-sm font-medium text-gray-700 mb-1">{{ t('frontend.booking.date_label', 'Preferred date') }}</label>
                    <input type="date" name="preferred_date" id="preferred_date" value="{{ old('preferred_date') }}"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="preferred_time" class="block text-sm font-medium text-gray-700 mb-1">{{ t('frontend.booking.time_label', 'Preferred time') }}</label>
                    <input type="text" name="preferred_time" id="preferred_time" value="{{ old('preferred_time') }}"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Morning / Afternoon">
                </div>
            </div>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">{{ t('frontend.booking.message_label', 'Project goals') }}</label>
            <textarea name="message" id="message" rows="4" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="{{ t('frontend.booking.message_placeholder', 'Tell us what success looks like') }}">{{ old('message') }}</textarea>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div class="flex items-center text-sm text-gray-600 space-x-2">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600">✓</span>
                <span>{{ t('frontend.booking.confirmation_note', 'Instant confirmation & friendly reminders.') }}</span>
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                {{ t('frontend.booking.submit', 'Confirm my consultation') }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
    @auth
        <div class="mt-8 rounded-lg border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white">🔔</span>
                    <div>
                        <p class="font-semibold">Want push alerts when someone books?</p>
                        <p class="text-blue-800">We'll send browser/OS notifications to this account after you subscribe.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button id="booking-push-subscribe" type="button" class="inline-flex items-center gap-2 rounded-md border border-blue-700 px-4 py-2 font-semibold text-blue-700 transition hover:bg-blue-100">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 2a6 6 0 00-6 6v2.586l-.707.707A1 1 0 004 13h12a1 1 0 00.707-1.707L16 10.586V8a6 6 0 00-6-6zm0 16a2 2 0 01-2-2h4a2 2 0 01-2 2z" /></svg>
                        Subscribe to booking alerts
                    </button>
                    <span id="booking-push-status" class="text-xs text-blue-800"></span>
                </div>
            </div>
        </div>

        <script>
            (() => {
                const pushEnabled = @json(filter_var(settings('booking.notifications.push.enabled', true), FILTER_VALIDATE_BOOL));
                const vapidPublicKey = @json(config('webpush.vapid.public_key'));
                const subscribeUrl = @json(route('push-subscriptions.store'));
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                const subscribeButton = document.getElementById('booking-push-subscribe');
                const statusEl = document.getElementById('booking-push-status');

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

                    const registration = await navigator.serviceWorker.register('{{ asset('service-worker.js') }}');
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

                    setStatus('Subscribed! You will see booking alerts here.');
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
    @endauth
@endpush
