@extends('frontend.layouts.app')

@section('title', t('frontend.services.meta_title', 'Our Services') . ' - ' . settings('site.name'))

@section('content')
<!-- Page Header -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center" data-animate="fade-up">
            <h1 class="text-5xl font-bold mb-4">{{ t('frontend.services.heading', 'Our Services') }}</h1>
            <p class="text-xl text-black/70">
                {{ t('frontend.services.subheading', 'Comprehensive business solutions designed to drive growth and operational excellence') }}
            </p>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($services->isEmpty())
        <div class="text-center py-12">
            <p class="text-xl text-gray-600">{{ t('frontend.services.empty', 'No services available at the moment.') }}</p>
        </div>
        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-16" data-animate-stagger="120">
            @foreach($services as $service)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden border-[#0481AE] border-2" data-animate="fade-up">
                @if($service->featured_image)
                <img src="{{ asset('storage/' . $service->featured_image) }}" alt="{{ $service->title }}" class="w-full h-56 object-cover">
                @else
                <div class="w-full h-56 bg-gradient-to-br from-[#0481AE] to-[#036494] flex items-center justify-center">
                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-[#0481AE] mb-3">{{ $service->title }}</h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $service->summary }}</p>
                    
                    @if($service->highlights->isNotEmpty())
                    <div class="mb-4">
                        <ul class="space-y-2">
                            @foreach($service->highlights->take(3) as $highlight)
                            <li class="flex items-start text-sm text-gray-700">
                                <svg class="w-5 h-5 text-[#0481AE] mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $highlight->label }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <a href="{{ route('services.show', $service->slug) }}" class="inline-block bg-[#0481AE] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#036494] transition">
                        {{ t('frontend.common.learn_more', 'Learn More') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-br from-[#0481AE] to-[#035f7f] text-white py-12 md:py-24">
    <div class="container mx-auto px-4 text-center max-w-4xl">
        <div data-animate="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 md:mb-6">{{ settings('services.cta_heading', t('frontend.services.cta_heading', 'We can tailor our services to meet your specific business needs')) }}</h2>
            <p class="text-base md:text-xl mb-6 md:mb-8 max-w-2xl mx-auto text-blue-50">
                {{ settings('services.cta_description', t('frontend.services.cta_description', 'Contact us today for a free consultation and discover how we can help your business thrive.')) }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center w-full sm:w-auto bg-white text-[#0481AE] px-8 md:px-12 py-3 md:py-4 rounded-xl font-semibold hover:bg-gray-100 transition shadow-lg text-base md:text-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ settings('services.cta_button', t('frontend.services.cta_button', 'Book Now')) }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
