<?php

namespace App\Livewire\Admin\BusinessSolutions;

use App\Models\BusinessSolution;
use App\Models\SubSolution;
use Livewire\Component;

class BusinessSolutionForm extends Component
{
    public $solutionId;
    public $title = '';
    public $description = '';
    public $order = 0;
    public $is_active = true;
    public $subSolutions = [];

    public $isEditMode = false;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'subSolutions' => 'array',
            'subSolutions.*.title' => 'required|string|max:255',
            'subSolutions.*.order' => 'required|integer|min:0',
            'subSolutions.*.is_active' => 'boolean',
        ];
    }

    protected $messages = [
        'subSolutions.*.title.required' => 'Sub-solution title is required',
        'subSolutions.*.order.required' => 'Sub-solution order is required',
    ];

    public function mount($solutionId = null)
    {
        if ($solutionId) {
            $this->isEditMode = true;
            $this->solutionId = $solutionId;
            $this->loadSolution();
        } else {
            // Set default order to highest + 1
            $this->order = BusinessSolution::max('order') + 1 ?? 0;
        }
    }

    public function loadSolution()
    {
        $solution = BusinessSolution::with('subSolutions')->findOrFail($this->solutionId);
        
        $this->title = $solution->title;
        $this->description = $solution->description ?? '';
        $this->order = $solution->order;
        $this->is_active = $solution->is_active;
        
        // Load sub-solutions
        $this->subSolutions = $solution->subSolutions->map(function ($subSolution) {
            return [
                'id' => $subSolution->id,
                'title' => $subSolution->title,
                'order' => $subSolution->order,
                'is_active' => $subSolution->is_active,
            ];
        })->toArray();
    }

    public function addSubSolution()
    {
        $nextOrder = count($this->subSolutions);
        
        $this->subSolutions[] = [
            'id' => null,
            'title' => '',
            'order' => $nextOrder,
            'is_active' => true,
        ];
    }

    public function removeSubSolution($index)
    {
        unset($this->subSolutions[$index]);
        $this->subSolutions = array_values($this->subSolutions);
        
        // Reorder remaining sub-solutions
        foreach ($this->subSolutions as $key => $subSolution) {
            $this->subSolutions[$key]['order'] = $key;
        }
    }

    public function moveSubSolutionUp($index)
    {
        if ($index > 0) {
            $temp = $this->subSolutions[$index];
            $this->subSolutions[$index] = $this->subSolutions[$index - 1];
            $this->subSolutions[$index - 1] = $temp;
            
            // Update orders
            $this->subSolutions[$index]['order'] = $index;
            $this->subSolutions[$index - 1]['order'] = $index - 1;
        }
    }

    public function moveSubSolutionDown($index)
    {
        if ($index < count($this->subSolutions) - 1) {
            $temp = $this->subSolutions[$index];
            $this->subSolutions[$index] = $this->subSolutions[$index + 1];
            $this->subSolutions[$index + 1] = $temp;
            
            // Update orders
            $this->subSolutions[$index]['order'] = $index;
            $this->subSolutions[$index + 1]['order'] = $index + 1;
        }
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->isEditMode) {
            $solution = BusinessSolution::findOrFail($this->solutionId);
            $solution->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'order' => $validated['order'],
                'is_active' => $validated['is_active'],
            ]);
            
            // Update sub-solutions
            $existingIds = collect($validated['subSolutions'])->pluck('id')->filter()->toArray();
            
            // Delete removed sub-solutions
            $solution->subSolutions()->whereNotIn('id', $existingIds)->delete();
            
            // Update or create sub-solutions
            foreach ($validated['subSolutions'] as $subSolutionData) {
                if (isset($subSolutionData['id'])) {
                    SubSolution::where('id', $subSolutionData['id'])->update([
                        'title' => $subSolutionData['title'],
                        'order' => $subSolutionData['order'],
                        'is_active' => $subSolutionData['is_active'],
                    ]);
                } else {
                    $solution->subSolutions()->create([
                        'title' => $subSolutionData['title'],
                        'order' => $subSolutionData['order'],
                        'is_active' => $subSolutionData['is_active'],
                    ]);
                }
            }
            
            $message = 'Business solution updated successfully';
        } else {
            $solution = BusinessSolution::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'order' => $validated['order'],
                'is_active' => $validated['is_active'],
            ]);
            
            // Create sub-solutions
            foreach ($validated['subSolutions'] as $subSolutionData) {
                $solution->subSolutions()->create([
                    'title' => $subSolutionData['title'],
                    'order' => $subSolutionData['order'],
                    'is_active' => $subSolutionData['is_active'],
                ]);
            }
            
            $message = 'Business solution created successfully';
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);

        return redirect()->route('admin.business-solutions.index');
    }

    public function cancel()
    {
        return redirect()->route('admin.business-solutions.index');
    }

    public function render()
    {
        return view('livewire.admin.business-solutions.business-solution-form');
    }
}
