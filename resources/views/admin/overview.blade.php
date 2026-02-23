@extends('admin.layouts.app')

@section('title', 'Overview')

@section('page-title', 'Overview')

@section('content')
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
            <p class="text-sm text-gray-500">Services</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">{{ number_format($stats['services'] ?? 0) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
            <p class="text-sm text-gray-500">Team Members</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">{{ number_format($stats['team'] ?? 0) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
            <p class="text-sm text-gray-500">FAQs</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">{{ number_format($stats['faqs'] ?? 0) }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
            <p class="text-sm text-gray-500">Articles</p>
            <p class="text-2xl font-semibold text-gray-900 mt-1">{{ number_format($stats['articles'] ?? 0) }}</p>
        </div>
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900">Recent activity</h3>
            <div class="mt-4 space-y-3">
                @forelse ($recentBookings as $booking)
                    <div class="p-3 rounded-xl border border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ $booking->name ?? 'New inquiry' }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ optional($booking->created_at)->diffForHumans() ?? 'Just now' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No recent inquiries.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900">Quick actions</h3>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ route('admin.services.create') }}" class="px-4 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm font-medium text-gray-800">Create service</a>
                <a href="{{ route('admin.articles.create') }}" class="px-4 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm font-medium text-gray-800">Publish article</a>
                <a href="{{ route('admin.bookings.index') }}" class="px-4 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm font-medium text-gray-800">Review inquiries</a>
                <a href="{{ route('admin.settings.contact') }}" class="px-4 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 text-sm font-medium text-gray-800">Update contact info</a>
            </div>
        </div>
    </section>
@endsection
