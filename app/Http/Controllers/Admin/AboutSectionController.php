<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSectionController extends Controller
{
    use LogsAdminActivity;

    public function index()
    {
        $sections = AboutSection::orderBy('order')->paginate(10);
        return view('admin.about-sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.about-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('about-sections', 'public');
        }

        $section = AboutSection::create($validated);

        $this->logAdminActivity('created about section', $section, "Created About Section: {$section->title}");

        return redirect()->route('admin.about-sections.index')
            ->with('success', 'About section created successfully.');
    }

    public function edit(AboutSection $aboutSection)
    {
        return view('admin.about-sections.edit', compact('aboutSection'));
    }

    public function update(Request $request, AboutSection $aboutSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($aboutSection->image) {
                Storage::disk('public')->delete($aboutSection->image);
            }
            $validated['image'] = $request->file('image')->store('about-sections', 'public');
        }

        $aboutSection->update($validated);

        $this->logAdminActivity('updated about section', $aboutSection, "Updated About Section: {$aboutSection->title}");

        return redirect()->route('admin.about-sections.index')
            ->with('success', 'About section updated successfully.');
    }

    public function destroy(AboutSection $aboutSection)
    {
        if ($aboutSection->image) {
            Storage::disk('public')->delete($aboutSection->image);
        }

        $title = $aboutSection->title;
        $aboutSection->delete();

        $this->logAdminActivity('deleted about section', $aboutSection, "Deleted About Section: {$title}");

        return redirect()->route('admin.about-sections.index')
            ->with('success', 'About section deleted successfully.');
    }
}
