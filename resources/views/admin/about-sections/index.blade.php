@extends('admin.layouts.app')
    
@section('title', 'About Sections')
@section('page-title', 'About Sections')
@section('page-description', 'Manage content for the About Us page.')

@section('content')
<div x-data="collapsibleCard('about-filters')" class="admin-card p-6">
    <div class="admin-card-header flex-col md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">About Sections</h1>
            <p class="admin-card-subtitle">Manage content for the About Us page</p>
        </div>
        <div class="flex items-center gap-2 mt-4 md:mt-0">
            <a href="{{ route('admin.about-sections.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Section
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    @if($sections->isEmpty())
    <div class="p-12 text-center text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-lg">No sections found</p>
        <a href="{{ route('admin.about-sections.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Add your first section</a>
    </div>
    @else
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($sections as $section)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $section->order }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        @if($section->image)
                        <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title }}" class="w-10 h-10 rounded object-cover mr-3">
                        @endif
                        <div class="text-sm font-medium text-gray-900">{{ $section->title }}</div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ $section->description }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $section->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.about-sections.edit', $section) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.about-sections.destroy', $section) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this section?')" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $sections->links() }}
    </div>
    @endif
</div>
@endsection
