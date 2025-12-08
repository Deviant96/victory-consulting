@extends('frontend.layouts.app')

@section('title', t('frontend.industry.meta_title', 'Industries We Serve') . ' - ' . settings('site.name'))

@section('content')
<!-- Page Header -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">{{ t('frontend.industry.heading', 'Industries We Serve') }}</h1>
            <p class="text-xl opacity-90">
                {{ t('frontend.industry.subheading', "Whatever your business, we can handle it. Comprehensive solutions tailored to your industry's unique challenges and opportunities.") }}
            </p>
        </div>
    </div>
</section>

<!-- Full-Width Hero Image -->
@if(settings('hero.industry_image'))
<section class="w-full">
    <img src="{{ asset('storage/' . settings('hero.industry_image')) }}" 
         alt="{{ t('frontend.industry.hero_alt', 'Industries We Serve') }}"
         class="w-full h-64 md:h-80 lg:h-96 object-cover">
</section>
@endif

<!-- Industries Grid -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">
        @if($industries->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-md">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ t('frontend.industry.empty_heading', 'No Industries Available') }}</h3>
            <p class="text-gray-600">{{ t('frontend.industry.empty_description', 'Check back soon for our industry solutions.') }}</p>
        </div>
        @else
        <!-- Intro Section -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ t('frontend.industry.expertise_heading', 'Expertise Across Industries') }}</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                {{ t('frontend.industry.expertise_description', 'We bring deep domain knowledge and proven strategies to help businesses thrive in their respective markets. Our tailored approach ensures you get solutions that work for your specific industry.') }}
            </p>
        </div>

        <!-- Industries Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($industries as $industry)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-[#0481AE] overflow-hidden group">
                <!-- Card Header with Gradient -->
                <div class="bg-gradient-to-br from-[#0481AE] to-[#036494] p-6 text-white">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-center">{{ $industry->title }}</h3>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    @if($industry->description)
                    <p class="text-gray-700 leading-relaxed mb-4">
                        {{ $industry->description }}
                    </p>
                    @endif

                    <!-- Sub-Solutions Checklist -->
                    @if($industry->subSolutions->isNotEmpty())
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">{{ t('frontend.industry.specialized_areas', 'Specialized Areas:') }}</h4>
                        <ul class="space-y-2">
                            @foreach($industry->subSolutions as $subSolution)
                            <li class="flex items-start text-sm text-gray-700">
                                <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $subSolution->title }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        <div class="mt-20 text-center p-12 bg-[#FFE7D5] text-white py-8 max-w-5xl mx-auto rounded-xl shadow-xl mb-16">
            <h2 class="text-3xl font-bold text-[#0481AE] mb-4">{{ t('frontend.industry.cta_heading', "Don't See Your Industry?") }}</h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                {{ t('frontend.industry.cta_description', 'We work with businesses across all sectors. Contact us to discuss how we can help your specific industry.') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center bg-[#0481AE] text-white px-16 py-2 rounded-xl font-semibold hover:bg-[#036494] transition shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ t('frontend.about.cta_primary', 'Get in Touch') }}
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center bg-white text-[#0481AE] px-16 py-2 rounded-xl font-semibold hover:bg-gray-50 transition border-2 border-[#0481AE] transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ t('frontend.industry.view_services', 'View Our Services') }}
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Features Section -->
{{-- <section class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Us</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                We combine industry expertise with innovative solutions to deliver exceptional results
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                <div class="w-16 h-16 bg-[#0481AE] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Industry Expertise</h3>
                <p class="text-gray-600">Deep understanding of sector-specific challenges and opportunities</p>
            </div>

            <div class="text-center p-8 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                <div class="w-16 h-16 bg-[#0481AE] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Rapid Implementation</h3>
                <p class="text-gray-600">Quick deployment of solutions that deliver immediate value</p>
            </div>

            <div class="text-center p-8 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                <div class="w-16 h-16 bg-[#0481AE] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Dedicated Support</h3>
                <p class="text-gray-600">Ongoing partnership with expert consultants who care about your success</p>
            </div>
        </div>
    </div>
</section> --}}
@endsection
