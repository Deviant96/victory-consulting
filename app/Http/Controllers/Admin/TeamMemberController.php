<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamMemberRequest;
use App\Models\AdminActivity;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $teamMembers = TeamMember::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.team.index', compact('teamMembers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamMemberRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('team', 'public');
        }

        $teamMember = TeamMember::create($validated);

        AdminActivity::record(
            'Created team member',
            $teamMember,
            sprintf('Added team member "%s"', $teamMember->name),
            AdminActivity::snapshotFor($teamMember)
        );

        return redirect()->route('admin.team.index')->with('success', 'Team member created successfully.');
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
    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamMemberRequest $request, TeamMember $team)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('team', 'public');
        }

        $original = $team->getOriginal();
        $team->update($validated);

        $changes = AdminActivity::diffFor($team, $original);

        AdminActivity::record(
            'Updated team member',
            $team,
            sprintf('Updated team member "%s"', $team->name),
            $changes
        );

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamMember $team)
    {
        $name = $team->name;
        $team->delete();

        AdminActivity::record(
            'Deleted team member',
            $team,
            sprintf('Removed team member "%s"', $name)
        );
        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }
}
