<?php

namespace App\Livewire\Admin\TeamMembers;

use App\Models\TeamMember;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

/**
 * Team Member Form Component
 * 
 * Handles creating and editing team members with photo upload support.
 * Includes validation and real-time feedback.
 */
class TeamMemberForm extends Component
{
    use WithFileUploads;
    
    // Model properties
    public $memberId;
    public $name = '';
    public $position = '';
    public $bio = '';
    public $photo;
    public $existingPhoto;
    public $expertise = [];
    
    // UI state
    public $isEditMode = false;
    
    // Validation rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => $this->isEditMode 
                ? 'nullable|image|max:2048' 
                : 'required|image|max:2048',
            'expertise' => 'nullable|array',
        ];
    }
    
    /**
     * Custom validation messages
     */
    protected $messages = [
        'name.required' => 'Please enter the team member\'s name.',
        'position.required' => 'Please enter the team member\'s position.',
        'photo.required' => 'Please upload a photo.',
        'photo.image' => 'The photo must be an image file.',
        'photo.max' => 'The photo must not exceed 2MB.',
    ];
    
    /**
     * Mount the component
     */
    public function mount($memberId = null)
    {
        if ($memberId) {
            $this->isEditMode = true;
            $this->memberId = $memberId;
            $this->loadMember();
        }
    }
    
    /**
     * Load team member data for editing
     */
    public function loadMember()
    {
        $member = TeamMember::findOrFail($this->memberId);
        
        $this->name = $member->name;
        $this->position = $member->position;
        $this->bio = $member->bio;
        $this->existingPhoto = $member->photo;
        $this->expertise = $member->expertise ?? [];
    }
    
    /**
     * Real-time validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    /**
     * Add expertise item
     */
    public function addExpertise()
    {
        $this->expertise[] = '';
    }
    
    /**
     * Remove expertise item
     */
    public function removeExpertise($index)
    {
        unset($this->expertise[$index]);
        $this->expertise = array_values($this->expertise);
    }
    
    /**
     * Remove existing photo
     */
    public function removePhoto()
    {
        if ($this->existingPhoto && Storage::disk('public')->exists($this->existingPhoto)) {
            Storage::disk('public')->delete($this->existingPhoto);
        }
        
        $this->existingPhoto = null;
        
        if ($this->isEditMode) {
            TeamMember::where('id', $this->memberId)->update(['photo' => null]);
        }
    }
    
    /**
     * Save team member
     */
    public function save()
    {
        $this->validate();
        
        $data = [
            'name' => $this->name,
            'position' => $this->position,
            'bio' => $this->bio,
            'expertise' => array_filter($this->expertise),
        ];
        
        // Handle photo upload
        if ($this->photo) {
            // Delete old photo if exists
            if ($this->existingPhoto && Storage::disk('public')->exists($this->existingPhoto)) {
                Storage::disk('public')->delete($this->existingPhoto);
            }
            
            $data['photo'] = $this->photo->store('team-members', 'public');
        }
        
        if ($this->isEditMode) {
            $member = TeamMember::findOrFail($this->memberId);
            $member->update($data);
            $message = 'Team member updated successfully';
        } else {
            TeamMember::create($data);
            $message = 'Team member created successfully';
        }
        
        session()->flash('success', $message);
        
        return redirect()->route('admin.team.index');
    }
    
    /**
     * Cancel and return to index
     */
    public function cancel()
    {
        return redirect()->route('admin.team.index');
    }
    
    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.admin.team-members.team-member-form');
    }
}
