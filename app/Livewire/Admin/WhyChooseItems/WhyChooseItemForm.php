<?php

namespace App\Livewire\Admin\WhyChooseItems;

use App\Models\WhyChooseItem;
use Livewire\Component;

class WhyChooseItemForm extends Component
{
    public $itemId;
    public $title = '';
    public $description = '';
    public $icon = '';
    public $order = 0;
    public $is_active = true;

    public $isEditMode = false;

    // Common icon options
    public $iconOptions = [
        'fa-solid fa-check',
        'fa-solid fa-star',
        'fa-solid fa-heart',
        'fa-solid fa-thumbs-up',
        'fa-solid fa-trophy',
        'fa-solid fa-award',
        'fa-solid fa-shield',
        'fa-solid fa-bolt',
        'fa-solid fa-lightbulb',
        'fa-solid fa-rocket',
        'fa-solid fa-chart-line',
        'fa-solid fa-users',
        'fa-solid fa-handshake',
        'fa-solid fa-crown',
        'fa-solid fa-gem',
        'fa-solid fa-fire',
        'fa-solid fa-leaf',
        'fa-solid fa-sun',
        'fa-solid fa-moon',
        'fa-solid fa-clock',
    ];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'required|string|max:100',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function mount($itemId = null)
    {
        if ($itemId) {
            $this->isEditMode = true;
            $this->itemId = $itemId;
            $this->loadItem();
        } else {
            // Set default order to highest + 1
            $this->order = WhyChooseItem::max('order') + 1 ?? 0;
            // Set default icon
            $this->icon = 'fa-solid fa-check';
        }
    }

    public function loadItem()
    {
        $item = WhyChooseItem::findOrFail($this->itemId);
        
        $this->title = $item->title;
        $this->description = $item->description ?? '';
        $this->icon = $item->icon;
        $this->order = $item->order;
        $this->is_active = $item->is_active;
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->isEditMode) {
            $item = WhyChooseItem::findOrFail($this->itemId);
            $item->update($validated);
            
            $message = 'Item updated successfully';
        } else {
            WhyChooseItem::create($validated);
            
            $message = 'Item created successfully';
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);

        return redirect()->route('admin.why-choose-items.index');
    }

    public function cancel()
    {
        return redirect()->route('admin.why-choose-items.index');
    }

    public function render()
    {
        return view('livewire.admin.why-choose-items.why-choose-item-form');
    }
}
