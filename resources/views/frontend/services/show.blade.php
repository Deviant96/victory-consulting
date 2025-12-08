@extends('frontend.layouts.app')

@section('title', $service->title . ' - ' . settings('site.name'))
@section('description', $service->description)

@section('content')
<!-- Breadcrumb -->
<section class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-blue-600">{{ t('frontend.navigation.home', 'Home') }}</a>
            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <a href="{{ route('services.index') }}" class="hover:text-blue-600">{{ t('frontend.navigation.services', 'Services') }}</a>
            <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-gray-900">{{ $service->title }}</span>
        </div>
    </div>
</section>

<!-- Service Detail -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-5xl font-bold text-gray-900 mb-6">{{ $service->title }}</h1>
                
                @if($service->featured_image)
                <img src="{{ asset('storage/' . $service->featured_image) }}" alt="{{ $service->title }}" class="w-full h-96 object-cover rounded-lg shadow-lg mb-6">
                @endif
                
                <p class="text-xl text-gray-700 leading-relaxed">{{ $service->description }}</p>
            </div>

            <!-- Highlights -->
            @if($service->highlights->isNotEmpty())
            <div class="bg-gray-50 rounded-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ t('frontend.services.show.highlights_heading', 'Key Features') }}</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($service->highlights as $highlight)
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-[#0481AE] mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">{{ $highlight->label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- CTA Box -->
            <div class="bg-[#FFE7D5] text-white rounded-xl p-8 text-center mt-24 shadow-xl">
                <h3 class="text-3xl text-[#0481AE] font-bold mb-4">{{ t('frontend.services.show.cta_heading', 'Interested in This Service?') }}</h3>
                <p class="text-[#0481AE] mb-6 text-lg">
                    {{ t('frontend.services.show.cta_description', 'Contact us today to discuss how we can help your business succeed') }}
                </p>
                <a href="{{ route('contact') }}" class="inline-block bg-[#0481AE] text-white px-16 py-2 rounded-xl font-semibold hover:bg-[#036494] transition shadow-md">
                    {{ t('frontend.services.cta_button', 'Book Now') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Related Services -->
@if($relatedServices->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">{{ t('frontend.services.show.related_heading', 'Related Services') }}</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($relatedServices as $related)
            <a href="{{ route('services.show', $related->slug) }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 block">
                @if($related->featured_image)
                <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                @endif
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $related->title }}</h3>
                <p class="text-gray-600 line-clamp-2 mb-3">{{ $related->description }}</p>
                <span class="text-[#0481AE] font-semibold hover:text-[#036494] transition">
                    {{ t('frontend.common.learn_more', 'Learn More') }} →
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
