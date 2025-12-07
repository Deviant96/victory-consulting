@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.faqs.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to FAQs
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit FAQ</h1>

    <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="question" class="block text-sm font-medium text-gray-700 mb-2">Question *</label>
            <input type="text" name="question" id="question" value="{{ old('question', $faq->question) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('question') border-red-500 @enderror">
            @error('question')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">Answer *</label>
            <textarea name="answer" id="answer" rows="6" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('answer') border-red-500 @enderror">{{ old('answer', $faq->answer) }}</textarea>
            @error('answer')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <input type="text" name="category" id="category" value="{{ old('category', $faq->category) }}" placeholder="e.g., General, Pricing, Services" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror">
                @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                <input type="number" name="order" id="order" value="{{ old('order', $faq->order) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 @error('order') border-red-500 @enderror">
                @error('order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
            </div>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="published" value="1" {{ old('published', $faq->published) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-700">Published</span>
            </label>
        </div>

        @include('admin.components.content-translation-tabs', [
            'languages' => $languages,
            'model' => $faq,
            'fields' => [
                'question' => 'Question',
                'answer' => 'Answer',
            ],
        ])

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                Update FAQ
            </button>
            <a href="{{ route('admin.faqs.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
