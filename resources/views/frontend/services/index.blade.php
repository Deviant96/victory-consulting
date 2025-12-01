@extends('frontend.layouts.app')

@section('title', 'Our Services - ' . settings('site.name'))

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-4">Our Services</h1>
            <p class="text-xl text-blue-100">
                Comprehensive business solutions designed to drive growth and operational excellence
            </p>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($services->isEmpty())
        <div class="text-center py-12">
            <p class="text-xl text-gray-600">No services available at the moment.</p>
        </div>
        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-56 object-cover">
                @else
                <div class="w-full h-56 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $service->title }}</h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $service->description }}</p>
                    
                    @if($service->highlights->isNotEmpty())
                    <div class="mb-4">
                        <ul class="space-y-2">
                            @foreach($service->highlights->take(3) as $highlight)
                            <li class="flex items-start text-sm text-gray-700">
                                <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $highlight->text }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <a href="{{ route('services.show', $service->slug) }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Learn More
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
<section class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Need a Custom Solution?</h2>
        <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
            We can tailor our services to meet your specific business needs
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
            Get in Touch
        </a>
    </div>
</section>
@endsection
