<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::published()->paginate(12);
        return view('frontend.services.index', compact('services'));
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)->where('published', true)->firstOrFail();
        $relatedServices = Service::published()
            ->where('id', '!=', $service->id)
            ->take(3)
            ->get();
            
        return view('frontend.services.show', compact('service', 'relatedServices'));
    }
}
