<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Support\ActivityLogger;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $category = $request->string('category')->toString();
        $status = $request->string('status')->toString();

        $faqs = Faq::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('question', 'like', "%{$search}%")
                        ->orWhere('answer', 'like', "%{$search}%");
                });
            })
            ->when($category, fn ($query) => $query->where('category', 'like', "%{$category}%"))
            ->when($status === 'published', fn ($query) => $query->where('published', true))
            ->when($status === 'draft', fn ($query) => $query->where('published', false))
            ->ordered()
            ->get();

        return view('admin.faqs.index', compact('faqs', 'search', 'category', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $validated = $request->validated();
        $validated['published'] = $request->boolean('published');

        $faq = Faq::create($validated);

        ActivityLogger::log(
            'faq_created',
            sprintf('Created FAQ "%s"', $faq->question),
            $faq
        );

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
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
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $validated = $request->validated();
        $validated['published'] = $request->boolean('published');

        $faq->update($validated);

        ActivityLogger::log(
            'faq_updated',
            sprintf('Updated FAQ "%s"', $faq->question),
            $faq
        );

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $question = $faq->question;
        $faq->delete();

        ActivityLogger::log(
            'faq_deleted',
            sprintf('Deleted FAQ "%s"', $question),
            $faq
        );
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}
