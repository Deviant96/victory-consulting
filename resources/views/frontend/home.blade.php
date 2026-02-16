@extends('frontend.layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[560px] md:min-h-[720px] flex items-center justify-center text-white overflow-hidden">
    @if(settings('hero.background_image'))
    <div class="absolute inset-0 z-0 floating-soft">
        <img src="{{ asset('storage/' . settings('hero.background_image')) }}" alt="{{ t('frontend.home.hero_bg_alt', 'Hero background') }}" class="w-full h-full object-cover">
    </div>
    @endif
    <!-- Overlay and design accents -->
    <div class="absolute inset-0 z-[1] bg-gradient-to-br from-[#01131c]/70 via-[#035f7f]/60 to-[#0481AE]/70"></div>
    <div aria-hidden="true" class="absolute inset-0 z-[1]">
        <div class="absolute -top-20 -left-24 w-72 h-72 md:w-[22rem] md:h-[22rem] bg-[#cce7f0]/40 rounded-full blur-[80px] animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-72 h-72 md:w-[22rem] md:h-[22rem] bg-[#ffffff]/20 rounded-full blur-[80px] animate-pulse"></div>
    </div>

    <div class="container mx-auto px-4 max-w-7xl relative z-10 py-12 md:py-24" data-animate="fade-up">
        <div class="max-w-5xl mx-auto text-center md:text-{{ settings('hero.text_alignment', 'center') }}">
            <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-4 md:mb-6 leading-tight">
                <span class="bg-clip-text text-transparent bg-gradient-to-br from-white to-[#cce7f0]">{{ settings('site.name', 'Victory Business Consulting') }}</span>
            </h1>
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6 md:mb-10 text-[#eaf6fb] px-2">
                {{ settings('site.tagline', 'Empowering businesses to achieve sustainable growth and operational excellence') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center items-center pt-2">
                <a href="{{ route('contact') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-[#035f7f] px-8 md:px-10 lg:px-12 py-3 md:py-3.5 rounded-xl font-semibold shadow-xl hover:bg-[#cce7f0] hover:shadow-2xl transition">
                    {{ t('frontend.home.hero_primary_cta', 'Start Your Journey') }}
                    <span aria-hidden="true">→</span>
                </a>
                <a href="{{ route('services.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border-2 border-white/70 text-white px-8 md:px-10 lg:px-12 py-3 md:py-3.5 rounded-xl font-semibold backdrop-blur hover:bg-white/10 transition">
                    {{ t('frontend.home.hero_secondary_cta', 'Explore Services') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="relative py-12 md:py-24 bg-gradient-to-b from-[#f4fbff] via-white to-[#f7fbff] overflow-hidden">
    <div class="absolute -left-32 -top-16 h-64 w-64 bg-[#0481AE]/10 rounded-full blur-3xl"></div>
    <div class="absolute -right-24 top-10 h-48 w-48 bg-[#0fb5d2]/10 rounded-full blur-3xl"></div>

    <div class="relative container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 md:gap-8 mb-8 md:mb-12" data-animate="fade-up">
            <div>
                <div class="inline-flex items-center gap-2 bg-[#0481AE]/10 text-[#035f7f] px-4 py-2 rounded-full text-xs md:text-sm font-semibold uppercase tracking-[0.08em]">
                    <span class="h-2 w-2 rounded-full bg-[#0481AE]"></span>
                    {{ t('frontend.home.services_badge', 'What we deliver') }}
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mt-3">{{ settings('home.services_title', t('frontend.home.services_heading', 'Our Services')) }}</h2>
                <p class="text-base md:text-lg text-gray-600 max-w-3xl mt-2">{{ settings('home.services_description', t('frontend.home.services_subheading', 'Comprehensive business solutions tailored to your unique challenges')) }}</p>
            </div>
            <div class="flex gap-3 md:gap-4 flex-wrap">
                <span class="inline-flex items-center gap-2 bg-white border border-[#0481AE]/30 text-[#035f7f] px-3 py-2 rounded-lg text-xs md:text-sm shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    {{ t('frontend.home.services_pill_one', 'Outcome-first roadmaps') }}
                </span>
                <span class="inline-flex items-center gap-2 bg-white border border-[#0481AE]/30 text-[#035f7f] px-3 py-2 rounded-lg text-xs md:text-sm shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                    {{ t('frontend.home.services_pill_two', 'Cross-functional delivery') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-7" data-animate-stagger="120">
            @foreach($services as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="group relative bg-white rounded-2xl border border-[#0481AE]/15 shadow-sm hover:shadow-xl transition-all overflow-hidden" data-animate="fade-up">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition bg-gradient-to-br from-[#0481AE]/5 via-transparent to-[#0fb5d2]/10"></div>
                @if($service->image)
                <div class="h-40 md:h-44 overflow-hidden">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                </div>
                @endif
                <div class="p-5 md:p-6 relative z-10 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center gap-2 text-[11px] md:text-xs font-semibold text-[#035f7f] bg-[#0481AE]/10 px-3 py-1 rounded-full">
                            {{ t('frontend.home.services_tag', 'Core offering') }}
                        </span>
                        <span class="text-[11px] md:text-xs text-gray-500">{{ t('frontend.home.services_read_time', '2 min read') }}</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 leading-snug mb-2">{{ $service->title }}</h3>
                    <p class="text-sm md:text-base text-gray-600 line-clamp-3 flex-1">{{ $service->summary }}</p>
                    <span class="mt-4 inline-flex items-center gap-2 text-[#0481AE] font-semibold group-hover:translate-x-1 transition">
                        {{ t('frontend.common.learn_more', 'Learn More') }}
                        <span aria-hidden="true">→</span>
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        <div class="flex justify-center mt-10">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 bg-[#0481AE] text-white px-6 md:px-8 py-3 rounded-xl font-semibold shadow-lg hover:bg-[#035f7f] transition">
                {{ t('frontend.home.services_cta', 'Explore all services') }}
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
@if($whyChooseItems->isNotEmpty())
<section class="relative py-14 md:py-24 bg-white overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-[#f7fbff] via-white to-[#f0f7fb]"></div>
    <div class="absolute -left-24 top-10 h-72 w-72 bg-[#0481AE]/10 rounded-full blur-3xl"></div>
    <div class="absolute right-0 bottom-0 h-56 w-56 bg-[#0fb5d2]/10 rounded-full blur-3xl"></div>

    <div class="relative container mx-auto px-4 max-w-6xl">
        <div class="grid md:grid-cols-12 gap-10 md:gap-14 items-start">
            <div class="md:col-span-5 space-y-4" data-animate="fade-right">
                <div class="inline-flex items-center gap-2 bg-[#0481AE]/10 text-[#035f7f] px-4 py-2 rounded-full text-xs md:text-sm font-semibold uppercase tracking-[0.08em]">
                    <span class="h-2 w-2 rounded-full bg-[#0481AE]"></span>
                    {{ t('frontend.home.why_badge', 'Why partner with us') }}
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#035f7f] leading-tight">{{ settings('home.why_choose_title', t('frontend.home.why_choose_heading', 'Why Choose ' . settings('site.name', 'Victory Business Consulting'))) }}</h2>
                <p class="text-base md:text-lg text-gray-700">{{ settings('home.why_choose_description', t('frontend.home.why_choose_subheading', 'Discover what sets us apart and makes us the ideal partner for your business growth')) }}</p>
            </div>

            <div class="md:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5 md:gap-6" data-animate-stagger="120">
                @foreach($whyChooseItems as $item)
                <div class="group relative bg-white border border-[#0481AE]/15 rounded-2xl p-5 md:p-6 shadow-sm hover:shadow-2xl transition-all">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition bg-gradient-to-br from-[#0481AE]/5 via-transparent to-[#0fb5d2]/10"></div>
                    <div class="relative z-10">
                        <div class="flex items-start gap-3 md:gap-4 mb-3">
                            @if($item->icon)
                            <div class="flex-shrink-0 w-11 h-11 md:w-12 md:h-12 rounded-xl bg-gradient-to-br from-[#0481AE] to-[#035f7f] text-white flex items-center justify-center text-lg">
                                <i class="{{ $item->icon }}"></i>
                            </div>
                            @else
                            <div class="flex-shrink-0 w-11 h-11 md:w-12 md:h-12 rounded-xl bg-[#0481AE]/15 text-[#035f7f] flex items-center justify-center text-lg font-bold">•</div>
                            @endif
                            <div>
                                <h3 class="text-lg md:text-xl font-bold text-[#035f7f] leading-tight">{{ $item->title }}</h3>
                                <p class="text-sm md:text-base text-gray-700 mt-2">{{ $item->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Business Solutions Section -->
@if($businessSolutions->isNotEmpty())
<section class="relative py-14 md:py-24 bg-[#0b1f2a] text-white overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-[#0b1f2a] via-[#0c2d3c] to-[#035f7f]"></div>
    <div class="absolute -left-24 top-0 h-72 w-72 bg-white/5 rounded-full blur-3xl"></div>
    <div class="absolute right-[-6rem] bottom-[-4rem] h-80 w-80 bg-[#0fb5d2]/15 rounded-full blur-3xl"></div>

    <div class="relative container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 md:gap-10 mb-10 md:mb-14" data-animate="fade-up">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 text-white px-4 py-2 rounded-full text-xs md:text-sm font-semibold uppercase tracking-[0.08em]">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    {{ t('frontend.home.solutions_badge', 'Industries and use cases') }}
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold leading-tight mt-3">{{ settings('home.business_solutions_title', t('frontend.home.solutions_heading', 'Whatever Your Business, We Can Handle It')) }}</h2>
                <p class="text-base md:text-lg text-white/80 max-w-3xl mt-2">{{ settings('home.business_solutions_description', t('frontend.home.solutions_subheading', 'From startups to enterprises, we provide tailored solutions for every industry and challenge')) }}</p>
            </div>
            <div class="flex flex-wrap flex-none">
                <a href="{{ route('contact') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-[#035f7f] px-8 md:px-10 lg:px-12 py-3 md:py-3.5 rounded-xl font-semibold shadow-xl hover:bg-[#cce7f0] hover:shadow-2xl transition">
                    {{ t('frontend.home.business_solutions_cta', 'Explore Industries') }}
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6" data-animate-stagger="120">
            @foreach($businessSolutions as $solution)
            <div class="group relative bg-white/5 border border-white/10 rounded-2xl p-5 md:p-6 backdrop-blur shadow-lg hover:shadow-2xl transition-all" data-animate="fade-up">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition bg-white/5"></div>
                <div class="relative z-10 flex flex-col h-full text-white">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center gap-2 text-[11px] md:text-xs font-semibold bg-white/10 px-3 py-1 rounded-full">{{ t('frontend.home.solutions_tag', 'Solution area') }}</span>
                        <span class="text-[11px] md:text-xs text-white/70">{{ t('frontend.home.solutions_time', 'Fast start') }}</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold leading-snug mb-2">{{ $solution->title }}</h3>
                    @if($solution->description)
                    <p class="text-sm md:text-base text-white/80 flex-1">{{ $solution->description }}</p>
                    @endif
                    {{-- <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white group-hover:translate-x-1 transition">
                        {{ t('frontend.home.solutions_cta', 'Plan with us') }}
                        <span aria-hidden="true">→</span>
                    </span> --}}
                </div>
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
<section class="relative py-14 md:py-20 bg-gradient-to-b from-[#fff8f1] via-white to-[#f7efe9] overflow-hidden">
    <div class="absolute -left-24 top-6 h-64 w-64 bg-[#f3c7a0]/30 rounded-full blur-3xl"></div>
    <div class="absolute right-[-3rem] bottom-0 h-72 w-72 bg-[#0481AE]/15 rounded-full blur-3xl"></div>

    <div class="relative container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-8 mb-8 md:mb-12" data-animate="fade-up">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 bg-[#0481AE]/10 text-[#035f7f] px-4 py-2 rounded-full text-xs md:text-sm font-semibold uppercase tracking-[0.08em]">
                    <span class="h-2 w-2 rounded-full bg-[#f59e0b]"></span>
                    {{ t('frontend.home.blog_badge', 'Insights & playbooks') }}
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900">{{ settings('home.blog_title', t('frontend.home.blog_heading', 'Latest Insights')) }}</h2>
                <p class="text-base md:text-lg text-gray-700 max-w-3xl">{{ settings('home.blog_description', t('frontend.home.blog_subheading', 'Expert perspectives on business strategy and growth.')) }}</p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 bg-[#0481AE] text-white px-5 py-3 rounded-xl font-semibold shadow-lg hover:bg-[#035f7f] transition">
                    {{ settings('home.blog_button_text', t('frontend.home.blog_cta', 'Read More')) }}
                    <span aria-hidden="true">→</span>
                </a>
                <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-[#035f7f] border border-[#0481AE]/30 bg-white px-5 py-3 rounded-xl font-semibold hover:border-[#035f7f] transition">
                    {{ t('frontend.home.blog_secondary', 'See how we implement') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-7" data-animate-stagger="140">
            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="group bg-white rounded-lg shadow-md hover:shadow-2xl transition overflow-hidden flex flex-row md:flex md:flex-col h-full relative border-l-4 md:border-l-0 md:border-t-4 border-[#0481AE]" data-animate="fade-up">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-20 h-full sm:w-24 sm:h-24 md:w-full md:h-40 object-cover md:rounded-t-lg mr-0 md:mr-0 flex-shrink-0 group-hover:md:h-24 transition-all duration-300">
                @endif
                <div class="p-3 md:p-5 lg:p-6 flex-1 min-w-0 flex flex-col justify-between md:relative">
                    <div>
                        <div class="flex items-center gap-2 mb-2 flex-wrap justify-between">
                            @if($post->category)
                            <span class="text-xs md:text-sm text-black md:text-[#0481AE] md:font-semibold bg-blue-50 md:bg-transparent px-2 py-1 md:px-0 md:py-0 rounded">
                                <i class="fas fa-tag mr-1"></i>{{ $post->category }}
                            </span>
                            @endif
                            <div class="hidden md:flex items-center text-xs md:text-xs text-gray-500 gap-2">
                                @php($publishedDate = $post->published_at ?? $post->created_at)
                                <span><i class="far fa-calendar mr-1"></i>{{ $publishedDate->format('M d, Y') }}</span>
                                @if($post->author)
                                <span>•</span>
                                <span><i class="far fa-user mr-1"></i>{{ $post->author }}</span>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-sm sm:text-base md:text-lg font-semibold md:font-bold text-gray-900 mb-0 md:mb-3 line-clamp-2 md:line-clamp-none group-hover:md:line-clamp-2 transition-all group-hover:text-[#0481AE]">{{ $post->title }}</h3>
                    </div>
                    
                    <!-- Excerpt - Hidden on desktop, shows on hover with smooth transition -->
                    <div class="hidden md:block invisible opacity-0 group-hover:md:visible group-hover:md:opacity-100 md:absolute md:left-0 md:right-0 md:bottom-0 md:bg-gradient-to-t md:from-white md:to-white/95 md:p-5 md:pt-6 md:max-h-32 md:overflow-hidden transition-all duration-500">
                        <p class="text-gray-600 text-sm line-clamp-3 md:line-clamp-4">{{ $post->excerpt }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Section -->
@if($faqs->isNotEmpty())
<section class="py-12 md:py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-8 md:mb-12" data-animate="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 md:mb-4">Common Questions About Our Services</h2>
            <p class="text-base md:text-lg text-gray-600">Quick answers to help you make an informed decision</p>
        </div>
        
        <div class="space-y-4" data-animate-stagger="100">
            @foreach($faqs as $faq)
            <div class="bg-white rounded-lg shadow-md p-5 md:p-6" data-animate="fade-up">
                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 flex items-start">
                    <i class="fas fa-question-circle text-[#0481AE] mr-3 mt-1"></i>
                    {{ $faq->question }}
                </h3>
                <p class="text-sm md:text-base text-gray-700 ml-8 md:ml-9">{{ $faq->answer }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="bg-gradient-to-br from-[#0481AE] to-[#035f7f] text-white py-12 md:py-16">
    <div class="container mx-auto px-4 text-center max-w-4xl">
        <div data-animate="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 md:mb-6">Ready to Optimize Your Finances?</h2>
            <p class="text-base md:text-xl mb-6 md:mb-8 max-w-2xl mx-auto text-blue-50">
                Schedule your free 30-minute consultation today. No obligation—just expert guidance tailored to your situation.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('contact') }}" class="w-full sm:w-auto inline-block bg-white text-[#0481AE] px-8 md:px-12 py-3 md:py-4 rounded-xl font-semibold hover:bg-gray-100 transition shadow-lg text-base md:text-lg">
                    <i class="far fa-calendar-check mr-2"></i>Book Free Consultation
                </a>
                <a href="tel:+1234567890" class="w-full sm:w-auto inline-block border-2 border-white text-white px-8 md:px-12 py-3 md:py-4 rounded-xl font-semibold hover:bg-white/10 transition text-base md:text-lg">
                    <i class="fas fa-phone mr-2"></i>Call Us Now
                </a>
            </div>
            <p class="text-xs md:text-sm text-blue-100 mt-4 md:mt-6">✓ Free assessment  ✓ No credit card required  ✓ Same-day response guarantee</p>
        </div>
    </div>
</section>
@endsection
