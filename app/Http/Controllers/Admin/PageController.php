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
            'home.business_solutions_image',
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
            'business_solutions_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
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

        if ($request->hasFile('business_solutions_image')) {
            $oldImage = Setting::get('home.business_solutions_image');
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            $path = $request->file('business_solutions_image')->store('home', 'public');
            Setting::set('home.business_solutions_image', $path);
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
            'services.cta_heading',
            'services.cta_button',
        ];
        
        $settings = Setting::whereIn('key', $settingKeys)->get()->keyBy('key');

        return view('admin.pages.services', compact('settings', 'languages'));
    }

    public function updateServices(Request $request)
    {
        $request->validate([
            'services.page_title' => 'nullable|string',
            'services.page_description' => 'nullable|string',
            'services.cta_heading' => 'nullable|string|max:255',
            'services.cta_button' => 'nullable|string|max:100',
        ]);

        $servicesSettings = $request->input('services', []);
        $translations = $request->input('translations', []);
        
        // Translatable fields
        $translatableFields = [
            'page_title',
            'page_description',
            'cta_heading',
            'cta_button',
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

    public function industry()
    {
        $languages = \App\Models\Language::active()->get();
        
        $settingKeys = [
            'industry.page_title',
            'industry.page_description',
            'industry.cta_title',
            'industry.cta_description',
            'industry.cta_primary_button',
            'industry.cta_secondary_button',
            'hero.industry_image',
        ];
        
        $settings = Setting::whereIn('key', $settingKeys)->get()->keyBy('key');

        return view('admin.pages.industry', compact('settings', 'languages'));
    }

    public function updateIndustry(Request $request)
    {
        $request->validate([
            'industry.page_title' => 'nullable|string|max:255',
            'industry.page_description' => 'nullable|string',
            'industry.cta_title' => 'nullable|string|max:255',
            'industry.cta_description' => 'nullable|string',
            'industry.cta_primary_button' => 'nullable|string|max:100',
            'industry.cta_secondary_button' => 'nullable|string|max:100',
            'industry_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Handle industry hero image upload
        if ($request->hasFile('industry_image')) {
            $image = $request->file('industry_image');
            $imagePath = $image->store('images/hero', 'public');
            
            // Save to settings
            $setting = Setting::firstOrCreate(['key' => 'hero.industry_image']);
            
            // Delete old image if exists
            if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
            
            $setting->value = $imagePath;
            $setting->save();
        }

        $industrySettings = $request->input('industry', []);
        $translations = $request->input('translations', []);
        
        // Translatable fields
        $translatableFields = [
            'page_title',
            'page_description',
            'cta_title',
            'cta_description',
            'cta_primary_button',
            'cta_secondary_button',
        ];

        // Save all settings and their translations
        foreach ($industrySettings as $key => $value) {
            $settingKey = "industry.{$key}";
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
        
        $this->logAdminActivity('updated settings', null, 'Updated Industry page settings');

        return redirect()->route('admin.pages.industry')->with('success', 'Industry page updated successfully.');
    }

    public function blog()
    {
        $languages = \App\Models\Language::active()->get();
        
        $settingKeys = [
            'blog.page_title',
            'blog.page_description',
            'blog.enable_filters',
            'blog.cta_title',
            'blog.cta_description',
            'blog.cta_button',
        ];
        
        $settings = Setting::whereIn('key', $settingKeys)->get()->keyBy('key');

        return view('admin.pages.blog', compact('settings', 'languages'));
    }

    public function updateBlog(Request $request)
    {
        $request->validate([
            'blog.page_title' => 'nullable|string|max:255',
            'blog.page_description' => 'nullable|string',
            'blog.enable_filters' => 'nullable|boolean',
            'blog.cta_title' => 'nullable|string|max:255',
            'blog.cta_description' => 'nullable|string',
            'blog.cta_button' => 'nullable|string|max:100',
        ]);

        $blogSettings = $request->input('blog', []);
        $translations = $request->input('translations', []);
        
        // Translatable fields
        $translatableFields = [
            'page_title',
            'page_description',
            'cta_title',
            'cta_description',
            'cta_button',
        ];

        // Save all settings and their translations
        foreach ($blogSettings as $key => $value) {
            $settingKey = "blog.{$key}";
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
        
        $this->logAdminActivity('updated settings', null, 'Updated Blog page settings');

        return redirect()->route('admin.pages.blog')->with('success', 'Blog page updated successfully.');
    }

    public function contact()
    {
        $languages = \App\Models\Language::active()->get();
        
        $settingKeys = [
            'contact.page_title',
            'contact.page_description',
        ];
        
        $settings = Setting::whereIn('key', $settingKeys)->get()->keyBy('key');

        return view('admin.pages.contact', compact('settings', 'languages'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact.page_title' => 'nullable|string|max:255',
            'contact.page_description' => 'nullable|string',
        ]);

        $contactSettings = $request->input('contact', []);
        $translations = $request->input('translations', []);
        
        // Translatable fields
        $translatableFields = [
            'page_title',
            'page_description',
        ];

        // Save all settings and their translations
        foreach ($contactSettings as $key => $value) {
            $settingKey = "contact.{$key}";
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
        
        $this->logAdminActivity('updated settings', null, 'Updated Contact page settings');

        return redirect()->route('admin.pages.contact')->with('success', 'Contact page updated successfully.');
    }
}
