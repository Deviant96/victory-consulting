<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseItem;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $whyChooseItems = WhyChooseItem::active()->ordered()->get();
        $teamMembers = TeamMember::orderBy('order')->get();
        
        return view('frontend.about', compact('whyChooseItems', 'teamMembers'));
    }
}
