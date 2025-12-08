@extends('frontend.layouts.app')

@section('title', 'About Us - ' . settings('site.name'))

@section('content')
<!-- Page Header -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">{{ settings('about.header_title', 'About Us') }}</h1>
            <p class="text-xl text-black/70">
                {{ settings('about.header_description', 'Learn more about our mission, vision, and values that drive us to deliver excellence.') }}
            </p>
        </div>
    </div>
</section>

<!-- Founder's Wisdom Section - Two Columns -->
<section class="pt-4 pb-16 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Left Column - Wisdom 1 -->
            <div class="relative overflow-hidden group max-w-xl justify-self-end">
                <div class="relative z-10 p-12 h-full flex flex-col items-center justify-center text-center">
                    <!-- Icon/Image -->
                    @if(settings('about.wisdom1_image'))
                        <img src="{{ asset('storage/' . settings('about.wisdom1_image')) }}" 
                             alt="{{ settings('about.wisdom1_title', 'Melayani Sepenuh Hati') }}" 
                             class="w-32 h-32 mb-6 object-contain opacity-80">
                    @endif
                    <h3 class="text-2xl font-bold mb-4">{{ settings('about.wisdom1_title', 'Melayani Sepenuh Hati') }}</h3>
                    <p class="text-lg leading-relaxed">
                        {{ settings('about.wisdom1_description', 'Klien dari Seluruh Indonesia') }}
                    </p>
                </div>
            </div>

            <!-- Right Column - Wisdom 2 -->
            <div class="relative overflow-hidden group max-w-xl justify-self-start">
                <div class="relative z-10 p-12 h-full flex flex-col items-center justify-center text-center">
                    <!-- Icon/Image -->
                    @if(settings('about.wisdom2_image'))
                        <img src="{{ asset('storage/' . settings('about.wisdom2_image')) }}" 
                             alt="{{ settings('about.wisdom2_title', 'Membantu Bisnis Tumbuh') }}" 
                             class="w-32 h-32 mb-6 object-contain opacity-80">
                    @endif
                    <h3 class="text-2xl font-bold mb-4">{{ settings('about.wisdom2_title', 'Membantu Bisnis Tumbuh') }}</h3>
                    <p class="text-lg leading-relaxed">
                        {{ settings('about.wisdom2_description', 'dan UMKM Berkembang') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Description Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-5xl text-center">
        @if(settings('about.content'))
        <div class="p-12">
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e(settings('about.content'))) !!}
            </div>
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-2xl shadow-md">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Coming Soon</h3>
            <p class="text-gray-600">We're working on this content. Check back soon!</p>
        </div>
        @endif
    </div>
</section>

<!-- Why Choose Us Section -->
@if($whyChooseItems->isNotEmpty())
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Us</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We combine expertise, dedication, and innovation to deliver exceptional results for your business.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($whyChooseItems as $item)
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-xl transition-shadow duration-300 border-2 border-transparent hover:border-[#0481AE] flex items-center justify-center flex-col text-center">
                @if($item->icon)
                <div class="text-5xl mb-4">{{ $item->icon }}</div>
                @else
                <div class="w-16 h-16 bg-gradient-to-br from-[#0481AE] to-[#035f7f] rounded-full flex items-center justify-center mb-8">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                @endif
                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $item->title }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $item->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Vision and Mission Section -->
@if(settings('about.vision_content') || settings('about.mission_content'))
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid md:grid-cols-2 gap-16">
            <!-- Vision -->
            @if(settings('about.vision_content'))
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">{{ settings('about.vision_title', 'Our Vision') }}</h2>
                        <div class="w-12 h-12 bg-gradient-to-br from-[#0481AE] to-[#035f7f] rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="prose prose-lg max-w-none text-gray-700 mb-6">
                        {!! nl2br(e(settings('about.vision_content'))) !!}
                    </div>
                </div>
                @if(settings('about.vision_image'))
                <div class="relative h-64">
                    <img src="{{ asset('storage/' . settings('about.vision_image')) }}" 
                         alt="{{ settings('about.vision_title', 'Our Vision') }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>
                @else
                <div class="relative h-64 bg-gradient-to-br from-[#0481AE] to-[#035f7f] flex items-center justify-center">
                    <svg class="w-32 h-32 text-white opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                @endif
            </div>
            @endif

            <!-- Mission -->
            @if(settings('about.mission_content'))
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">{{ settings('about.mission_title', 'Our Mission') }}</h2>
                        <div class="w-12 h-12 bg-gradient-to-br from-[#035f7f] to-[#0481AE] rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="prose prose-lg max-w-none text-gray-700 mb-6">
                        {!! nl2br(e(settings('about.mission_content'))) !!}
                    </div>
                </div>
                @if(settings('about.mission_image'))
                <div class="relative h-64">
                    <img src="{{ asset('storage/' . settings('about.mission_image')) }}" 
                         alt="{{ settings('about.mission_title', 'Our Mission') }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute bottom-0 right-0 w-full h-full bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>
                @else
                <div class="relative h-64 bg-gradient-to-br from-[#035f7f] to-[#0481AE] flex items-center justify-center">
                    <svg class="w-32 h-32 text-white opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Our Team Section -->
@if($teamMembers->isNotEmpty())
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Dedicated professionals committed to helping your business succeed
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-8">
            @foreach($teamMembers as $member)
            <div class="group w-64">
                <div class="relative overflow-hidden rounded-2xl shadow-lg mb-4 aspect-square">
                    @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" 
                         alt="{{ $member->name }}" 
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-[#0481AE] to-[#035f7f] flex items-center justify-center">
                        <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $member->name }}</h3>
                    <p class="text-[#0481AE] font-semibold mb-2">{{ $member->position }}</p>
                    @if($member->bio)
                    <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($member->bio, 100) }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('team') }}" 
               class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-[#0481AE] to-[#035f7f] text-white rounded-xl hover:shadow-lg transition transform hover:-translate-y-0.5 font-semibold">
                View Full Team
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="bg-[#FFE7D5] py-8 max-w-5xl mx-auto rounded-xl shadow-xl mb-16">
    <div class="container mx-auto px-4 max-w-4xl text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Transform Your Business?</h2>
        <p class="text-xl mb-10 opacity-90">
            Join hundreds of satisfied clients who have experienced growth and success with our consulting services.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="inline-block bg-[#0481AE] text-white px-16 py-2 rounded-xl font-semibold hover:bg-[#036494] transition shadow-md">
                Get in Touch
            </a>
            <a href="{{ route('contact') }}" class="inline-block text-[#0481AE] px-16 py-2 rounded-xl font-semibold border-2 border-[#0481AE] transition shadow-md">
                Explore Services
            </a>
        </div>
    </div>
</section>
@endsection
