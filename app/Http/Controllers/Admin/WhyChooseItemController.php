<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseItem;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class WhyChooseItemController extends Controller
{
    use LogsAdminActivity;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $items = WhyChooseItem::query()
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

        return view('admin.why-choose-items.index', compact('items', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.why-choose-items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $item = WhyChooseItem::create($validated);

        $this->logAdminActivity('created why choose item', $item, "Created Why Choose Item: {$item->title}");

        return redirect()->route('admin.why-choose-items.index')->with('success', 'Item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhyChooseItem $whyChooseItem)
    {
        return view('admin.why-choose-items.edit', compact('whyChooseItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WhyChooseItem $whyChooseItem)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $whyChooseItem->update($validated);

        $this->logAdminActivity('updated why choose item', $whyChooseItem, "Updated Why Choose Item: {$whyChooseItem->title}");

        return redirect()->route('admin.why-choose-items.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhyChooseItem $whyChooseItem)
    {
        $this->logAdminActivity('deleted why choose item', $whyChooseItem, "Deleted Why Choose Item: {$whyChooseItem->title}");
        $whyChooseItem->delete();

        return redirect()->route('admin.why-choose-items.index')->with('success', 'Item deleted successfully.');
    }
}
