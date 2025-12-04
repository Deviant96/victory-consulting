<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\AdminActivity;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $services = Service::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%");
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('published', true))
            ->when($status === 'draft', fn ($query) => $query->where('published', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.services.index', compact('services', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(ServiceRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['published'] = $request->has('published');

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('services', 'public');
            $validated['featured_image'] = $path;
        }

        $service = Service::create($validated);

        AdminActivity::record(
            'Created service',
            $service,
            sprintf('Created service "%s"', $service->title),
            AdminActivity::snapshotFor($service)
        );

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

    public function update(ServiceRequest $request, Service $service)
    {
        $validated = $request->validated();

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['published'] = $request->has('published');

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('services', 'public');
            $validated['featured_image'] = $path;
        }

        $original = $service->getOriginal();
        $service->update($validated);

        $changes = AdminActivity::diffFor($service, $original);

        AdminActivity::record(
            'Updated service',
            $service,
            sprintf('Updated service "%s"', $service->title),
            $changes
        );

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
        $title = $service->title;
        $service->delete();

        AdminActivity::record(
            'Deleted service',
            $service,
            sprintf('Deleted service "%s"', $title)
        );

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
