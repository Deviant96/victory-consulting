<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $query = BlogPost::published();

        // Search filter
        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('excerpt', 'like', '%' . request('search') . '%')
                  ->orWhere('content', 'like', '%' . request('search') . '%');
            });
        }

        // Category filter
        if (request('category')) {
            $query->where('category', request('category'));
        }

        // Date range filter
        if (request('date_from')) {
            $query->whereDate('published_at', '>=', request('date_from'));
        }
        if (request('date_to')) {
            $query->whereDate('published_at', '<=', request('date_to'));
        }

        // Sort by
        $sortBy = request('sort', 'latest');
        if ($sortBy === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $posts = $query->paginate(10)->withQueryString();
        
        // Get all unique categories for filter
        $categories = BlogPost::published()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('frontend.blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('published', true)->firstOrFail();
        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();
            
        return view('frontend.blog.show', compact('post', 'relatedPosts'));
    }
}
