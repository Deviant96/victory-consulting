@extends('frontend.layouts.app')

@section('title', 'Blog - ' . settings('site.name'))

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-4">Our Blog</h1>
            <p class="text-xl text-blue-100">
                Insights, strategies, and expert perspectives on business growth and success
            </p>
        </div>
    </div>
</section>

<!-- Blog Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($posts->isEmpty())
        <div class="text-center py-12">
            <p class="text-xl text-gray-600">No blog posts available at the moment.</p>
        </div>
        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover">
                @else
                <div class="w-full h-56 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    <!-- Meta -->
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        @if($post->category)
                        <span class="text-blue-600 font-semibold">{{ $post->category }}</span>
                        <span class="mx-2">•</span>
                        @endif
                        <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </div>

                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">
                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600 transition">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <!-- Excerpt -->
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>

                    <!-- Author & Read More -->
                    <div class="flex items-center justify-between">
                        @if($post->author)
                        <span class="text-sm text-gray-600">By {{ $post->author }}</span>
                        @endif
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 font-semibold hover:text-blue-700 transition">
                            Read More →
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</section>

<!-- Newsletter CTA -->
<section class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
        <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
            Subscribe to our newsletter for the latest insights and business strategies
        </p>
        <form action="#" method="POST" class="max-w-md mx-auto flex gap-4">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" required class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                Subscribe
            </button>
        </form>
    </div>
</section>
@endsection
