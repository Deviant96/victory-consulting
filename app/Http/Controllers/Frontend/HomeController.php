<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\BlogPost;
use App\Models\WhyChooseItem;
use App\Models\Faq;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::published()->take(6)->get();
        $team = TeamMember::take(4)->get();
        $posts = BlogPost::published()->latest()->take(3)->get();
        $whyChooseItems = WhyChooseItem::active()->ordered()->get();
        $faqs = Faq::published()->ordered()->get();
        
        return view('frontend.home', compact('services', 'team', 'posts', 'whyChooseItems', 'faqs'));
    }
}
