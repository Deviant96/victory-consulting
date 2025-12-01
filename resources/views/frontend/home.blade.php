@extends('frontend.layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">{{ settings('site.name', 'Victory Business Consulting') }}</h1>
            <p class="text-xl mb-8 text-blue-100">{{ settings('site.tagline', 'Empowering businesses to achieve sustainable growth and operational excellence') }}</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('services.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                    Our Services
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Services</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Comprehensive business solutions tailored to your unique challenges
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 block">
                @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                @endif
                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $service->title }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-3">{{ $service->description }}</p>
                <span class="text-blue-600 font-semibold hover:text-blue-700">
                    Learn More →
                </span>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('services.index') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                View All Services
            </a>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Experienced professionals dedicated to your success
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($team as $member)
            <div class="text-center">
                @if($member->photo)
                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                @else
                <div class="w-32 h-32 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center">
                    <span class="text-4xl text-gray-400">{{ substr($member->name, 0, 1) }}</span>
                </div>
                @endif
                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $member->name }}</h3>
                <p class="text-blue-600 font-semibold mb-2">{{ $member->role }}</p>
                @if($member->linkedin)
                <a href="{{ $member->linkedin }}" target="_blank" class="text-gray-600 hover:text-blue-600 transition">
                    <svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                    </svg>
                </a>
                @endif
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('team') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                View Full Team
            </a>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Latest Insights</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Expert perspectives on business strategy and growth
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden block">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    @if($post->category)
                    <span class="text-sm text-blue-600 font-semibold">{{ $post->category }}</span>
                    @endif
                    <h3 class="text-xl font-bold text-gray-900 mb-2 mt-2">{{ $post->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                        @if($post->author)
                        <span class="mx-2">•</span>
                        <span>{{ $post->author }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Read More Articles
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4">Ready to Transform Your Business?</h2>
        <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
            Let's discuss how we can help you achieve your business goals
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
            Contact Us Today
        </a>
    </div>
</section>
@endsection
