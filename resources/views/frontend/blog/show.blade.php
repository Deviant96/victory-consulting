@extends('frontend.layouts.app')

@section('title', $post->title . ' - ' . settings('site.name'))
@section('description', $post->excerpt)

@section('content')
<!-- Breadcrumb -->
<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-[#0481AE]">{{ t('frontend.navigation.home', 'Home') }}</a>
            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <a href="{{ route('blog.index') }}" class="hover:text-[#0481AE]">{{ t('frontend.navigation.blog', 'Blog') }}</a>
            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-900">{{ Str::limit($post->title, 50) }}</span>
        </div>
    </div>
</section>

<!-- Article -->
<article class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <header class="mb-8">
                @if($post->category)
                <span class="inline-block bg-[#D0E9F8] text-[#0481AE] text-sm font-semibold px-4 py-1 rounded-full mb-4">
                    {{ $post->category }}
                </span>
                @endif
                
                <h1 class="text-5xl font-bold text-gray-900 mb-6">{{ $post->title }}</h1>
                
                @php($publishedDate = $post->published_at ?? $post->created_at)
                <div class="flex items-center text-gray-600 mb-6">
                    @if($post->author)
                    <span class="font-semibold">{{ $post->author }}</span>
                    <span class="mx-3">•</span>
                    @endif
                    <time datetime="{{ $publishedDate->format('Y-m-d') }}">
                        {{ $publishedDate->format('F d, Y') }}
                    </time>
                    <span class="mx-3">•</span>
                    <span>{{ $post->read_time ?? t('frontend.blog.show.read_time_default', '5 min read') }}</span>
                </div>

                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
                @endif
            </header>

            <!-- Excerpt -->
            @if($post->excerpt)
            <div class="text-xl text-gray-700 leading-relaxed mb-8 pb-8 border-b border-gray-200">
                {{ $post->excerpt }}
            </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none mb-12">
                {!! $post->content !!}
            </div>

            <!-- Tags -->
            @if($post->tags && count($post->tags) > 0)
            <div class="mb-8 pb-8 border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ t('frontend.blog.show.tags_heading', 'Tags') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Author Box -->
            @if($post->author)
            <div class="bg-gray-50 rounded-lg p-6 mb-12">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ t('frontend.blog.show.about_author_heading', 'About the Author') }}</h3>
                <p class="text-gray-700">
                    <strong>{{ $post->author }}</strong> {{ str_replace(':site', settings('site.name'), t('frontend.blog.show.about_author_body', 'is a contributor to the :site blog, sharing insights on business strategy and growth.')) }}
                </p>
            </div>
            @endif

            <!-- Share -->
            <div class="flex items-center justify-between border-t border-b border-gray-200 py-6 mb-12">
                <span class="font-semibold text-gray-900">{{ t('frontend.blog.show.share_label', 'Share this article:') }}</span>
                <div class="flex gap-4">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="text-gray-600 hover:text-[#1DA1F2] transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" class="text-gray-600 hover:text-[#0077B5] transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Related Posts -->
@if($relatedPosts->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">{{ t('frontend.blog.show.related_heading', 'Related Articles') }}</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($relatedPosts as $related)
            <a href="{{ route('blog.show', $related->slug) }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden block">
                @if($related->featured_image)
                <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    @if($related->category)
                    <span class="text-sm text-[#0481AE] font-semibold">{{ $related->category }}</span>
                    @endif
                    <h3 class="text-xl font-bold text-gray-900 mb-2 mt-2">{{ $related->title }}</h3>
                    <p class="text-gray-600 line-clamp-2 mb-3">{{ $related->excerpt }}</p>
                    @php($relatedDate = $related->published_at ?? $related->created_at)
                    <span class="text-sm text-gray-500">{{ $relatedDate->format('M d, Y') }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section class="bg-[#FFE7D5] text-white py-8 max-w-5xl mx-auto rounded-xl shadow-xl mb-16">
    <div class="container mx-auto px-2 text-center">
        <h2 class="text-3xl font-bold mb-4 text-[#0481AE]">{{ t('frontend.blog.show.cta_heading', 'Ready to Transform Your Business?') }}</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto text-[#0481AE]">
            {{ t('frontend.blog.show.cta_subheading', "Let's discuss how our expertise can help you achieve your goals") }}
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-white text-[#0481AE] px-8 py-3 rounded-lg font-semibold hover:bg-[#E6F0F6] transition">
            {{ t('frontend.about.cta_primary', 'Get in Touch') }}
        </a>
    </div>
</section>
@endsection
