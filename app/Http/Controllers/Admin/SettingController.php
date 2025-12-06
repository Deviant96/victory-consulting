<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use LogsAdminActivity;

    public function contact()
    {
        $settings = Setting::whereIn('key', [
            'site.name',
            'site.email',
            'site.phone',
            'site.address',
        ])->pluck('value', 'key');

        return view('admin.settings.contact', compact('settings'));
    }

    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'site.name' => 'required|string|max:255',
            'site.email' => 'required|email',
            'site.phone' => 'nullable|string',
            'site.address' => 'nullable|string',
        ]);

        // Handle nested array from form submission (site[name] becomes site.name)
        $site = $request->input('site', []);
        foreach ($site as $key => $value) {
            $settingKey = "site.{$key}";
            Setting::set($settingKey, $value);
        }

        $this->logAdminActivity('updated settings', null, 'Updated contact settings');

        return redirect()->route('admin.settings.contact')->with('success', 'Contact settings updated successfully.');
    }

    public function social()
    {
        $settings = Setting::whereIn('key', [
            'social.facebook',
            'social.twitter',
            'social.linkedin',
            'social.instagram',
        ])->pluck('value', 'key');

        return view('admin.settings.social', compact('settings'));
    }

    public function updateSocial(Request $request)
    {
        $validated = $request->validate([
            'social.facebook' => 'nullable|url',
            'social.twitter' => 'nullable|url',
            'social.linkedin' => 'nullable|url',
            'social.instagram' => 'nullable|url',
        ]);

        // Handle nested array from form submission (social[facebook] becomes social.facebook)
        $social = $request->input('social', []);
        foreach ($social as $key => $value) {
            $settingKey = "social.{$key}";
            Setting::set($settingKey, $value ?? '');
        }

        $this->logAdminActivity('updated settings', null, 'Updated social settings');

        return redirect()->route('admin.settings.social')->with('success', 'Social media settings updated successfully.');
    }

    public function branding()
    {
        $settings = Setting::whereIn('key', [
            'branding.logo',
            'branding.favicon',
            'site.tagline',
        ])->pluck('value', 'key');

        return view('admin.settings.branding', compact('settings'));
    }

    public function updateBranding(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'tagline' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('branding.logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            $path = $request->file('logo')->store('branding', 'public');
            Setting::set('branding.logo', $path);
        }

        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            $oldFavicon = Setting::get('branding.favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            
            $path = $request->file('favicon')->store('branding', 'public');
            Setting::set('branding.favicon', $path);
        }

        if (isset($validated['tagline'])) {
            Setting::set('site.tagline', $validated['tagline']);
        }

        $this->logAdminActivity('updated settings', null, 'Updated branding settings');

        return redirect()->route('admin.settings.branding')->with('success', 'Branding settings updated successfully.');
    }

    public function booking()
    {
        $settings = Setting::whereIn('key', [
            'booking.notifications.email.enabled',
            'booking.notifications.email.address',
            'booking.notifications.push.enabled',
        ])->pluck('value', 'key');

        return view('admin.settings.booking', compact('settings'));
    }

    public function updateBooking(Request $request)
    {
        $validated = $request->validate([
            'booking.notifications.email.enabled' => 'nullable',
            'booking.notifications.email.address' => 'nullable|email',
            'booking.notifications.push.enabled' => 'nullable',
        ]);

        $emailEnabled = $request->input('booking.notifications.email.enabled', 0);
        $emailAddress = $request->input('booking.notifications.email.address', '');
        $pushEnabled = $request->input('booking.notifications.push.enabled', 0);

        Setting::set('booking.notifications.email.enabled', (bool) $emailEnabled);
        Setting::set('booking.notifications.email.address', $emailAddress);
        Setting::set('booking.notifications.push.enabled', (bool) $pushEnabled);

        $this->logAdminActivity('updated settings', null, 'Updated booking notification settings');

        return redirect()
            ->route('admin.settings.booking')
            ->with('success', 'Booking notification settings updated successfully.');
    }

    public function hero()
    {
        $settings = Setting::whereIn('key', [
            'hero.background_image',
            'hero.text_alignment',
            'hero.industry_image',
        ])->pluck('value', 'key');

        return view('admin.settings.hero', compact('settings'));
    }

    public function updateHero(Request $request)
    {
        $validated = $request->validate([
            'background_image' => 'nullable|image|max:4096',
            'industry_image' => 'nullable|image|max:4096',
            'text_alignment' => 'required|in:left,center,right',
        ]);

        if ($request->hasFile('background_image')) {
            // Delete old background image if exists
            $oldImage = Setting::get('hero.background_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            
            $path = $request->file('background_image')->store('hero', 'public');
            Setting::set('hero.background_image', $path);
        }

        if ($request->hasFile('industry_image')) {
            // Delete old industry image if exists
            $oldImage = Setting::get('hero.industry_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            
            $path = $request->file('industry_image')->store('hero', 'public');
            Setting::set('hero.industry_image', $path);
        }

        Setting::set('hero.text_alignment', $validated['text_alignment']);

        $this->logAdminActivity('updated settings', null, 'Updated hero section settings');

        return redirect()->route('admin.settings.hero')->with('success', 'Hero section settings updated successfully.');
    }

    public function about()
    {
        $settings = Setting::whereIn('key', [
            'about.header_title',
            'about.header_description',
            'about.content',
            'about.vision_title',
            'about.vision_content',
            'about.vision_image',
            'about.mission_title',
            'about.mission_content',
            'about.mission_image',
        ])->pluck('value', 'key');

        return view('admin.settings.about', compact('settings'));
    }

    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'about.header_title' => 'required|string|max:255',
            'about.header_description' => 'nullable|string',
            'about.content' => 'required|string',
            'about.vision_title' => 'nullable|string|max:255',
            'about.vision_content' => 'nullable|string',
            'about.vision_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'about.mission_title' => 'nullable|string|max:255',
            'about.mission_content' => 'nullable|string',
            'about.mission_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $about = $request->input('about', []);
        
        // Handle vision image upload
        if ($request->hasFile('about.vision_image')) {
            $oldImage = Setting::get('about.vision_image');
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            $path = $request->file('about.vision_image')->store('about', 'public');
            Setting::set('about.vision_image', $path);
            unset($about['vision_image']);
        }

        // Handle mission image upload
        if ($request->hasFile('about.mission_image')) {
            $oldImage = Setting::get('about.mission_image');
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            $path = $request->file('about.mission_image')->store('about', 'public');
            Setting::set('about.mission_image', $path);
            unset($about['mission_image']);
        }

        // Save all other settings
        foreach ($about as $key => $value) {
            $settingKey = "about.{$key}";
            Setting::set($settingKey, $value);
        }

        $this->logAdminActivity('updated settings', null, 'Updated About Us page content');

        return redirect()->route('admin.settings.about')->with('success', 'About Us page updated successfully.');
    }
}
