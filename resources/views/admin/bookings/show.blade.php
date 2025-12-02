@extends('admin.layouts.app')

@section('title', 'Booking Details')

@section('content')
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Submitted {{ $booking->created_at->format('M d, Y g:i A') }}</p>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $booking->name }}</h1>
                        <p class="text-gray-600">{{ $booking->email }} @if($booking->phone) · {{ $booking->phone }} @endif</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800 capitalize">{{ $booking->status }}</span>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Company</p>
                        <p class="font-semibold text-gray-900">{{ $booking->company ?: 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Service</p>
                        <p class="font-semibold text-gray-900">{{ $booking->service_interest ?: 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Preferred date</p>
                        <p class="font-semibold text-gray-900">{{ $booking->preferred_date?->format('M d, Y') ?? 'Flexible' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Preferred time</p>
                        <p class="font-semibold text-gray-900">{{ $booking->preferred_time ?: 'Flexible' }}</p>
                    </div>
                </div>

                @if($booking->message)
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Project notes</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $booking->message }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Admin notes</h2>
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-600 hover:text-gray-800">Back to bookings</a>
                </div>

                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @foreach (\App\Models\Booking::STATUSES as $status)
                                <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }} class="capitalize">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Internal notes</label>
                        <textarea name="admin_notes" rows="4" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Add context for your team">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow-sm">Save changes</button>
                    </div>
                </form>

                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="flex justify-end" onsubmit="return confirm('Delete this booking?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-50 text-red-700 hover:bg-red-100 font-semibold px-4 py-2 rounded-md border border-red-200">Delete</button>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-2">Actions</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li>✅ Save admin-only notes</li>
                    <li>✅ Update status to keep teammates in sync</li>
                    <li>✅ Respond using the customer's email above</li>
                </ul>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-lg p-5">
                <h3 class="text-sm font-semibold text-blue-900 mb-2">Notification settings</h3>
                <p class="text-sm text-blue-800">Need to change who gets alerted? Update email and push preferences in the booking settings.</p>
                <a href="{{ route('admin.settings.booking') }}" class="mt-3 inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-800">Adjust notifications</a>
            </div>
        </div>
    </div>
@endsection
