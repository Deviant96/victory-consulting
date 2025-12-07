@extends('admin.layouts.app')

@section('title', 'Create Service')
@section('page-title', 'Create Service')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                    Slug <span class="text-gray-500 text-xs">(auto-generated if empty)</span>
                </label>
                <input type="text" 
                       name="slug" 
                       id="slug" 
                       value="{{ old('slug') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Summary -->
            <div>
                <label for="summary" class="block text-sm font-medium text-gray-700 mb-1">
                    Summary
                </label>
                <textarea name="summary" 
                          id="summary" 
                          rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('summary') }}</textarea>
                @error('summary')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="10"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price Note -->
            <div>
                <label for="price_note" class="block text-sm font-medium text-gray-700 mb-1">
                    Price Note
                </label>
                <input type="text" 
                       name="price_note" 
                       id="price_note" 
                       value="{{ old('price_note') }}"
                       placeholder="e.g., Starting from $500"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">
                    Featured Image
                </label>
                <input type="file" 
                       name="featured_image" 
                       id="featured_image" 
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Highlights -->
            <div x-data="highlightsManager()">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Highlights / Key Points
                </label>
                
                <div class="space-y-2 mb-3">
                    <template x-for="(highlight, index) in highlights" :key="index">
                        <div class="flex gap-2">
                            <input type="text" 
                                   :name="'highlights[' + index + '][label]'" 
                                   x-model="highlight.label"
                                   placeholder="Enter highlight"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="button" 
                                    @click="removeHighlight(index)"
                                    class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" 
                        @click="addHighlight"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-sm text-gray-700 hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Highlight
                </button>
            </div>

            <!-- Published -->
            <div class="flex items-center">
                <input type="checkbox"
                       name="published"
                       id="published"
                       value="1"
                       {{ old('published') ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="published" class="ml-2 text-sm text-gray-700">
                    Publish this service
                </label>
            </div>
        </div>

        @include('admin.components.content-translation-tabs', [
            'languages' => $languages,
            'model' => null,
            'fields' => [
                'title' => 'Title',
                'summary' => 'Summary',
                'description' => 'Description',
                'price_note' => 'Price Note',
            ],
        ])

        <!-- Actions -->
        <div class="mt-6 flex gap-4">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Create Service
            </button>
            <a href="{{ route('admin.services.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function highlightsManager() {
        return {
            highlights: [],
            addHighlight() {
                this.highlights.push({ label: '' });
            },
            removeHighlight(index) {
                this.highlights.splice(index, 1);
            }
        }
    }
</script>
@endpush
@endsection
