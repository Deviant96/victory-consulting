@extends('frontend.layouts.app')

@section('title', t('frontend.blog.meta_title', 'Blog') . ' - ' . settings('site.name'))

@section('content')
<!-- Page Header -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto text-center" data-animate="fade-up">
            <h1 class="text-5xl font-bold mb-4">{{ settings('blog.page_title', t('frontend.blog.heading', 'Our Blog')) }}</h1>
            <p class="text-xl text-black/70">
                {{ settings('blog.page_description', t('frontend.blog.subheading', 'Insights, strategies, and expert perspectives on business growth and success')) }}
            </p>
        </div>
    </div>
</section>

<!-- Blog Content with Filters -->
<section class="py-4 md:py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filter Sidebar -->
                @if(settings('blog.enable_filters', '1') == '1')
                <aside class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4" data-animate="fade-right">
                        <h2 class="text-2xl font-bold mb-6">{{ t('frontend.blog.filters_title', 'Filters') }}</h2>
                        
                        <form action="{{ route('blog.index') }}" method="GET" id="filterForm">
                            <!-- Search -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('frontend.blog.search_label', 'Search') }}</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="{{ t('frontend.blog.search_placeholder', 'Search posts...') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0481AE] focus:border-transparent">
                            </div>

                            <!-- Category Filter -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('frontend.blog.category_label', 'Category') }}</label>
                                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0481AE] focus:border-transparent">
                                    <option value="">{{ t('frontend.blog.all_categories', 'All Categories') }}</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date Range Filter -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('frontend.blog.date_from', 'Date From') }}</label>
                                <input type="text" name="date_from" value="{{ request('date_from') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0481AE] focus:border-transparent datepicker" placeholder="Select date">
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('frontend.blog.date_to', 'Date To') }}</label>
                                <input type="text" name="date_to" value="{{ request('date_to') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0481AE] focus:border-transparent datepicker" placeholder="Select date">
                            </div>

                            <!-- Sort By -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ t('frontend.blog.sort_by', 'Sort By') }}</label>
                                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0481AE] focus:border-transparent">
                                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>{{ t('frontend.blog.sort_latest', 'Latest First') }}</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ t('frontend.blog.sort_oldest', 'Oldest First') }}</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-3">
                                <button type="submit" class="flex-1 bg-[#0481AE] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#036494] transition">
                                    {{ t('frontend.blog.apply_filters', 'Apply Filters') }}
                                </button>
                                <a href="{{ route('blog.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                                    {{ t('frontend.blog.reset_filters', 'Reset') }}
                                </a>
                            </div>
                        </form>

                        <!-- Active Filters Display -->
                        @if(request()->hasAny(['search', 'category', 'date_from', 'date_to']))
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ t('frontend.blog.active_filters', 'Active Filters:') }}</h3>
                            <div class="space-y-2">
                                @if(request('search'))
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">{{ t('frontend.blog.search_prefix', 'Search:') }} {{ request('search') }}</span>
                                </div>
                                @endif
                                @if(request('category'))
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">{{ t('frontend.blog.category_prefix', 'Category:') }} {{ request('category') }}</span>
                                </div>
                                @endif
                                @if(request('date_from'))
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">{{ t('frontend.blog.from_prefix', 'From:') }} {{ request('date_from') }}</span>
                                </div>
                                @endif
                                @if(request('date_to'))
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">{{ t('frontend.blog.to_prefix', 'To:') }} {{ request('date_to') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </aside>
                @endif

                <!-- Blog Posts -->
                <main class="{{ settings('blog.enable_filters', '1') == '1' ? 'lg:w-3/4' : 'w-full' }}">
                    @if($posts->isEmpty())
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xl text-gray-600">{{ t('frontend.blog.no_results', 'No blog posts found matching your filters.') }}</p>
                        <a href="{{ route('blog.index') }}" class="inline-block mt-4 text-[#0481AE] hover:text-[#036494] font-semibold">
                            {{ t('frontend.blog.clear_filters', 'Clear all filters') }}
                        </a>
                    </div>
                    @else
                    <!-- Results Count -->
                    <div class="mb-6" data-animate="fade-up">
                        <p class="text-gray-600">
                            {{ t('frontend.blog.results_prefix', 'Showing') }} <span class="font-semibold">{{ $posts->firstItem() }}</span> {{ t('frontend.blog.results_to', 'to') }}
                            <span class="font-semibold">{{ $posts->lastItem() }}</span> {{ t('frontend.blog.results_of', 'of') }}
                            <span class="font-semibold">{{ $posts->total() }}</span> {{ t('frontend.blog.results_suffix', 'results') }}
                        </p>
                    </div>

                    <!-- Posts Grid -->
                    <div class="grid md:grid-cols-2 gap-6" data-animate-stagger="120">
                        @foreach($posts as $post)
                        <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden" data-animate="fade-up">
                            @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                            @else
                            <div class="w-full h-48 bg-gradient-to-br from-[#0481AE] to-[#036494] flex items-center justify-center">
                                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            @endif
                            
                            <div class="p-6">
                                <!-- Meta -->
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    @if($post->category)
                                    <span class="text-[#0481AE] font-semibold">{{ $post->category }}</span>
                                    <span class="mx-2">•</span>
                                    @endif
                                    @php($publishedDate = $post->published_at ?? $post->created_at)
                                    <time datetime="{{ $publishedDate->format('Y-m-d') }}">
                                        {{ $publishedDate->format('M d, Y') }}
                                    </time>
                                </div>

                                <!-- Title -->
                                <h2 class="text-xl font-bold text-gray-900 mb-3">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-[#0481AE] transition">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                <!-- Excerpt -->
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>

                                <!-- Author & Read More -->
                                <div class="flex items-center justify-between">
                                    @if($post->author)
                                    <span class="text-sm text-gray-600">{{ t('frontend.blog.by_prefix', 'By') }} {{ $post->author }}</span>
                                    @endif
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-[#0481AE] font-semibold hover:text-[#036494] transition">
                                        {{ t('frontend.blog.read_more', 'Read More') }} →
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-br from-[#0481AE] to-[#035f7f] text-white py-12 md:py-24">
    <div class="container mx-auto px-4 text-center max-w-4xl">
        <div data-animate="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 md:mb-6">{{ settings('blog.cta_title', t('frontend.blog.newsletter_heading', 'Stay Updated')) }}</h2>
            <p class="text-base md:text-xl mb-6 md:mb-8 max-w-2xl mx-auto text-blue-50">
                {{ settings('blog.cta_description', t('frontend.blog.newsletter_subheading', 'Subscribe to our newsletter for the latest insights and business strategies')) }}
            </p>
            <form action="#" method="POST" class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @csrf
                <input type="email" name="email" placeholder="{{ t('frontend.blog.newsletter_placeholder', 'Enter your email') }}" required class="w-full sm:w-auto px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#0481AE]">
                <button type="submit" class="bg-white text-[#0481AE] px-8 py-3 rounded-lg font-semibold hover:bg-[#E6F0F6] transition">
                    {{ settings('blog.cta_button', t('frontend.blog.newsletter_cta', 'Subscribe')) }}
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
