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
}
