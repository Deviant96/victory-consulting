<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MissionController extends Controller
{
    use LogsAdminActivity;

    public function index()
    {
        $missions = Mission::paginate(10);
        return view('admin.missions.index', compact('missions'));
    }

    public function create()
    {
        return view('admin.missions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('missions', 'public');
        }

        $mission = Mission::create($validated);

        $this->logAdminActivity('created mission', $mission, "Created Mission: {$mission->title}");

        return redirect()->route('admin.missions.index')
            ->with('success', 'Mission created successfully.');
    }

    public function edit(Mission $mission)
    {
        return view('admin.missions.edit', compact('mission'));
    }

    public function update(Request $request, Mission $mission)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($mission->image) {
                Storage::disk('public')->delete($mission->image);
            }
            $validated['image'] = $request->file('image')->store('missions', 'public');
        }

        $mission->update($validated);

        $this->logAdminActivity('updated mission', $mission, "Updated Mission: {$mission->title}");

        return redirect()->route('admin.missions.index')
            ->with('success', 'Mission updated successfully.');
    }

    public function destroy(Mission $mission)
    {
        if ($mission->image) {
            Storage::disk('public')->delete($mission->image);
        }

        $title = $mission->title;
        $mission->delete();

        $this->logAdminActivity('deleted mission', $mission, "Deleted Mission: {$title}");

        return redirect()->route('admin.missions.index')
            ->with('success', 'Mission deleted successfully.');
    }
}
