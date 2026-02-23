@extends('admin.layouts.app')

@section('title', 'Admin Hub')

@section('page-title', 'Admin Hub')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <a href="{{ route('admin.overview') }}" class="group bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-blue-200 transition">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section 1</p>
            <h3 class="mt-2 text-xl font-semibold text-gray-900">Overview</h3>
            <p class="mt-2 text-sm text-gray-600">Status snapshot, recent activity, and quick actions.</p>
            <p class="mt-4 text-sm font-semibold text-blue-700 group-hover:translate-x-0.5 transition">Open section →</p>
        </a>

        <a href="{{ route('admin.pages.home') }}" class="group bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-blue-200 transition">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section 2</p>
            <h3 class="mt-2 text-xl font-semibold text-gray-900">Website</h3>
            <p class="mt-2 text-sm text-gray-600">Pages, services, industries, business solutions, blog, team, and FAQs.</p>
            <p class="mt-4 text-sm font-semibold text-blue-700 group-hover:translate-x-0.5 transition">Open section →</p>
        </a>

        <a href="{{ route('admin.bookings.index') }}" class="group bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-blue-200 transition">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section 3</p>
            <h3 class="mt-2 text-xl font-semibold text-gray-900">Client Inquiries</h3>
            <p class="mt-2 text-sm text-gray-600">All inquiries, notification settings, and WhatsApp agents.</p>
            <p class="mt-4 text-sm font-semibold text-blue-700 group-hover:translate-x-0.5 transition">Open section →</p>
        </a>

        <a href="{{ route('admin.settings.branding') }}" class="group bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-blue-200 transition">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Section 4</p>
            <h3 class="mt-2 text-xl font-semibold text-gray-900">Settings</h3>
            <p class="mt-2 text-sm text-gray-600">Branding, contact, social links, languages, and text translations.</p>
            <p class="mt-4 text-sm font-semibold text-blue-700 group-hover:translate-x-0.5 transition">Open section →</p>
        </a>
    </div>
@endsection
