<div class="bg-white rounded-lg shadow-md p-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm text-blue-600 font-semibold">Book a consultation</p>
            <h2 class="text-3xl font-bold text-gray-900">Reserve time with our team</h2>
            <p class="text-gray-600">Share a few details and we'll confirm the best time for you.</p>
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
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                       placeholder="Alex Morgan">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Work email *</label>
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
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                       placeholder="+1 (555) 123-4567">
                @error('phone')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Acme Inc.">
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label for="service_interest" class="block text-sm font-medium text-gray-700 mb-1">Service of interest</label>
                <select name="service_interest" id="service_interest"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled @selected(! old('service_interest'))>Select a service</option>
                    @forelse(($services ?? collect()) as $service)
                        <option value="{{ $service->title }}" @selected(old('service_interest') === $service->title)>
                            {{ $service->title }}
                        </option>
                    @empty
                        <option value="" disabled>No services available</option>
                    @endforelse
                    <option value="Custom" @selected(old('service_interest') === 'Custom')>Custom</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="preferred_date" class="block text-sm font-medium text-gray-700 mb-1">Preferred date</label>
                    <input type="date" name="preferred_date" id="preferred_date" value="{{ old('preferred_date') }}"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="preferred_time" class="block text-sm font-medium text-gray-700 mb-1">Preferred time</label>
                    <input type="text" name="preferred_time" id="preferred_time" value="{{ old('preferred_time') }}"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Morning / Afternoon">
                </div>
            </div>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Project goals</label>
            <textarea name="message" id="message" rows="4" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Tell us what success looks like">{{ old('message') }}</textarea>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div class="flex items-center text-sm text-gray-600 space-x-2">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600">✓</span>
                <span>Instant confirmation & friendly reminders.</span>
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                Confirm my consultation
            </button>
        </div>
    </form>
</div>

@push('scripts')
    @auth
        <script>
            (() => {
                const pushEnabled = @json(filter_var(settings('booking.notifications.push.enabled', true), FILTER_VALIDATE_BOOL));
                const vapidPublicKey = @json(config('webpush.vapid.public_key'));
                const subscribeUrl = @json(route('push-subscriptions.store'));
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                if (!pushEnabled || !vapidPublicKey || !subscribeUrl || !csrfToken) {
                    return;
                }

                if (!('serviceWorker' in navigator) || !('PushManager' in window) || !('Notification' in window)) {
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

                const registerPush = async () => {
                    if (Notification.permission === 'denied') {
                        return;
                    }

                    const registration = await navigator.serviceWorker.register('/service-worker.js');
                    const permission = await Notification.requestPermission();

                    if (permission !== 'granted') {
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
                };

                document.addEventListener('DOMContentLoaded', () => {
                    registerPush().catch(() => {
                        // Fail silently; push registration is optional.
                    });
                });
            })();
        </script>
    @endauth
@endpush
