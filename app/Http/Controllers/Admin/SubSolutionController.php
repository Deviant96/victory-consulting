<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSolution;
use App\Models\SubSolution;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class SubSolutionController extends Controller
{
    use LogsAdminActivity;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $solutionId = $request->string('solution')->toString();

        $subSolutions = SubSolution::query()
            ->with('businessSolution')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($solutionId, fn ($query) => $query->where('business_solution_id', $solutionId))
            ->ordered()
            ->get();

        $businessSolutions = BusinessSolution::ordered()->get();

        return view('admin.sub-solutions.index', compact('subSolutions', 'businessSolutions', 'search', 'solutionId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businessSolutions = BusinessSolution::ordered()->get();
        return view('admin.sub-solutions.create', compact('businessSolutions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_solution_id' => 'required|exists:business_solutions,id',
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $subSolution = SubSolution::create($validated);

        $this->logAdminActivity('created sub-solution', $subSolution, "Created Sub-Solution: {$subSolution->title}");

        return redirect()->route('admin.sub-solutions.index')->with('success', 'Sub-solution created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubSolution $subSolution)
    {
        $businessSolutions = BusinessSolution::ordered()->get();
        return view('admin.sub-solutions.edit', compact('subSolution', 'businessSolutions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubSolution $subSolution)
    {
        $validated = $request->validate([
            'business_solution_id' => 'required|exists:business_solutions,id',
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $subSolution->update($validated);

        $this->logAdminActivity('updated sub-solution', $subSolution, "Updated Sub-Solution: {$subSolution->title}");

        return redirect()->route('admin.sub-solutions.index')->with('success', 'Sub-solution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubSolution $subSolution)
    {
        $title = $subSolution->title;
        $subSolution->delete();

        $this->logAdminActivity('deleted sub-solution', $subSolution, "Deleted Sub-Solution: {$title}");

        return redirect()->route('admin.sub-solutions.index')->with('success', 'Sub-solution deleted successfully.');
    }
}
