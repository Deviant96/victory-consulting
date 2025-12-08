@extends('frontend.layouts.app')

@section('title', t('frontend.team.meta_title', 'Our Team') . ' - ' . settings('site.name'))

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-4">{{ t('frontend.team.heading', 'Our Team') }}</h1>
            <p class="text-xl text-blue-100">
                {{ t('frontend.team.subheading', 'Meet the experienced professionals dedicated to driving your business success') }}
            </p>
        </div>
    </div>
</section>

<!-- Team Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($teamMembers->isEmpty())
        <div class="text-center py-12">
            <p class="text-xl text-gray-600">{{ t('frontend.team.empty', 'Our team information will be available soon.') }}</p>
        </div>
        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($teamMembers as $member)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                <!-- Photo -->
                <div class="text-center mb-6">
                    @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-40 h-40 rounded-full mx-auto object-cover shadow-lg">
                    @else
                    <div class="w-40 h-40 rounded-full mx-auto bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <span class="text-5xl text-white font-bold">{{ substr($member->name, 0, 1) }}</span>
                    </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="text-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $member->name }}</h2>
                    <p class="text-blue-600 font-semibold text-lg">{{ $member->role }}</p>
                </div>

                <!-- Bio -->
                @if($member->bio)
                <p class="text-gray-600 text-center mb-4 leading-relaxed">{{ $member->bio }}</p>
                @endif

                <!-- Expertise -->
                @if($member->expertise && count($member->expertise) > 0)
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2 text-center">{{ t('frontend.team.expertise', 'Expertise') }}</h3>
                    <div class="flex flex-wrap gap-2 justify-center">
                        @foreach($member->expertise as $skill)
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $skill }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Social Links -->
                <div class="flex justify-center gap-4 pt-4 border-t border-gray-200">
                    @if($member->linkedin)
                    <a href="{{ $member->linkedin }}" target="_blank" class="text-gray-600 hover:text-blue-600 transition" title="LinkedIn">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    @endif

                    @if($member->email)
                    <a href="mailto:{{ $member->email }}" class="text-gray-600 hover:text-blue-600 transition" title="Email">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">{{ t('frontend.team.cta_heading', 'Work With Our Expert Team') }}</h2>
        <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
            {{ t('frontend.team.cta_subheading', 'Ready to leverage our expertise for your business growth?') }}
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
            {{ t('frontend.team.cta_button', 'Contact Us Today') }}
        </a>
    </div>
</section>
@endsection
