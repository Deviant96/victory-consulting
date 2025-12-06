<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vision;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisionController extends Controller
{
    use LogsAdminActivity;

    public function index()
    {
        $visions = Vision::paginate(10);
        return view('admin.visions.index', compact('visions'));
    }

    public function create()
    {
        return view('admin.visions.create');
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
            $validated['image'] = $request->file('image')->store('visions', 'public');
        }

        $vision = Vision::create($validated);

        $this->logAdminActivity('created vision', $vision, "Created Vision: {$vision->title}");

        return redirect()->route('admin.visions.index')
            ->with('success', 'Vision created successfully.');
    }

    public function edit(Vision $vision)
    {
        return view('admin.visions.edit', compact('vision'));
    }

    public function update(Request $request, Vision $vision)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($vision->image) {
                Storage::disk('public')->delete($vision->image);
            }
            $validated['image'] = $request->file('image')->store('visions', 'public');
        }

        $vision->update($validated);

        $this->logAdminActivity('updated vision', $vision, "Updated Vision: {$vision->title}");

        return redirect()->route('admin.visions.index')
            ->with('success', 'Vision updated successfully.');
    }

    public function destroy(Vision $vision)
    {
        if ($vision->image) {
            Storage::disk('public')->delete($vision->image);
        }

        $title = $vision->title;
        $vision->delete();

        $this->logAdminActivity('deleted vision', $vision, "Deleted Vision: {$title}");

        return redirect()->route('admin.visions.index')
            ->with('success', 'Vision deleted successfully.');
    }
}
