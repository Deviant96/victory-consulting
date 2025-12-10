<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use App\Models\Language;
use App\Traits\HandlesContentTranslations;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    use LogsAdminActivity;
    use HandlesContentTranslations;

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
            ->with('translations')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $languages = Language::where('is_active', true)->orderBy('label')->get();

        return view('admin.services.index', compact('services', 'search', 'status', 'languages'));
    }

    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('label')->get();

        return view('admin.services.create', compact('languages'));
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

        $this->syncTranslations($service, $request, ['title', 'summary', 'description', 'price_note']);

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

        $this->logAdminActivity('created service', $service, "Created service: {$service->title}");

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $languages = Language::where('is_active', true)->orderBy('label')->get();
        $service->load(['highlights', 'translations']);

        return view('admin.services.edit', compact('service', 'languages'));
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

        $service->update($validated);

        $this->syncTranslations($service, $request, ['title', 'summary', 'description', 'price_note']);

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

        $this->logAdminActivity('updated service', $service, "Updated service: {$service->title}");

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $this->logAdminActivity('deleted service', $service, "Deleted service: {$service->title}");
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
