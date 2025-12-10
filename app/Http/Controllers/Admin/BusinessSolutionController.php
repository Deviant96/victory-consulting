<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSolution;
use App\Models\Language;
use App\Traits\HandlesContentTranslations;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class BusinessSolutionController extends Controller
{
    use LogsAdminActivity;
    use HandlesContentTranslations;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $solutions = BusinessSolution::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->with('translations')
            ->ordered()
            ->get();

        $languages = Language::where('is_active', true)->orderBy('label')->get();

        return view('admin.business-solutions.index', compact('solutions', 'search', 'status', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('label')->get();

        return view('admin.business-solutions.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'translations' => ['sometimes', 'array'],
            'translations.*' => ['sometimes', 'array'],
            'translations.*.title' => ['nullable', 'string'],
            'translations.*.description' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $solution = BusinessSolution::create($validated);

        $this->syncTranslations($solution, $request, ['title', 'description']);

        $this->logAdminActivity('created business solution', $solution, "Created Business Solution: {$solution->title}");

        return redirect()->route('admin.business-solutions.index')->with('success', 'Solution created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessSolution $businessSolution)
    {
        $languages = Language::where('is_active', true)->orderBy('label')->get();
        $businessSolution->load('translations');

        return view('admin.business-solutions.edit', compact('businessSolution', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessSolution $businessSolution)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'translations' => ['sometimes', 'array'],
            'translations.*' => ['sometimes', 'array'],
            'translations.*.title' => ['nullable', 'string'],
            'translations.*.description' => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $businessSolution->update($validated);

        $this->syncTranslations($businessSolution, $request, ['title', 'description']);

        $this->logAdminActivity('updated business solution', $businessSolution, "Updated Business Solution: {$businessSolution->title}");

        return redirect()->route('admin.business-solutions.index')->with('success', 'Solution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessSolution $businessSolution)
    {
        $this->logAdminActivity('deleted business solution', $businessSolution, "Deleted Business Solution: {$businessSolution->title}");
        $businessSolution->delete();

        return redirect()->route('admin.business-solutions.index')->with('success', 'Solution deleted successfully.');
    }
}
