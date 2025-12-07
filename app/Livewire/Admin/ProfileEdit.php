<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileEdit extends Component
{
    use WithFileUploads;

    // Profile Information
    public $name = '';
    public $email = '';
    public $avatar;
    public $currentAvatarPath = '';

    // Password Change
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    // 2FA Settings
    public $two_factor_enabled = false;

    public $activeTab = 'profile';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->currentAvatarPath = $user->avatar ?? '';
        $this->two_factor_enabled = !is_null($user->two_factor_secret ?? null);
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:2048', // 2MB Max
        ]);
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;

        // Handle avatar upload
        if ($this->avatar) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        // Reset avatar input
        $this->avatar = null;
        $this->currentAvatarPath = $user->avatar ?? '';

        session()->flash('success', 'Profile updated successfully!');
    }

    public function removeAvatar()
    {
        $user = Auth::user();
        
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        $this->currentAvatarPath = '';
        session()->flash('success', 'Avatar removed successfully!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($this->password);
        $user->save();

        // Reset password fields
        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('success', 'Password changed successfully!');
    }

    public function enableTwoFactor()
    {
        // Placeholder for 2FA implementation
        $this->two_factor_enabled = true;
        session()->flash('success', 'Two-factor authentication enabled!');
    }

    public function disableTwoFactor()
    {
        // Placeholder for 2FA implementation
        $this->two_factor_enabled = false;
        session()->flash('success', 'Two-factor authentication disabled!');
    }

    public function render()
    {
        return view('livewire.admin.profile-edit');
    }
}
