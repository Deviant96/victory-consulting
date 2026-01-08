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
        $languages = \App\Models\Language::active()->get();
        
        $settingKeys = [
            'hero.background_image',
            'hero.text_alignment',
            'home.services_title',
            'home.services_description',
            'home.why_choose_title',
            'home.why_choose_description',
            'home.business_solutions_title',
            'home.business_solutions_description',
            'home.blog_title',
            'home.blog_description',
            'home.blog_button_text',
        ];
        
        $settings = Setting::whereIn('key', $settingKeys)->get()->keyBy('key');

        return view('admin.pages.home', compact('settings', 'languages'));
    }

    public function updateHome(Request $request)
    {
        $validated = $request->validate([
            'home.services_title' => 'nullable|string|max:255',
            'home.services_description' => 'nullable|string',
            'home.why_choose_title' => 'nullable|string|max:255',
            'home.why_choose_description' => 'nullable|string',
            'home.business_solutions_title' => 'nullable|string|max:255',
            'home.business_solutions_description' => 'nullable|string',
            'home.blog_title' => 'nullable|string|max:255',
            'home.blog_description' => 'nullable|string',
            'home.blog_button_text' => 'nullable|string|max:100',
            'hero_image' => 'nullable|image|max:2048',
            'hero.text_alignment' => 'nullable|string|in:left,center,right',
        ]);

        $homeSettings = $request->input('home', []);
        $translations = $request->input('translations', []);
        
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

        // Translatable fields
        $translatableFields = [
            'services_title',
            'services_description',
            'why_choose_title',
            'why_choose_description',
            'business_solutions_title',
            'business_solutions_description',
            'blog_title',
            'blog_description',
            'blog_button_text',
        ];

        // Save all settings and their translations
        foreach ($homeSettings as $key => $value) {
            $settingKey = "home.{$key}";
            $setting = Setting::firstOrCreate(['key' => $settingKey]);
            $setting->value = $value;
            $setting->save();

            // Save translations for this field
            if (in_array($key, $translatableFields)) {
                foreach ($translations as $locale => $fields) {
                    $translatedValue = $fields[$key] ?? null;
                    if ($translatedValue) {
                        $setting->setTranslation($key, $locale, $translatedValue);
                    }
                }
            }
        }
        
        $this->logAdminActivity('updated settings', null, 'Updated Home page settings');

        return redirect()->route('admin.pages.home')->with('success', 'Home page updated successfully.');
    }

    public function services()
    {
        $languages = \App\Models\Language::active()->get();
        
        $settingKeys = [
            'services.page_title',
            'services.page_description',
        ];
        
        $settings = Setting::whereIn('key', $settingKeys)->get()->keyBy('key');

        return view('admin.pages.services', compact('settings', 'languages'));
    }

    public function updateServices(Request $request)
    {
        $request->validate([
            'services.page_title' => 'nullable|string',
            'services.page_description' => 'nullable|string',
        ]);

        $servicesSettings = $request->input('services', []);
        $translations = $request->input('translations', []);
        
        // Translatable fields
        $translatableFields = [
            'page_title',
            'page_description',
        ];

        // Save all settings and their translations
        foreach ($servicesSettings as $key => $value) {
            $settingKey = "services.{$key}";
            $setting = Setting::firstOrCreate(['key' => $settingKey]);
            $setting->value = $value;
            $setting->save();

            // Save translations for this field
            if (in_array($key, $translatableFields)) {
                foreach ($translations as $locale => $fields) {
                    $translatedValue = $fields[$key] ?? null;
                    if ($translatedValue) {
                        $setting->setTranslation($key, $locale, $translatedValue);
                    }
                }
            }
        }
        
        $this->logAdminActivity('updated settings', null, 'Updated Services page settings');

        return redirect()->route('admin.pages.services')->with('success', 'Services page updated successfully.');
    }
}
