<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
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

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

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

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

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
            'branding.logo' => 'nullable|image|max:2048',
            'branding.favicon' => 'nullable|image|max:1024',
            'site.tagline' => 'nullable|string',
        ]);

        if ($request->hasFile('branding.logo')) {
            $path = $request->file('branding.logo')->store('branding', 'public');
            Setting::set('branding.logo', $path);
        }

        if ($request->hasFile('branding.favicon')) {
            $path = $request->file('branding.favicon')->store('branding', 'public');
            Setting::set('branding.favicon', $path);
        }

        if (isset($validated['site.tagline'])) {
            Setting::set('site.tagline', $validated['site.tagline']);
        }

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
            'booking.notifications.email.enabled' => 'nullable|boolean',
            'booking.notifications.email.address' => 'nullable|email',
            'booking.notifications.push.enabled' => 'nullable|boolean',
        ]);

        Setting::set('booking.notifications.email.enabled', $request->boolean('booking.notifications.email.enabled'));
        Setting::set('booking.notifications.email.address', $validated['booking.notifications.email.address'] ?? '');
        Setting::set('booking.notifications.push.enabled', $request->boolean('booking.notifications.push.enabled'));

        return redirect()
            ->route('admin.settings.booking')
            ->with('success', 'Booking notification settings updated successfully.');
    }
}
