@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.about-sections.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to About Sections
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit About Section</h1>

    <form action="{{ route('admin.about-sections.update', $aboutSection) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
            <input type="text" name="title" id="title" value="{{ old('title', $aboutSection->title) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
            @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
            <textarea name="description" id="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $aboutSection->description) }}</textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Brief introduction shown below the title</p>
        </div>

        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
            <textarea name="content" id="content" rows="8" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 @enderror">{{ old('content', $aboutSection->content) }}</textarea>
            @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Main content of the section</p>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
            @if($aboutSection->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $aboutSection->image) }}" alt="{{ $aboutSection->title }}" class="w-48 h-24 object-cover rounded-lg">
            </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('image') border-red-500 @enderror">
            @error('image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Recommended size: 1200x600px. Leave empty to keep current image.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                <input type="number" name="order" id="order" value="{{ old('order', $aboutSection->order) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('order') border-red-500 @enderror">
                @error('order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
            </div>

            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $aboutSection->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Update Section
            </button>
            <a href="{{ route('admin.about-sections.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
