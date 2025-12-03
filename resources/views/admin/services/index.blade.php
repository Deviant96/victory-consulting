@extends('admin.layouts.app')

@section('title', 'Services')
@section('page-title', 'Services')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div x-data="collapsibleCard('services-filters')" class="admin-card p-6">
        <div class="admin-card-header flex-col sm:flex-row sm:items-center">
            <div>
                <p class="text-sm font-medium text-slate-500">Manage your services and offerings</p>
                <p class="admin-card-subtitle">Search or filter to quickly find entries</p>
            </div>
            <div class="flex items-center gap-2 mt-3 sm:mt-0">
                <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle filter card">
                    <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
                <a href="{{ route('admin.services.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Service
                </a>
            </div>
        </div>
        <div class="admin-card-body" x-show="!collapsed" x-transition>
            <form method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
                <div class="flex-1">
                    <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Search</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z" />
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search services..."
                               class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>
                <div class="w-full lg:w-48">
                    <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">All Statuses</option>
                        <option value="published" @selected($status === 'published')>Published</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                        Filter
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="px-4 py-2.5 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Services Table -->
    <div x-data="collapsibleCard('services-table')" class="admin-card">
        <div class="admin-card-header p-6 pb-4">
            <div>
                <h3 class="admin-card-title">Services</h3>
                <p class="admin-card-subtitle">Review and manage every service entry</p>
            </div>
            <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle services table">
                <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
            </button>
        </div>
        <div class="admin-card-body" x-show="!collapsed" x-transition>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-y border-gray-200">
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
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($service->featured_image)
                                            <img src="{{ asset('storage/' . $service->featured_image) }}"
                                                 alt="{{ $service->title }}"
                                                 class="w-10 h-10 rounded object-cover mr-3">
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-slate-900">
                                                {{ $service->title }}
                                            </div>
                                            <div class="text-sm text-slate-500">
                                                {{ $service->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">
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
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="text-blue-600 hover:text-blue-900">
                                        Edit
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
                                <td colspan="4" class="px-6 py-4 text-center text-slate-500">
                                    No services found. <a href="{{ route('admin.services.create') }}" class="text-blue-600 hover:text-blue-700">Create your first service</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($services->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
