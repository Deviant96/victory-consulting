<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BusinessSolution;

class IndustryController extends Controller
{
    /**
     * Display a listing of industries/business solutions with sub-solutions.
     */
    public function index()
    {
        $industries = BusinessSolution::with(['subSolutions' => function ($query) {
            $query->active()->ordered();
        }])
        ->active()
        ->ordered()
        ->get();
        
        return view('frontend.industry.index', compact('industries'));
    }
}
