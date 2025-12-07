<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Models\ServiceHighlight;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Service Form Component
 * 
 * Handles creating and editing services with image upload and highlights.
 */
class ServiceForm extends Component
{
    use WithFileUploads;
    
    // Model properties
    public $serviceId;
    public $title = '';
    public $slug = '';
    public $summary = '';
    public $description = '';
    public $price_note = '';
    public $featured_image;
    public $existingImage;
    public $published = true;
    
    // Highlights
    public $highlights = [];
    
    // UI state
    public $isEditMode = false;
    
    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug,' . ($this->serviceId ?? 'NULL'),
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'price_note' => 'nullable|string',
            'featured_image' => $this->isEditMode 
                ? 'nullable|image|max:2048' 
                : 'required|image|max:2048',
            'published' => 'boolean',
            'highlights' => 'nullable|array',
            'highlights.*.title' => 'required|string|max:255',
            'highlights.*.description' => 'nullable|string',
        ];
    }
    
    protected $messages = [
        'title.required' => 'Please enter the service title.',
        'slug.required' => 'Please enter a slug.',
        'slug.unique' => 'This slug is already in use.',
        'featured_image.required' => 'Please upload a featured image.',
        'featured_image.image' => 'The file must be an image.',
        'featured_image.max' => 'The image must not exceed 2MB.',
        'highlights.*.title.required' => 'Highlight title is required.',
    ];
    
    /**
     * Mount component
     */
    public function mount($serviceId = null)
    {
        if ($serviceId) {
            $this->isEditMode = true;
            $this->serviceId = $serviceId;
            $this->loadService();
        }
    }
    
    /**
     * Load service for editing
     */
    public function loadService()
    {
        $service = Service::with('highlights')->findOrFail($this->serviceId);
        
        $this->title = $service->title;
        $this->slug = $service->slug;
        $this->summary = $service->summary;
        $this->description = $service->description;
        $this->price_note = $service->price_note;
        $this->existingImage = $service->featured_image;
        $this->published = $service->published;
        
        // Load highlights
        $this->highlights = $service->highlights->map(function ($highlight) {
            return [
                'id' => $highlight->id,
                'title' => $highlight->title,
                'description' => $highlight->description,
                'order' => $highlight->order,
            ];
        })->toArray();
    }
    
    /**
     * Generate slug from title
     */
    public function updatedTitle()
    {
        if (!$this->isEditMode || empty($this->slug)) {
            $this->slug = Str::slug($this->title);
        }
    }
    
    /**
     * Real-time validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    /**
     * Add highlight
     */
    public function addHighlight()
    {
        $this->highlights[] = [
            'id' => null,
            'title' => '',
            'description' => '',
            'order' => count($this->highlights),
        ];
    }
    
    /**
     * Remove highlight
     */
    public function removeHighlight($index)
    {
        unset($this->highlights[$index]);
        $this->highlights = array_values($this->highlights);
    }
    
    /**
     * Remove existing image
     */
    public function removeImage()
    {
        if ($this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
            Storage::disk('public')->delete($this->existingImage);
        }
        
        $this->existingImage = null;
        
        if ($this->isEditMode) {
            Service::where('id', $this->serviceId)->update(['featured_image' => null]);
        }
    }
    
    /**
     * Save service
     */
    public function save()
    {
        $this->validate();
        
        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'price_note' => $this->price_note,
            'published' => $this->published,
        ];
        
        // Handle image upload
        if ($this->featured_image) {
            // Delete old image
            if ($this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
                Storage::disk('public')->delete($this->existingImage);
            }
            
            $data['featured_image'] = $this->featured_image->store('services', 'public');
        }
        
        if ($this->isEditMode) {
            $service = Service::findOrFail($this->serviceId);
            $service->update($data);
            
            // Update highlights
            $this->saveHighlights($service);
            
            $message = 'Service updated successfully';
        } else {
            $service = Service::create($data);
            
            // Save highlights
            $this->saveHighlights($service);
            
            $message = 'Service created successfully';
        }
        
        session()->flash('success', $message);
        
        return redirect()->route('admin.services.index');
    }
    
    /**
     * Save service highlights
     */
    protected function saveHighlights($service)
    {
        // Get existing highlight IDs
        $existingIds = collect($this->highlights)->pluck('id')->filter()->toArray();
        
        // Delete removed highlights
        $service->highlights()->whereNotIn('id', $existingIds)->delete();
        
        // Update or create highlights
        foreach ($this->highlights as $index => $highlightData) {
            if (!empty($highlightData['title'])) {
                if (isset($highlightData['id'])) {
                    // Update existing
                    ServiceHighlight::where('id', $highlightData['id'])->update([
                        'title' => $highlightData['title'],
                        'description' => $highlightData['description'] ?? null,
                        'order' => $index,
                    ]);
                } else {
                    // Create new
                    $service->highlights()->create([
                        'title' => $highlightData['title'],
                        'description' => $highlightData['description'] ?? null,
                        'order' => $index,
                    ]);
                }
            }
        }
    }
    
    /**
     * Cancel
     */
    public function cancel()
    {
        return redirect()->route('admin.services.index');
    }
    
    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.admin.services.service-form');
    }
}
