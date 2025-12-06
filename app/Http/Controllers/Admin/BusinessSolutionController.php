<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSolution;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class BusinessSolutionController extends Controller
{
    use LogsAdminActivity;

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
            ->ordered()
            ->get();

        return view('admin.business-solutions.index', compact('solutions', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.business-solutions.create');
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
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $solution = BusinessSolution::create($validated);

        $this->logAdminActivity('created business solution', $solution, "Created Business Solution: {$solution->title}");

        return redirect()->route('admin.business-solutions.index')->with('success', 'Solution created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessSolution $businessSolution)
    {
        return view('admin.business-solutions.edit', compact('businessSolution'));
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
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $businessSolution->update($validated);

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
