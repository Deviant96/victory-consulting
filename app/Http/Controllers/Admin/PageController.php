<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    use LogsAdminActivity;

    public function home()
    {
        $settings = Setting::whereIn('key', [
            'hero.background_image',
            'hero.text_alignment',
            'home.services_title',
            'home.services_description',
        ])->pluck('value', 'key');

        return view('admin.pages.home', compact('settings'));
    }

    public function updateHome(Request $request)
    {
        $validated = $request->validate([
            'home.services_title' => 'nullable|string|max:255',
            'home.services_description' => 'nullable|string',
            'hero_image' => 'nullable|image|max:2048',
            'hero.text_alignment' => 'nullable|string|in:left,center,right',
        ]);

        $homeSettings = $request->input('home', []);
        
        // Handle Hero Image (Moved from SettingController)
        if ($request->hasFile('hero_image')) {
            $oldImage = Setting::get('hero.background_image');
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            $path = $request->file('hero_image')->store('hero', 'public');
            Setting::set('hero.background_image', $path);
        }

        if ($request->has('hero.text_alignment')) {
             Setting::set('hero.text_alignment', $request->input('hero.text_alignment'));
        }

        // Handle Home Settings
        foreach ($homeSettings as $key => $value) {
            $settingKey = "home.{$key}";
            Setting::set($settingKey, $value);
        }
        
        // Handle Translations if necessary (assuming HasTranslations trait or similar logic in Setting model/controller)
        // For now, simple text update. Use standard request 'translations' if present.
        
        $this->logAdminActivity('updated settings', null, 'Updated Home page settings');

        return redirect()->route('admin.pages.home')->with('success', 'Home page updated successfully.');
    }

    public function services()
    {
        $settings = Setting::whereIn('key', [
            'services.page_title',
            'services.page_description',
        ])->pluck('value', 'key');

        return view('admin.pages.services', compact('settings'));
    }

    public function updateServices(Request $request)
    {
        // Placeholder for services page settings update
        $request->validate([
            'services.page_title' => 'nullable|string',
            'services.page_description' => 'nullable|string',
        ]);

        $settings = $request->input('services', []);
        foreach ($settings as $key => $value) {
             Setting::set("services.{$key}", $value);
        }

        return redirect()->route('admin.pages.services')->with('success', 'Services page updated successfully.');
    }
}
