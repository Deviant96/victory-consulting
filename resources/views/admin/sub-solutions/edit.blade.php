@extends('admin.layouts.app')
    
@section('title', 'Edit Sub-Solution')
@section('page-title', 'Edit Sub-Solution')
@section('page-description', 'Update sub-industry details')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Edit Sub-Solution</h1>
    <p class="text-gray-600 mt-2">Update sub-industry details</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.sub-solutions.update', $subSolution) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="business_solution_id" class="block text-sm font-medium text-gray-700 mb-2">Industry <span class="text-red-500">*</span></label>
            <select name="business_solution_id" id="business_solution_id" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('business_solution_id') border-red-500 @enderror">
                <option value="">Select an industry...</option>
                @foreach($businessSolutions as $solution)
                <option value="{{ $solution->id }}" {{ old('business_solution_id', $subSolution->business_solution_id) == $solution->id ? 'selected' : '' }}>
                    {{ $solution->title }}
                </option>
                @endforeach
            </select>
            @error('business_solution_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title', $subSolution->translate('title', config('app.fallback_locale'))) }}" required placeholder="e.g., E-commerce Solutions" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
            @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order <span class="text-red-500">*</span></label>
            <input type="number" name="order" id="order" value="{{ old('order', $subSolution->order) }}" min="0" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('order') border-red-500 @enderror">
            @error('order')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
        </div>

        <div class="mb-6">
            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $subSolution->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <label class="ml-2 block text-sm text-gray-700">Active</label>
            </div>
            <p class="text-gray-500 text-sm mt-1">Only active sub-solutions are displayed on the frontend</p>
        </div>

        @include('admin.components.content-translation-tabs', [
            'languages' => $languages,
            'model' => $subSolution,
            'fields' => [
                'title' => 'Title',
            ],
        ])

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Update Sub-Solution
            </button>
            <a href="{{ route('admin.sub-solutions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
