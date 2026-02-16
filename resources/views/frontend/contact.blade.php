@extends('frontend.layouts.app')

@section('title', t('frontend.contact.meta_title', 'Contact Us') . ' - ' . settings('site.name'))

@section('content')
<!-- Page Header -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center" data-animate="fade-up">
            <h1 class="text-5xl font-bold mb-4">{{ settings('contact.page_title', t('frontend.contact.heading', 'Contact Us')) }}</h1>
            <p class="text-xl text-black/70">
                {{ settings('contact.page_description', t('frontend.contact.subheading', 'Get in touch with our team to discuss how we can help your business thrive')) }}
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="pb-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12">

                <!-- Contact Information -->
                <div>
                    <div class="space-y-4 max-w-sm" data-animate-stagger="120">
                        <!-- Phone -->
                        @if(settings('site.phone'))
                        <div class="bg-white rounded-lg shadow-md p-4" data-animate="fade-up">
                            <div class="flex items-center mb-2">
                                <div class="bg-[#D6E9F8] rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-[#0481AE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">{{ t('frontend.contact.phone_label', 'Phone') }}</h3>
                            </div>
                            <a href="tel:{{ settings('site.phone') }}" class="text-base hover:text-[#0481AE] transition">
                                {{ settings('site.phone') }}
                            </a>
                            <p class="text-sm text-gray-500 mt-1">{{ t('frontend.contact.phone_note', 'Available on phone and WhatsApp') }}</p>
                        </div>
                        @endif

                        <!-- Email -->
                        @if(settings('site.email'))
                        <div class="bg-white rounded-lg shadow-md p-4" data-animate="fade-up">
                            <div class="flex items-center mb-2">
                                <div class="bg-[#D6E9F8] rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-[#0481AE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">{{ t('frontend.contact.email_label', 'Email') }}</h3>
                            </div>
                            <a href="mailto:{{ settings('site.email') }}" class="text-base hover:text-[#0481AE] transition">
                                {{ settings('site.email') }}
                            </a>
                            <p class="text-sm text-gray-500 mt-1">{{ t('frontend.contact.email_note', 'We answer emails promptly') }}</p>
                        </div>
                        @endif

                        <!-- Address -->
                        @if(settings('site.address'))
                        <div class="bg-white rounded-lg shadow-md p-4" data-animate="fade-up">
                            <div class="flex items-center mb-2">
                                <div class="bg-[#D6E9F8] rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-[#0481AE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">{{ t('frontend.contact.address_label', 'Address') }}</h3>
                            </div>
                            <p class="text-base text-gray-600">{!! nl2br(e(settings('site.address'))) !!}</p>
                        </div>
                        @endif

                        <!-- Business Hours -->
                        <div class="bg-white rounded-lg shadow-md p-4" data-animate="fade-up">
                            <div class="flex items-center mb-2">
                                <div class="bg-[#D6E9F8] rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-[#0481AE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">{{ t('frontend.contact.hours_label', 'Business Hours') }}</h3>
                            </div>
                            <div class="space-y-1 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>{{ t('frontend.contact.hours_weekday', 'Monday - Friday:') }}</span>
                                    <span class="font-semibold">{{ t('frontend.contact.hours_weekday_value', '9:00 AM - 6:00 PM') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>{{ t('frontend.contact.hours_saturday', 'Saturday:') }}</span>
                                    <span class="font-semibold">{{ t('frontend.contact.hours_saturday_value', '10:00 AM - 4:00 PM') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>{{ t('frontend.contact.hours_sunday', 'Sunday:') }}</span>
                                    <span class="font-semibold">{{ t('frontend.contact.hours_sunday_value', 'Closed') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links -->
                        @if(settings('social.linkedin') || settings('social.twitter') || settings('social.facebook'))
                        <div class="bg-white rounded-lg shadow-md p-4" data-animate="fade-up">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">{{ t('frontend.contact.follow_label', 'Follow Us') }}</h3>
                            <div class="flex gap-3">
                                @if(settings('social.linkedin'))
                                <a href="{{ settings('social.linkedin') }}" target="_blank" class="bg-[#D6E9F8] p-3 rounded-lg hover:bg-[#B0D4F1] transition">
                                    <svg class="w-6 h-6 text-[#0481AE]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                                @endif

                                @if(settings('social.twitter'))
                                <a href="{{ settings('social.twitter') }}" target="_blank" class="bg-[#D6E9F8] p-3 rounded-lg hover:bg-[#B0D4F1] transition">
                                    <svg class="w-6 h-6 text-[#0481AE]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </a>
                                @endif

                                @if(settings('social.facebook'))
                                <a href="{{ settings('social.facebook') }}" target="_blank" class="bg-[#D6E9F8] p-3 rounded-lg hover:bg-[#B0D4F1] transition">
                                    <svg class="w-6 h-6 text-[#0481AE]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                @endif

                                @if(settings('social.instagram'))
                                <a href="{{ settings('social.instagram') }}" target="_blank" class="bg-[#D6E9F8] p-3 rounded-lg hover:bg-[#B0D4F1] transition">
                                    <svg class="w-6 h-6 text-[#0481AE]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Booking Form Component -->
                @include('frontend.partials.booking-form')
            </div>
        </div>
    </div>
</section>
@endsection
