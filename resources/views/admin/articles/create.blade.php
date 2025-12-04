@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.articles.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Articles
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Write Article</h1>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" x-data="tagsManager()">
        @csrf

        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
            <textarea name="excerpt" id="excerpt" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500" placeholder="Brief summary (optional)">{{ old('excerpt') }}</textarea>
            @error('excerpt')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
            <textarea name="content" id="content" rows="15" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">{{ old('content') }}</textarea>
            @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Supports HTML formatting</p>
        </div>

        <div class="mb-6">
            <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
            <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('featured_image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="e.g., Business Strategy" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Author</label>
                <input type="text" name="author" id="author" value="{{ old('author') }}" placeholder="e.g., John Doe" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('author')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
            <div class="space-y-3">
                <template x-for="(tag, index) in tags" :key="index">
                    <div class="flex gap-2">
                        <input type="text" :name="'tags[' + index + ']'" x-model="tags[index]" placeholder="e.g., Leadership" class="flex-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" @click="removeTag(index)" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">
                            Remove
                        </button>
                    </div>
                </template>
            </div>
            <button type="button" @click="addTag()" class="mt-3 px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition">
                Add Tag
            </button>
        </div>

        <div class="mb-6">
            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
            <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            @error('published_at')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Leave empty to use current date/time when publishing</p>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="published" value="1" {{ old('published') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-700">Publish immediately</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Create Article
            </button>
            <a href="{{ route('admin.articles.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function tagsManager() {
    return {
        tags: [''],
        addTag() {
            this.tags.push('');
        },
        removeTag(index) {
            this.tags.splice(index, 1);
            if (this.tags.length === 0) {
                this.tags = [''];
            }
        }
    }
}
</script>
@endsection
