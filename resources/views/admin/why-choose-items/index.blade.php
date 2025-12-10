@extends('admin.layouts.app')
    
@section('title', 'Why Choose Us Items')
@section('page-title', 'Why Choose Us Items')
@section('page-description', 'Manage the reasons why customers should choose us.')

@section('content')
<div x-data="collapsibleCard('why-choose-filters')" class="admin-card p-6">
    <div class="admin-card-header flex-col md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Why Choose Us Items</h1>
            <p class="admin-card-subtitle">Manage the reasons why customers should choose us</p>
        </div>
        <div class="flex items-center gap-2 mt-4 md:mt-0">
            <a href="{{ route('admin.why-choose-items.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Item
            </a>
        </div>
        <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-xl hover:bg-slate-100 transition absolute right-1 top-1" aria-label="Toggle filters">
            <svg class="w-4 h-4 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </button>
    </div>
    <div class="admin-card-body" x-show="!collapsed" x-transition>
        <form method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
            <div class="flex-1">
                <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Search</label>
                <div class="relative">
                    <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0011.15 11.15z" />
                    </svg>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search items..."
                           class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
            <div class="w-full lg:w-48">
                <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">All Statuses</option>
                    <option value="active" @selected(($status ?? '') === 'active')>Active</option>
                    <option value="inactive" @selected(($status ?? '') === 'inactive')>Inactive</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition transform hover:-translate-y-0.5">Filter</button>
                <a href="{{ route('admin.why-choose-items.index') }}" class="px-4 py-2.5 border border-slate-200 rounded-xl text-slate-700 hover:bg-slate-50 transition">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    @if($items->isEmpty())
    <div class="p-12 text-center text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-lg">No items found</p>
        <a href="{{ route('admin.why-choose-items.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Add your first item</a>
    </div>
    @else
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($items as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $item->order }}
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $item->translate('title', config('app.fallback_locale')) }}</div>
                    <div class="text-sm text-gray-500">{{ Str::limit($item->translate('description', config('app.fallback_locale')), 80) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $item->icon ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($item->is_active)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Inactive
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.why-choose-items.edit', $item) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('admin.why-choose-items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
