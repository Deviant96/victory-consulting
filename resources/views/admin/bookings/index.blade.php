@extends('admin.layouts.app')

@section('title', 'Bookings')

@section('content')
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Bookings</h1>
            <p class="text-gray-600">Track and manage every consultation request in one place.</p>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-gray-600">Pending</p>
            <p class="text-3xl font-bold text-amber-600 mt-1">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-gray-600">Confirmed</p>
            <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['confirmed'] }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-gray-600">Completed</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['completed'] }}</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Recent bookings</h2>
            <a href="{{ route('admin.settings.booking') }}" class="text-sm text-blue-600 hover:text-blue-700">Notification preferences</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preferred</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-900">{{ $booking->name }}</div>
                                <div class="text-sm text-gray-600">{{ $booking->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $booking->service_interest ?: '—' }}</td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ $booking->preferred_date?->format('M d, Y') ?? 'Date TBD' }}
                                @if($booking->preferred_time)
                                    <div class="text-xs text-gray-500">{{ $booking->preferred_time }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 capitalize">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-700 font-semibold">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No bookings yet. Embed the form on the Contact page to start collecting leads.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-200">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
