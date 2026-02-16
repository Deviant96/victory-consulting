@extends('frontend.layouts.app')

@section('title', t('frontend.about.meta_title', 'About Us') . ' - ' . settings('site.name'))

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-slate-950 text-white">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(4,129,174,0.35),transparent_55%)]"></div>
    <div class="absolute inset-0 bg-[linear-gradient(120deg,rgba(2,6,23,0.96),rgba(15,23,42,0.88))]"></div>
    <div class="container relative z-10 mx-auto px-4 py-16 md:py-24 max-w-7xl">
        <div class="grid lg:grid-cols-12 gap-10 items-center" data-animate-stagger="120">
            <div class="lg:col-span-7" data-animate="fade-up">
                <span class="inline-flex items-center rounded-full border border-white/20 bg-white/5 px-4 py-1.5 text-xs md:text-sm font-medium tracking-wide uppercase">
                    {{ settings('about.hero_tagline', t('frontend.about.hero_tagline', 'Trusted Finance & Business Advisory')) }}
                </span>
                <h1 class="mt-5 text-4xl md:text-5xl xl:text-6xl font-bold leading-tight">
                    {{ settings('about.header_title', t('frontend.about.header_title', 'About Us')) }}
                </h1>
                <p class="mt-6 text-base md:text-xl text-slate-200 max-w-2xl leading-relaxed">
                    {{ settings('about.header_description', t('frontend.about.header_description', 'Learn more about our mission, vision, and values that drive us to deliver excellence.')) }}
                </p>

                <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                    <div class="rounded-2xl border border-white/15 bg-white/5 px-3 py-4">
                        <p class="text-2xl md:text-3xl font-bold">10+</p>
                        <p class="text-xs text-slate-300 mt-1">{{ t('frontend.about.metric_experience', 'Years Experience') }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/5 px-3 py-4">
                        <p class="text-2xl md:text-3xl font-bold">500+</p>
                        <p class="text-xs text-slate-300 mt-1">{{ t('frontend.about.metric_clients', 'Clients Assisted') }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/5 px-3 py-4">
                        <p class="text-2xl md:text-3xl font-bold">98%</p>
                        <p class="text-xs text-slate-300 mt-1">{{ t('frontend.about.metric_retention', 'Client Retention') }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/5 px-3 py-4">
                        <p class="text-2xl md:text-3xl font-bold">24/7</p>
                        <p class="text-xs text-slate-300 mt-1">{{ t('frontend.about.metric_support', 'Strategic Support') }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5" data-animate="fade-up" data-animate-delay="120">
                <div class="rounded-3xl border border-white/15 bg-white/10 backdrop-blur-md p-4 md:p-6 shadow-2xl">
                    @if(settings('about.hero_image'))
                        <img src="{{ asset('storage/' . settings('about.hero_image')) }}"
                             alt="{{ t('frontend.about.hero_alt', 'Executive consultation meeting') }}"
                             class="w-full h-[280px] md:h-[360px] object-cover rounded-2xl">
                    @else
                        <div class="w-full h-[280px] md:h-[360px] rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 border border-white/10 flex items-center justify-center text-center p-6">
                            <div>
                                <svg class="w-14 h-14 text-white/60 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M6 7V5a2 2 0 012-2h8a2 2 0 012 2v2m-1 4l-3 3-2-2-4 4m-5 4h18"></path>
                                </svg>
                                <p class="font-semibold text-white">{{ t('frontend.about.hero_placeholder_title', 'Recommended Hero Image') }}</p>
                                <p class="mt-2 text-sm text-slate-300 leading-relaxed">
                                    {{ t('frontend.about.hero_placeholder_desc', 'Use a high-quality photo of advisors discussing financial strategy with clients in a modern boardroom.') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Founder's Principles -->
<section class="py-12 md:py-16 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-10" data-animate="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900">{{ settings('about.principles_heading', t('frontend.about.principles_heading', "Founder's Principles")) }}</h2>
            <p class="mt-3 text-slate-600 max-w-2xl mx-auto">{{ settings('about.principles_subheading', t('frontend.about.principles_subheading', 'The values that shape our consulting quality and long-term client partnerships.')) }}</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 md:gap-8" data-animate-stagger="120">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 md:p-8" data-animate="fade-up">
                <div class="flex items-start gap-4">
                    @if(settings('about.wisdom1_image'))
                        <img src="{{ asset('storage/' . settings('about.wisdom1_image')) }}" alt="Wisdom 1" class="w-16 h-16 rounded-xl object-cover border border-slate-200 bg-white">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center">
                            <svg class="w-7 h-7 text-[#0481AE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-3 3-3-3z"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ settings('about.wisdom1_title', t('frontend.about.wisdom_service_title', 'Melayani Sepenuh Hati')) }}</h3>
                        <p class="mt-2 text-slate-600 leading-relaxed">{{ settings('about.wisdom1_description', t('frontend.about.wisdom_service_description', 'Klien dari Seluruh Indonesia')) }}</p>
                        <p class="mt-3 text-xs uppercase tracking-widest text-slate-400">{{ t('frontend.about.wisdom_service_caption', "Founder's Wisdom 1") }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 md:p-8" data-animate="fade-up" data-animate-delay="120">
                <div class="flex items-start gap-4">
                    @if(settings('about.wisdom2_image'))
                        <img src="{{ asset('storage/' . settings('about.wisdom2_image')) }}" alt="Wisdom 2" class="w-16 h-16 rounded-xl object-cover border border-slate-200 bg-white">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center">
                            <svg class="w-7 h-7 text-[#0481AE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ settings('about.wisdom2_title', t('frontend.about.wisdom_growth_title', 'Membantu Bisnis Tumbuh')) }}</h3>
                        <p class="mt-2 text-slate-600 leading-relaxed">{{ settings('about.wisdom2_description', t('frontend.about.wisdom_growth_description', 'dan UMKM Berkembang')) }}</p>
                        <p class="mt-3 text-xs uppercase tracking-widest text-slate-400">{{ t('frontend.about.wisdom_growth_caption', "Founder's Wisdom 2") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Narrative -->
<section class="py-12 md:py-16 bg-slate-50">
    <div class="container mx-auto px-4 max-w-6xl" data-animate="fade-up">
        <div class="grid lg:grid-cols-12 gap-8 items-stretch">
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 p-6 md:p-10 shadow-sm">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">{{ settings('about.story_heading', t('frontend.about.story_heading', 'Our Story')) }}</h2>
                @if(settings('about.content'))
                    <div class="mt-5 prose prose-lg max-w-none text-slate-700 leading-relaxed">
                        {!! nl2br(e(settings('about.content'))) !!}
                    </div>
                @else
                    <div class="mt-5 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6">
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">{{ t('frontend.about.coming_soon_heading', 'Coming Soon') }}</h3>
                        <p class="text-slate-600">{{ t('frontend.about.coming_soon_description', "We're working on this content. Check back soon!") }}</p>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-5 rounded-2xl border border-slate-200 bg-white p-4 md:p-5 shadow-sm">
                @if(settings('about.story_image'))
                    <img src="{{ asset('storage/' . settings('about.story_image')) }}"
                         alt="{{ t('frontend.about.story_alt', 'Consultants presenting business roadmap') }}"
                         class="w-full h-full min-h-[300px] object-cover rounded-xl">
                @else
                    <div class="w-full h-full min-h-[300px] rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-300 flex items-center justify-center text-center p-6">
                        <div>
                            <svg class="w-14 h-14 text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-6m3 6v-4m4 8H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="font-semibold text-slate-800">{{ t('frontend.about.story_placeholder_title', 'Recommended Story Image') }}</p>
                            <p class="mt-2 text-sm text-slate-600">{{ t('frontend.about.story_placeholder_desc', 'Use an authentic photo of your team reviewing reports, dashboards, or strategic planning documents.') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
@if($whyChooseItems->isNotEmpty())
<section class="py-14 md:py-20 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-12" data-animate="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900">{{ t('frontend.about.why_choose_heading', 'Why Choose Us') }}</h2>
            <p class="mt-3 text-slate-600 max-w-3xl mx-auto">{{ t('frontend.about.why_choose_description', 'We combine expertise, dedication, and innovation to deliver exceptional results for your business.') }}</p>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6" data-animate-stagger="120">
            @foreach($whyChooseItems as $item)
            <div class="group rounded-2xl border border-slate-200 bg-white p-7 hover:border-[#0481AE]/40 hover:shadow-xl transition-all duration-300" data-animate="fade-up">
                <div class="w-14 h-14 rounded-xl border border-[#0481AE]/20 bg-[#0481AE]/5 flex items-center justify-center mb-5">
                    @if($item->icon_is_image)
                        <img src="{{ $item->icon_url }}" alt="{{ $item->title }} icon" class="w-9 h-9 object-contain" />
                    @elseif($item->icon)
                        <i class="{{ $item->icon }} text-2xl text-[#0481AE]"></i>
                    @else
                        <svg class="w-7 h-7 text-[#0481AE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @endif
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $item->title }}</h3>
                <p class="text-slate-600 leading-relaxed">{{ $item->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Vision and Mission -->
@if(settings('about.vision_content') || settings('about.mission_content'))
<section class="py-14 md:py-20 bg-slate-50">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid md:grid-cols-2 gap-8" data-animate-stagger="120">
            @if(settings('about.vision_content'))
            <article class="rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm" data-animate="fade-up">
                <div class="p-7 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[#0481AE]/10 text-[#0481AE] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900">{{ settings('about.vision_title', t('frontend.about.vision_title', 'Our Vision')) }}</h2>
                    </div>
                    <div class="prose max-w-none text-slate-700">
                        {!! nl2br(e(settings('about.vision_content'))) !!}
                    </div>
                </div>
                @if(settings('about.vision_image'))
                <img src="{{ asset('storage/' . settings('about.vision_image')) }}"
                     alt="{{ settings('about.vision_title', t('frontend.about.vision_title', 'Our Vision')) }}"
                     class="w-full h-56 object-cover">
                @else
                <div class="h-56 bg-gradient-to-r from-slate-900 to-[#035f7f] text-white flex items-center justify-center text-center p-6">
                    <div>
                        <p class="font-semibold">{{ t('frontend.about.vision_placeholder_title', 'Recommended Vision Image') }}</p>
                        <p class="text-sm text-slate-200 mt-1">{{ t('frontend.about.vision_placeholder_desc', 'Use imagery that communicates long-term growth: skyline, upward chart, or strategic planning scene.') }}</p>
                    </div>
                </div>
                @endif
            </article>
            @endif

            @if(settings('about.mission_content'))
            <article class="rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm" data-animate="fade-up" data-animate-delay="120">
                <div class="p-7 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-[#0481AE]/10 text-[#0481AE] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900">{{ settings('about.mission_title', t('frontend.about.mission_title', 'Our Mission')) }}</h2>
                    </div>
                    <div class="prose max-w-none text-slate-700">
                        {!! nl2br(e(settings('about.mission_content'))) !!}
                    </div>
                </div>
                @if(settings('about.mission_image'))
                <img src="{{ asset('storage/' . settings('about.mission_image')) }}"
                     alt="{{ settings('about.mission_title', t('frontend.about.mission_title', 'Our Mission')) }}"
                     class="w-full h-56 object-cover">
                @else
                <div class="h-56 bg-gradient-to-r from-[#035f7f] to-slate-900 text-white flex items-center justify-center text-center p-6">
                    <div>
                        <p class="font-semibold">{{ t('frontend.about.mission_placeholder_title', 'Recommended Mission Image') }}</p>
                        <p class="text-sm text-slate-200 mt-1">{{ t('frontend.about.mission_placeholder_desc', 'Use a team execution image: consultants with clients, workshops, or on-site advisory moments.') }}</p>
                    </div>
                </div>
                @endif
            </article>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Leadership Team -->
@if($teamMembers->isNotEmpty())
<section class="py-14 md:py-20 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-12" data-animate="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900">{{ t('frontend.team.heading', 'Meet Our Team') }}</h2>
            <p class="mt-3 text-slate-600 max-w-3xl mx-auto">{{ t('frontend.team.subheading', 'Dedicated professionals committed to helping your business succeed') }}</p>
        </div>

        <div class="flex flex-wrap justify-center gap-6" data-animate-stagger="100">
            @foreach($teamMembers as $member)
            <article class="group w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] xl:w-[calc(25%-1.125rem)] max-w-sm rounded-2xl border border-slate-200 bg-white p-4 hover:shadow-xl transition-all duration-300" data-animate="fade-up">
                <div class="relative overflow-hidden rounded-xl mb-4 aspect-[4/5] bg-slate-100">
                    @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}"
                         alt="{{ $member->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-center p-4">
                        <svg class="w-12 h-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @endif
                </div>
                <h3 class="text-lg font-bold text-slate-900">{{ $member->name }}</h3>
                <p class="text-[#0481AE] font-semibold text-sm mt-1">{{ $member->position }}</p>
                @if($member->bio)
                <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ Str::limit($member->bio, 100) }}</p>
                @endif
            </article>
            @endforeach
        </div>

        <div class="text-center mt-10" data-animate="fade-up" data-animate-delay="120">
            <a href="{{ route('team') }}" class="inline-flex items-center gap-2 bg-[#0481AE] text-white px-6 md:px-8 py-3 rounded-xl font-semibold shadow-lg hover:bg-[#035f7f] transition">
                {{ t('frontend.home.services_cta', 'Explore all services') }}
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="bg-gradient-to-br from-[#0481AE] to-[#035f7f] text-white py-12 md:py-24">
    <div class="container mx-auto px-4 text-center max-w-4xl">
        <div data-animate="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 md:mb-6">{{ settings('about.cta_heading', t('frontend.about.cta_heading', 'Ready to Transform Your Business?')) }}</h2>
            <p class="text-base md:text-xl mb-6 md:mb-8 max-w-2xl mx-auto text-blue-50">
                {{ settings('about.cta_description', t('frontend.about.cta_description', 'Contact us today for a free consultation and discover how we can help your business thrive.')) }}
            </p>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center bg-white text-[#035f7f] px-8 md:px-11 py-3.5 rounded-xl font-semibold hover:bg-slate-100 transition shadow-lg text-base md:text-lg">
                {{ settings('about.cta_primary_button', t('frontend.about.cta_primary', 'Book Free Consultation')) }}
            </a>
        </div>
    </div>
</section>
@endsection
