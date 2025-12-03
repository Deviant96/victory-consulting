@extends('admin.layouts.app')

@section('title', 'Booking Settings')

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Booking Notifications</h2>
        <p class="mt-1 text-sm text-gray-600">Control how new booking requests notify your team.</p>
    </div>
    <form action="{{ route('admin.settings.booking.update') }}" method="POST" class="p-6 space-y-6">
        @csrf
        <div class="flex items-start gap-4">
            <div class="flex items-center h-6">
                <input type="checkbox" name="booking.notifications.push_enabled" id="push_enabled" value="1" class="w-5 h-5 text-blue-600 border-gray-300 rounded" {{ old('booking.notifications.push_enabled', $settings['booking.notifications.push_enabled'] ?? false) ? 'checked' : '' }}>
            </div>
            <div class="flex-1">
                <label for="push_enabled" class="text-base font-medium text-gray-900">Enable web push/broadcast alerts</label>
                <p class="text-sm text-gray-600 mt-1">Allow the site to broadcast new booking requests to connected clients and supported service workers.</p>
                <p class="text-xs text-gray-500 mt-1">VAPID public key: {{ config('services.webpush.vapid_public_key') ?: 'not configured' }}</p>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
