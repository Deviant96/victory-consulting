@extends('frontend.layouts.app')

@section('title', t('frontend.blog.meta_title', 'Blog') . ' - ' . settings('site.name'))

@section('content')
@php
    // Determine featured and secondary posts in a way that doesn't
    // implicitly change the featured post on every paginated page.

    // If a featured post was not explicitly provided (e.g., by the controller)
    // and we're on the first page, use the first post on that page as featured.
    if (!isset($featuredPost) && method_exists($posts, 'currentPage') && $posts->currentPage() === 1) {
        $featuredPost = $posts->first();
    }

    // Build the secondary posts collection:
    // - If we have a featured post, exclude it from the current page's collection.
    // - Otherwise, use the full current page collection.
    if (isset($featuredPost)) {
        $secondaryPosts = $posts->getCollection()->filter(function ($post) use ($featuredPost) {
            return $post->id !== $featuredPost->id;
        });
    } else {
        $secondaryPosts = $posts->getCollection();
    }
@endphp

<!-- Editorial Header -->
<section class="relative overflow-hidden bg-gradient-to-b from-white to-sky-50/40 py-14 md:py-20">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-[#0481AE]/10 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-12 w-64 h-64 rounded-full bg-[#036494]/10 blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative">
        <div class="max-w-7xl mx-auto" data-animate="fade-up">
            <div class="grid lg:grid-cols-12 gap-6 lg:gap-10 items-end">
                <div class="lg:col-span-8">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-slate-900 mb-4">
                        {{ settings('blog.page_title', t('frontend.blog.heading', 'Our Blog')) }}
                    </h1>
                    <p class="text-base sm:text-lg lg:text-xl text-slate-600 max-w-3xl">
                        {{ settings('blog.page_description', t('frontend.blog.subheading', 'Insights, strategies, and expert perspectives on business growth and success')) }}
                    </p>
                </div>

                <div class="lg:col-span-4">
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm py-4 px-2">
                            <p class="text-lg sm:text-xl font-bold text-slate-900">{{ $posts->total() }}</p>
                            <p class="text-xs text-slate-500">{{ t('frontend.blog.results_suffix', 'results') }}</p>
                        </div>
                        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm py-4 px-2">
                            <p class="text-lg sm:text-xl font-bold text-slate-900">{{ count($categories) }}</p>
                            <p class="text-xs text-slate-500">{{ t('frontend.blog.all_categories', 'All Categories') }}</p>
                        </div>
                        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm py-4 px-2">
                            <p class="text-lg sm:text-xl font-bold text-slate-900">{{ $posts->currentPage() }}</p>
                            <p class="text-xs text-slate-500">Page</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-6 md:py-14 bg-slate-50/70">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8">
                <!-- Main Content -->
                <main class="xl:col-span-8 order-2 xl:order-1">
                    @if($posts->isEmpty())
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 sm:p-10 text-center" data-animate="fade-up">
                        <div class="w-16 h-16 rounded-full bg-slate-100 mx-auto flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-3">{{ t('frontend.blog.no_results', 'No blog posts found matching your filters.') }}</h2>
                        <p class="text-slate-600 mb-6">{{ t('frontend.blog.clear_filters', 'Clear all filters') }}</p>
                        <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#0481AE] text-white font-semibold hover:bg-[#036494] transition">
                            {{ t('frontend.blog.reset_filters', 'Reset') }}
                        </a>
                    </div>
                    @else
                    <!-- Results Meta -->
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-5" data-animate="fade-up">
                        <p class="text-sm sm:text-base text-slate-600">
                            {{ t('frontend.blog.results_prefix', 'Showing') }} <span class="font-semibold text-slate-900">{{ $posts->firstItem() }}</span> {{ t('frontend.blog.results_to', 'to') }}
                            <span class="font-semibold text-slate-900">{{ $posts->lastItem() }}</span> {{ t('frontend.blog.results_of', 'of') }}
                            <span class="font-semibold text-slate-900">{{ $posts->total() }}</span> {{ t('frontend.blog.results_suffix', 'results') }}
                        </p>
                        <a href="#latest-stories" class="text-sm font-semibold text-[#0481AE] hover:text-[#036494] transition">Jump to latest ↓</a>
                    </div>

                    <!-- Featured Story -->
                    @if($featuredPost)
                    @php($featuredDate = $featuredPost->published_at ?? $featuredPost->created_at)
                    <article class="group relative overflow-hidden rounded-3xl bg-slate-900 text-white mb-8" data-animate="fade-up">
                        @if($featuredPost->featured_image)
                        <img src="{{ asset('storage/' . $featuredPost->featured_image) }}" alt="{{ $featuredPost->title }}" class="w-full h-[320px] sm:h-[380px] object-cover opacity-70 group-hover:scale-[1.02] transition duration-500">
                        @else
                        <div class="w-full h-[320px] sm:h-[380px] bg-gradient-to-br from-[#0481AE] to-[#036494]"></div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/10"></div>
                        <div class="absolute inset-0 p-5 sm:p-8 lg:p-10 flex flex-col justify-end">
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-3 text-xs sm:text-sm">
                                @if($featuredPost->category)
                                <span class="inline-flex items-center rounded-full bg-white/20 backdrop-blur px-3 py-1 font-semibold">{{ $featuredPost->category }}</span>
                                @endif
                                <time datetime="{{ $featuredDate->format('Y-m-d') }}" class="text-white/90">{{ $featuredDate->format('M d, Y') }}</time>
                            </div>

                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight mb-3 max-w-4xl">
                                <a href="{{ route('blog.show', $featuredPost->slug) }}" class="hover:text-sky-200 transition">
                                    {{ $featuredPost->title }}
                                </a>
                            </h2>

                            <p class="text-white/90 text-sm sm:text-base max-w-3xl line-clamp-2 sm:line-clamp-3 mb-4">{{ $featuredPost->excerpt }}</p>

                            <div class="flex items-center justify-between gap-4">
                                @if($featuredPost->author)
                                <span class="text-xs sm:text-sm text-white/90">{{ t('frontend.blog.by_prefix', 'By') }} {{ $featuredPost->author }}</span>
                                @else
                                <span></span>
                                @endif
                                <a href="{{ route('blog.show', $featuredPost->slug) }}" class="inline-flex items-center gap-2 text-sm sm:text-base font-semibold text-white hover:text-sky-200 transition">
                                    {{ t('frontend.blog.read_more', 'Read More') }}
                                    <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endif

                    <!-- Latest Stories -->
                    <section id="latest-stories" class="scroll-mt-24">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Latest Stories</h3>
                        </div>

                        @if($secondaryPosts->isEmpty())
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 text-slate-600">
                            More stories will appear here as new posts are published.
                        </div>
                        @else
                        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6" data-animate-stagger="120">
                            @foreach($secondaryPosts as $post)
                            @php($publishedDate = $post->published_at ?? $post->created_at)
                            <article class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition" data-animate="fade-up">
                                @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-40 sm:h-48 object-cover group-hover:scale-[1.02] transition duration-500">
                                @else
                                <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-[#0481AE] to-[#036494] flex items-center justify-center">
                                    <svg class="w-14 h-14 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                </div>
                                @endif

                                <div class="p-4 sm:p-6">
                                    <div class="flex items-center text-xs sm:text-sm text-slate-500 mb-3">
                                        @if($post->category)
                                        <span class="text-[#0481AE] font-semibold">{{ $post->category }}</span>
                                        <span class="mx-2">•</span>
                                        @endif
                                        <time datetime="{{ $publishedDate->format('Y-m-d') }}">{{ $publishedDate->format('M d, Y') }}</time>
                                    </div>

                                    <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-3 leading-snug">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-[#0481AE] transition">
                                            {{ $post->title }}
                                        </a>
                                    </h2>

                                    <p class="text-slate-600 text-sm sm:text-base mb-4 line-clamp-3">{{ $post->excerpt }}</p>

                                    <div class="flex items-center justify-between gap-3">
                                        @if($post->author)
                                        <span class="text-xs sm:text-sm text-slate-500">{{ t('frontend.blog.by_prefix', 'By') }} {{ $post->author }}</span>
                                        @else
                                        <span></span>
                                        @endif
                                        <a href="{{ route('blog.show', $post->slug) }}" class="text-sm font-semibold text-[#0481AE] hover:text-[#036494] transition">
                                            {{ t('frontend.blog.read_more', 'Read More') }} →
                                        </a>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                        @endif
                    </section>

                    <!-- Pagination -->
                    <div class="mt-8 sm:mt-10">
                        {{ $posts->links() }}
                    </div>
                    @endif
                </main>

                <!-- Sidebar -->
                <aside class="xl:col-span-4 order-1 xl:order-2 space-y-4 lg:space-y-6 xl:sticky xl:top-16 self-start">
                    @if(settings('blog.enable_filters', '1') == '1')
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-3.5 sm:p-5 lg:p-6" data-animate="fade-right">
                        <div class="flex items-center justify-between mb-4 sm:mb-5">
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">{{ t('frontend.blog.filters_title', 'Filters') }}</h2>
                            @if(request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('blog.index') }}" class="text-sm font-semibold text-[#0481AE] hover:text-[#036494] transition">
                                {{ t('frontend.blog.reset_filters', 'Reset') }}
                            </a>
                            @endif
                        </div>

                        <form action="{{ route('blog.index') }}" method="GET" id="filterForm" class="space-y-3 sm:space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">{{ t('frontend.blog.search_label', 'Search') }}</label>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="{{ t('frontend.blog.search_placeholder', 'Search posts...') }}"
                                    class="w-full px-3.5 sm:px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0481AE] focus:border-transparent"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">{{ t('frontend.blog.category_label', 'Category') }}</label>
                                <select name="category" class="w-full px-3.5 sm:px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0481AE] focus:border-transparent">
                                    <option value="">{{ t('frontend.blog.all_categories', 'All Categories') }}</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">{{ t('frontend.blog.sort_by', 'Sort By') }}</label>
                                <select name="sort" class="w-full px-3.5 sm:px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0481AE] focus:border-transparent">
                                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>{{ t('frontend.blog.sort_latest', 'Latest First') }}</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ t('frontend.blog.sort_oldest', 'Oldest First') }}</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-1 gap-2.5 sm:gap-3 pt-1">
                                <button type="submit" class="w-full bg-[#0481AE] text-white px-4 py-2.5 rounded-xl font-semibold hover:bg-[#036494] transition">
                                    {{ t('frontend.blog.apply_filters', 'Apply Filters') }}
                                </button>
                                <a href="{{ route('blog.index') }}" class="w-full bg-slate-100 text-slate-700 px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-200 transition text-center">
                                    {{ t('frontend.blog.reset_filters', 'Reset') }}
                                </a>
                            </div>
                        </form>

                        @if(request()->hasAny(['search', 'category', 'sort']))
                        <div class="mt-4 pt-4 sm:mt-5 sm:pt-5 border-t border-slate-200">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3">{{ t('frontend.blog.active_filters', 'Active Filters:') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @if(request('search'))
                                <span class="inline-flex items-center text-xs sm:text-sm px-3 py-1 rounded-full bg-slate-100 text-slate-700">
                                    {{ t('frontend.blog.search_prefix', 'Search:') }} {{ request('search') }}
                                </span>
                                @endif
                                @if(request('category'))
                                <span class="inline-flex items-center text-xs sm:text-sm px-3 py-1 rounded-full bg-slate-100 text-slate-700">
                                    {{ t('frontend.blog.category_prefix', 'Category:') }} {{ request('category') }}
                                </span>
                                @endif
                                @if(request('sort'))
                                <span class="inline-flex items-center text-xs sm:text-sm px-3 py-1 rounded-full bg-slate-100 text-slate-700">
                                    {{ t('frontend.blog.sort_by', 'Sort By') }}: {{ request('sort') == 'oldest' ? t('frontend.blog.sort_oldest', 'Oldest First') : t('frontend.blog.sort_latest', 'Latest First') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-3.5 sm:p-5 lg:p-6" data-animate="fade-left">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Popular categories</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($categories as $category)
                            <a
                                href="{{ route('blog.index', array_merge(request()->except('page'), ['category' => $category])) }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium border transition {{ request('category') == $category ? 'bg-[#0481AE] text-white border-[#0481AE]' : 'bg-slate-50 text-slate-700 border-slate-200 hover:border-[#0481AE] hover:text-[#0481AE]' }}"
                            >
                                {{ $category }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
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
