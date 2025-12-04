<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogPostRequest;
use App\Models\BlogPost;
use App\Services\AdminActivityLogger;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $category = $request->string('category')->toString();

        $posts = BlogPost::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($category, fn ($query) => $query->where('category', 'like', "%{$category}%"))
            ->when($status === 'published', fn ($query) => $query->where('published', true))
            ->when($status === 'draft', fn ($query) => $query->where('published', false))
            ->latest()
            ->get();

        return view('admin.articles.index', compact('posts', 'search', 'status', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['tags'])) {
            $validated['tags'] = array_values(array_filter($validated['tags'], fn ($tag) => filled($tag)));
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        $validated['published'] = $request->boolean('published');
        $validated['published_at'] = $validated['published_at'] ?? ($validated['published'] ? now() : null);

        $post = BlogPost::create($validated);

        AdminActivityLogger::log('Created article', $post, "Title: {$post->title}");

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostRequest $request, BlogPost $article)
    {
        $validated = $request->validated();

        if (isset($validated['tags'])) {
            $validated['tags'] = array_values(array_filter($validated['tags'], fn ($tag) => filled($tag)));
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        $validated['published'] = $request->boolean('published');
        $validated['published_at'] = $validated['published_at'] ?? ($validated['published'] ? now() : null);

        $article->update($validated);

        AdminActivityLogger::log('Updated article', $article, "Title: {$article->title}");

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $article)
    {
        AdminActivityLogger::log('Deleted article', $article, "Title: {$article->title}");
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}
