@extends('admin.layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Team Members</h1>
    <a href="{{ route('admin.team.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
        Add Team Member
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($teamMembers->isEmpty())
    <div class="p-12 text-center text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <p class="text-lg">No team members found</p>
        <a href="{{ route('admin.team.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Add your first team member</a>
    </div>
    @else
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expertise</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($teamMembers as $member)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="h-12 w-12 rounded-full object-cover">
                    @else
                    <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500 font-semibold">{{ substr($member->name, 0, 1) }}</span>
                    </div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ $member->role }}</div>
                </td>
                <td class="px-6 py-4">
                    @if($member->expertise && count($member->expertise) > 0)
                    <div class="flex flex-wrap gap-1">
                        @foreach(array_slice($member->expertise, 0, 2) as $skill)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $skill }}
                        </span>
                        @endforeach
                        @if(count($member->expertise) > 2)
                        <span class="text-xs text-gray-500">+{{ count($member->expertise) - 2 }} more</span>
                        @endif
                    </div>
                    @else
                    <span class="text-sm text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    @if($member->email)
                    <div>{{ $member->email }}</div>
                    @endif
                    @if($member->linkedin)
                    <a href="{{ $member->linkedin }}" target="_blank" class="text-blue-600 hover:text-blue-700">LinkedIn</a>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.team.edit', $member) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this team member?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
