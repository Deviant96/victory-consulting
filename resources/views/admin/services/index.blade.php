@extends('admin.layouts.app')

@section('title', 'Services')
@section('page-title', 'Services')
@section('page-description', 'Manage your services and offerings with quick filters and inline actions.')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
        <div class="space-y-1">
            <p class="text-gray-700">Manage your services and offerings</p>
            <p class="text-sm text-gray-500">Search or filter to quickly find entries</p>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z" />
                    </svg>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search services..."
                           class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white/80">
                </div>
                <select name="status" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white/80">
                    <option value="">All Statuses</option>
                    <option value="published" @selected($status === 'published')>Published</option>
                    <option value="draft" @selected($status === 'draft')>Draft</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition transform hover:-translate-y-0.5 shadow-sm">
                        Filter
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="px-4 py-2 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition">
                        Reset
                    </a>
                </div>
            </form>
            <a href="{{ route('admin.services.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Service
            </a>
        </div>
    </div>

    <!-- Services Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Summary
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($services as $service)
                        <tr class="hover:bg-blue-50/40 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($service->featured_image)
                                        <img src="{{ asset('storage/' . $service->featured_image) }}"
                                             alt="{{ $service->title }}"
                                             class="w-10 h-10 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $service->title }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $service->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ Str::limit($service->summary, 60) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($service->published)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Published
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.services.edit', $service) }}"
                                   class="text-blue-600 hover:text-blue-900 inline-flex items-center gap-1">
                                    Edit
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No services found. <a href="{{ route('admin.services.create') }}" class="text-blue-600 hover:text-blue-700">Create your first service</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
