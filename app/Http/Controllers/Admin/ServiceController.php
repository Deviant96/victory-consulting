<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:services,slug',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'price_note' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'published' => 'boolean',
            'highlights' => 'nullable|array',
            'highlights.*.label' => 'required|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['published'] = $request->has('published');

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('services', 'public');
            $validated['featured_image'] = $path;
        }

        $service = Service::create($validated);

        // Save highlights
        if ($request->has('highlights')) {
            foreach ($request->highlights as $index => $highlight) {
                if (!empty($highlight['label'])) {
                    $service->highlights()->create([
                        'label' => $highlight['label'],
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:services,slug,' . $service->id,
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'price_note' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'published' => 'boolean',
            'highlights' => 'nullable|array',
            'highlights.*.label' => 'required|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['published'] = $request->has('published');

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('services', 'public');
            $validated['featured_image'] = $path;
        }

        $service->update($validated);

        // Update highlights
        $service->highlights()->delete();
        if ($request->has('highlights')) {
            foreach ($request->highlights as $index => $highlight) {
                if (!empty($highlight['label'])) {
                    $service->highlights()->create([
                        'label' => $highlight['label'],
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
