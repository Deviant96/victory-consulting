@extends('frontend.layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[500px] md:min-h-[700px] flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/25 z-[2] bg-gradient-to-br from-[#0481ae00] to-[#03607f9f]"></div>
    @if(settings('hero.background_image'))
    <div class="absolute inset-0 z-0 floating-soft">  
        <img src="{{ asset('storage/' . settings('hero.background_image')) }}"   alt="Hero Background" class="w-full h-full object-cover">
    </div>
    @endif
    <div class="container mx-auto px-4 max-w-6xl relative z-10 py-12 md:py-24" data-animate="fade-up">
        <div class="max-w-4xl mx-auto text-center md:text-{{ settings('hero.text_alignment', 'center') }}">
            <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-bold mb-4 md:mb-6 leading-tight">{{ settings('site.name', 'Victory Business Consulting') }}</h1>
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 md:mb-10 text-[#cce7f0] px-2">{{ settings('site.tagline', 'Empowering businesses to achieve sustainable growth and operational excellence') }}</p>
            <div class="flex flex-col md:flex-row gap-3 md:gap-4 justify-center md:{{ settings('hero.text_alignment') === 'center' ? 'justify-center' : (settings('hero.text_alignment') === 'right' ? 'justify-end' : 'justify-start') }} px-4 md:px-0">
                <a href="{{ route('services.index') }}" class="w-full md:w-auto text-center bg-white text-[#0481AE] px-8 md:px-12 lg:px-16 py-3 rounded-xl font-semibold hover:bg-[#cce7f0] transition shadow-md">
                    {{ t('frontend.home.hero_primary_cta', 'Our Services') }}
                </a>
                <a href="{{ route('contact') }}" class="w-full md:w-auto text-center border-2 border-white text-white px-8 md:px-12 lg:px-16 py-3 rounded-xl font-semibold hover:bg-white hover:text-[#035f7f] transition shadow-md">
                    {{ t('frontend.home.hero_secondary_cta', 'Get Started') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-12 md:py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-8 md:mb-12" data-animate="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 md:mb-4">{{ settings('home.services_title', t('frontend.home.services_heading', 'Our Services')) }}</h2>
            <p class="text-base md:text-xl text-gray-600 max-w-2xl mx-auto px-2">
                {{ settings('home.services_description', t('frontend.home.services_subheading', 'Comprehensive business solutions tailored to your unique challenges')) }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-12" data-animate-stagger="120">
            @foreach($services as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-5 md:p-6 border-[#0481AE] border-2 flex flex-col" data-animate="fade-up">
                @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-40 md:h-48 object-cover rounded-lg mb-3 md:mb-4">
                @endif
                <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-2 md:mb-3 flex-1">{{ $service->title }}</h3>
                <div class="flex-grow flex flex-col justify-between">
                    <p class="text-sm md:text-base text-gray-600 mb-3 md:mb-4 line-clamp-3">{{ $service->summary }}</p>
                    <span class="text-[#0481AE] font-semibold hover:text-[#035f7f]">
                        {{ t('frontend.common.learn_more', 'Learn More') }} →
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        {{-- <div class="text-center mt-12">
            <a href="{{ route('services.index') }}" class="inline-block bg-[#0481AE] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#035f7f] transition">
                View All Services
            </a>
        </div> --}}
    </div>
</section>

<!-- Why Choose Us Section -->
@if($whyChooseItems->isNotEmpty())
<section class="relative pt-12 md:pt-20 pb-2 mb-20 md:mb-32 text-white overflow-x-clip" style="background: linear-gradient(to bottom, rgba(185, 206, 213, 0.72) 0%, rgba(185, 206, 213, 0.72) 15%, rgba(4, 129, 174, 1) 75%);">
    <div class="container mx-auto px-4 max-w-6xl relative z-10">
        <div class="text-center mb-8 md:mb-16" data-animate="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#035f7f] mb-3 md:mb-4 px-2">{{ settings('home.why_choose_title', t('frontend.home.why_choose_heading', 'Why Choose ' . settings('site.name', 'Victory Business Consulting'))) }}</h2>
            <p class="text-base md:text-lg lg:text-xl text-[#035f7f] max-w-3xl mx-auto px-4">
                {{ settings('home.why_choose_description', t('frontend.home.why_choose_subheading', 'Discover what sets us apart and makes us the ideal partner for your business growth')) }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 mb-8 md:mb-16" data-animate-stagger="120">
            @foreach($whyChooseItems as $item)
            <div class="bg-white/95 backdrop-blur rounded-xl md:rounded-2xl p-5 md:p-8 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2" data-animate="fade-up">
                <div class="flex items-start gap-3 md:gap-4 mb-3 md:mb-4">
                    @if($item->icon)
                    <div class="flex-shrink-0 w-10 h-10 md:w-14 md:h-14 bg-gradient-to-br from-[#0481AE] to-[#035f7f] rounded-lg md:rounded-xl flex items-center justify-center text-white text-lg md:text-2xl">
                        <i class="{{ $item->icon }}"></i>
                    </div>
                    @endif
                    <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-[#035f7f] leading-tight">{{ $item->title }}</h3>
                </div>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed">{{ $item->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Half-rounded separator at bottom -->
    <div class="absolute -bottom-8 md:-bottom-12 bg-[#0481AE] left-[-2.5%] right-0 h-12 md:h-32 z-[3] w-[105%]" style="border-radius: 0 0 50% 50% / 0 0 100% 100%;"></div>
    
    <!-- Half-rounded separator at bottom -->
    <div class="absolute -bottom-12 md:-bottom-18 bg-[#EAF1EF] left-[-5%] right-0 h-16 md:h-40 w-[110%] z-[2]" style="border-radius: 0 0 50% 50% / 0 0 100% 100%;"></div>
</section>
@endif

<!-- Business Solutions Section -->
@if($businessSolutions->isNotEmpty())
<section class="py-12 md:py-20 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-8 md:mb-16" data-animate="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-3 md:mb-4 px-2">{{ settings('home.business_solutions_title', t('frontend.home.solutions_heading', 'Whatever Your Business, We Can Handle It')) }}</h2>
            <p class="text-base md:text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto px-4">
                {{ settings('home.business_solutions_description', t('frontend.home.solutions_subheading', 'From startups to enterprises, we provide tailored solutions for every industry and challenge')) }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6" data-animate-stagger="120">
            @foreach($businessSolutions as $solution)
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl md:rounded-2xl p-5 md:p-8 shadow hover:shadow-xl transition-all transform hover:-translate-y-1 border-[#0481AE] border-2" data-animate="fade-up">
                <h3 class="text-base sm:text-lg md:text-xl font-bold text-[#0481AE] mb-2 md:mb-3 text-center">{{ $solution->title }}</h3>
                @if($solution->description)
                <p class="text-gray-600 text-center text-xs md:text-sm">{{ $solution->description }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Team Section -->
{{-- <section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
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
                <p class="text-[#0481AE] font-semibold mb-2">{{ $member->role }}</p>
                @if($member->linkedin)
                <a href="{{ $member->linkedin }}" target="_blank" class="text-gray-600 hover:text-[#0481AE] transition">
                    <svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                    </svg>
                </a>
                @endif
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('team') }}" class="inline-block bg-[#0481AE] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#035f7f] transition">
                View Full Team
            </a>
        </div>
    </div>
</section> --}}

<!-- Blog Section -->
<section class="py-12 md:py-16 lg:py-20 bg-[#FFE7D5] text-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-8" data-animate-stagger="140">
            <div class="mb-4 md:mb-8 flex flex-row justify-between items-center md:justify-normal md:flex-col md:items-start md:col-span-1 text-left md:text-center" data-animate="fade-right">
                <div class="flex-1">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-8 leading-tight md:leading-normal">{{ settings('home.blog_title', t('frontend.home.blog_heading', 'Latest Insights')) }}</h2>
                    <p class="text-sm md:text-base text-gray-600 max-w-2xl hidden md:block">{{ settings('home.blog_description', t('frontend.home.blog_subheading', 'Expert perspectives on business strategy and growth.')) }}</p>
                </div>
                <div class="text-center md:mt-12 flex-shrink-0">
                    <a href="{{ route('blog.index') }}" class="inline-block text-sm md:text-base md:bg-[#0481AE] text-black md:text-white underline md:no-underline p-0 md:px-8 md:py-3 md:rounded-lg md:font-semibold md:hover:bg-[#035f7f] transition whitespace-nowrap">
                        {{ settings('home.blog_button_text', t('frontend.home.blog_cta', 'Read More')) }}
                    </a>
                </div>
            </div>

            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden flex flex-row md:block p-3 md:p-0" data-animate="fade-up">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded md:rounded-none mr-3 md:mr-0 md:w-full md:h-48 flex-shrink-0">
                @endif
                <div class="p-0 md:py-6 md:px-4 lg:px-6 flex-1 min-w-0">
                    @if($post->category)
                    <span class="text-xs md:text-sm text-black md:text-[#0481AE] md:font-semibold block mb-1 md:mb-0">{{ $post->category }}</span>
                    @endif
                    <h3 class="text-sm sm:text-base md:text-xl font-semibold md:font-bold text-gray-900 md:mb-2 md:mt-2 line-clamp-2 md:line-clamp-none">{{ $post->title }}</h3>
                    <div class="hidden md:block"><p class="text-gray-600 mb-4 line-clamp-2">{{ $post->excerpt }}</p></div>
                    <div class="hidden md:flex items-center text-sm text-gray-500">
                        @php($publishedDate = $post->published_at ?? $post->created_at)
                        <span>{{ $publishedDate->format('M d, Y') }}</span>
                        @if($post->author)
                        <span class="mx-2">•</span>
                        <span>{{ $post->author }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
{{-- <section class="bg-[#FFE7D5] text-white py-8 max-w-5xl mx-auto rounded-xl shadow-xl mb-16">
    <div class="container mx-auto px-2 text-center">
        <h2 class="text-3xl font-bold mb-4 text-[#0481AE]">Ready to Transform Your Business?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto text-[#0481AE]">
            Let's discuss how we can help you achieve your business goals
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-[#0481AE] text-white px-16 py-2 rounded-xl font-semibold hover:bg-[#036494] transition shadow-md">
            Contact Us Today
        </a>
    </div>
</section> --}}
@endsection
