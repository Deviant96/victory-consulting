<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;
use App\Models\Language;
use App\Traits\HandlesContentTranslations;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    use LogsAdminActivity;
    use HandlesContentTranslations;

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
            ->with('translations')
            ->ordered()
            ->get();

        $languages = Language::where('is_active', true)->orderBy('label')->get();

        return view('admin.faqs.index', compact('faqs', 'search', 'category', 'status', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('label')->get();

        return view('admin.faqs.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $validated = $request->validated();
        $validated['published'] = $request->boolean('published');

        $faq = Faq::create($validated);

        $this->syncTranslations($faq, $request, ['question', 'answer']);

        $this->logAdminActivity('created faq', $faq, "Created FAQ: {$faq->question}");

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
        $languages = Language::where('is_active', true)->orderBy('label')->get();
        $faq->load('translations');

        return view('admin.faqs.edit', compact('faq', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $validated = $request->validated();
        $validated['published'] = $request->boolean('published');

        $faq->update($validated);

        $this->syncTranslations($faq, $request, ['question', 'answer']);

        $this->logAdminActivity('updated faq', $faq, "Updated FAQ: {$faq->question}");

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $this->logAdminActivity('deleted faq', $faq, "Deleted FAQ: {$faq->question}");
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}
