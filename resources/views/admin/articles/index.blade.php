@extends('admin.layouts.app')
    
@section('title', 'Articles')
@section('page-title', 'Articles')
@section('page-description', 'Search and filter knowledge base entries.')

@section('content')
<div class="space-y-6">
<div x-data="collapsibleCard('articles-filters')" class="admin-card p-6">
    <div class="admin-card-header flex-col md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Articles</h1>
            <p class="admin-card-subtitle">Find content by keywords, category, or status</p>
        </div>
        <div class="flex items-center gap-2 mt-4 md:mt-0">
            <a href="{{ route('admin.articles.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-md transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Article
            </a>
        </div>
        <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-xl hover:bg-slate-100 transition absolute right-1 top-1" aria-label="Toggle article filters">
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
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search articles..."
                           class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
            <div class="flex-1">
                <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Category</label>
                <input type="text" name="category" value="{{ $category ?? '' }}" placeholder="Category"
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div class="w-full lg:w-48">
                <label class="block text-xs uppercase tracking-wide text-slate-500 mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">All Statuses</option>
                    <option value="published" @selected(($status ?? '') === 'published')>Published</option>
                    <option value="draft" @selected(($status ?? '') === 'draft')>Draft</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition transform hover:-translate-y-0.5">Filter</button>
                <a href="{{ route('admin.articles.index') }}" class="px-4 py-2.5 border border-slate-200 rounded-xl text-slate-700 hover:bg-slate-50 transition">Reset</a>
            </div>
        </form>
    </div>
</div>

<div x-data="collapsibleCard('articles-table')" class="admin-card overflow-hidden">
    @if($posts->isEmpty())
    <div class="p-12 text-center text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
        </svg>
        <p class="text-lg">No articles found</p>
        <a href="{{ route('admin.articles.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Write your first article</a>
    </div>
    @else
    <div class="admin-card-header px-6 pt-6 pb-4">
        <div>
            <h3 class="admin-card-title">Article Library</h3>
            <p class="admin-card-subtitle">Browse, edit, and publish articles</p>
        </div>
        <button type="button" @click="toggle()" :aria-expanded="!collapsed" class="p-2 rounded-xl hover:bg-slate-100 transition" aria-label="Toggle articles table">
            <svg class="w-5 h-5 text-slate-500" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </button>
    </div>
    <div class="admin-card-body" x-show="!collapsed" x-transition>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($posts as $post)
                        <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        @if($post->featured_image)
                        <img class="h-10 w-10 rounded-lg object-cover mr-3" src="{{ asset('storage/' . $post->featured_image) }}" alt="">
                        @endif
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($post->translate('title', config('app.fallback_locale')), 60) }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($post->translate('excerpt', config('app.fallback_locale')), 80) }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($post->category)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $post->category }}
                    </span>
                    @else
                    <span class="text-sm text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $post->author ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($post->published)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Published
                    </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Draft
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    @php($publishedDate = $post->published_at ?? $post->created_at)
                    {{ $publishedDate ? $publishedDate->format('M d, Y') : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @if($post->published)
                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="text-gray-600 hover:text-gray-900 mr-3" title="View">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    @endif
                    <a href="{{ route('admin.articles.edit', $post) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('admin.articles.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </table>
    </div>
    @endif
</div>
</div>
@endsection
