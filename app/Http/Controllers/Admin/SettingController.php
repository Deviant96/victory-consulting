<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
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

        $changes = [];
        foreach ($validated as $key => $value) {
            $previous = Setting::get($key);
            if ($previous != $value) {
                $changes[$key] = [
                    'from' => $previous,
                    'to' => $value,
                ];
            }
            Setting::set($key, $value);
        }

        AdminActivity::record(
            'Updated contact settings',
            null,
            'Updated contact settings',
            $changes
        );

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

        $changes = [];
        foreach ($validated as $key => $value) {
            $previous = Setting::get($key);
            if ($previous != $value) {
                $changes[$key] = [
                    'from' => $previous,
                    'to' => $value,
                ];
            }
            Setting::set($key, $value);
        }

        AdminActivity::record(
            'Updated social settings',
            null,
            'Updated social links',
            $changes
        );

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

        $changes = [];
        if ($request->hasFile('branding.logo')) {
            $path = $request->file('branding.logo')->store('branding', 'public');
            $previous = Setting::get('branding.logo');
            if ($previous != $path) {
                $changes['branding.logo'] = [
                    'from' => $previous,
                    'to' => $path,
                ];
            }
            Setting::set('branding.logo', $path);
        }

        if ($request->hasFile('branding.favicon')) {
            $path = $request->file('branding.favicon')->store('branding', 'public');
            $previous = Setting::get('branding.favicon');
            if ($previous != $path) {
                $changes['branding.favicon'] = [
                    'from' => $previous,
                    'to' => $path,
                ];
            }
            Setting::set('branding.favicon', $path);
        }

        if (isset($validated['site.tagline'])) {
            $previous = Setting::get('site.tagline');
            if ($previous != $validated['site.tagline']) {
                $changes['site.tagline'] = [
                    'from' => $previous,
                    'to' => $validated['site.tagline'],
                ];
            }
            Setting::set('site.tagline', $validated['site.tagline']);
        }

        AdminActivity::record(
            'Updated branding settings',
            null,
            'Updated branding assets and tagline',
            $changes
        );

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

        $changes = [];
        $previousEmailEnabled = Setting::get('booking.notifications.email.enabled');
        if ($previousEmailEnabled != (bool) $emailEnabled) {
            $changes['booking.notifications.email.enabled'] = [
                'from' => $previousEmailEnabled,
                'to' => (bool) $emailEnabled,
            ];
        }
        Setting::set('booking.notifications.email.enabled', (bool) $emailEnabled);

        $previousEmailAddress = Setting::get('booking.notifications.email.address');
        if ($previousEmailAddress != $emailAddress) {
            $changes['booking.notifications.email.address'] = [
                'from' => $previousEmailAddress,
                'to' => $emailAddress,
            ];
        }
        Setting::set('booking.notifications.email.address', $emailAddress);

        $previousPushEnabled = Setting::get('booking.notifications.push.enabled');
        if ($previousPushEnabled != (bool) $pushEnabled) {
            $changes['booking.notifications.push.enabled'] = [
                'from' => $previousPushEnabled,
                'to' => (bool) $pushEnabled,
            ];
        }
        Setting::set('booking.notifications.push.enabled', (bool) $pushEnabled);

        AdminActivity::record(
            'Updated booking notification settings',
            null,
            'Updated booking notification preferences',
            $changes
        );

        return redirect()
            ->route('admin.settings.booking')
            ->with('success', 'Booking notification settings updated successfully.');
    }
}
