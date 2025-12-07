@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.visions.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Visions
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Vision</h1>

    <form action="{{ route('admin.visions.update', $vision) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
            <input type="text" name="title" id="title" value="{{ old('title', $vision->title) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
            <textarea name="content" id="content" rows="6" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('content', $vision->content) }}</textarea>
            @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Describe your company's vision</p>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image (Woman offering handshake)</label>
            @if($vision->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $vision->image) }}" alt="{{ $vision->title }}" class="w-48 h-24 object-cover rounded-lg">
            </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Recommended: Image of a woman offering handshake positioned to the left. Leave empty to keep current image.</p>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $vision->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-700">Active</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Update Vision
            </button>
            <a href="{{ route('admin.visions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
