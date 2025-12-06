@extends('admin.layouts.app')
    
@section('title', 'Missions')
@section('page-title', 'Company Mission')
@section('page-description', 'Manage your company mission statement.')

@section('content')
<div class="admin-card p-6 mb-6">
    <div class="admin-card-header flex-col md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Company Mission</h1>
            <p class="admin-card-subtitle">Manage your company mission statement</p>
        </div>
        <div class="flex items-center gap-2 mt-4 md:mt-0">
            <a href="{{ route('admin.missions.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Mission
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    @if($missions->isEmpty())
    <div class="p-12 text-center text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-lg">No mission found</p>
        <a href="{{ route('admin.missions.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Add mission statement</a>
    </div>
    @else
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($missions as $mission)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        @if($mission->image)
                        <img src="{{ asset('storage/' . $mission->image) }}" alt="{{ $mission->title }}" class="w-10 h-10 rounded object-cover mr-3">
                        @endif
                        <div class="text-sm font-medium text-gray-900">{{ $mission->title }}</div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-500 truncate max-w-md">{{ Str::limit($mission->content, 100) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $mission->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $mission->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.missions.edit', $mission) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.missions.destroy', $mission) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this mission?')" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $missions->links() }}
    </div>
    @endif
</div>
@endsection
