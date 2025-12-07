<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SettingsForm extends Component
{
    use WithFileUploads;

    public $activeTab = 'contact';

    // Contact Settings
    public $contact_email = '';
    public $contact_phone = '';
    public $contact_address = '';
    public $contact_working_hours = '';

    // Social Media Settings
    public $social_facebook = '';
    public $social_twitter = '';
    public $social_instagram = '';
    public $social_linkedin = '';
    public $social_youtube = '';

    // Branding Settings
    public $site_name = '';
    public $site_tagline = '';
    public $site_logo;
    public $existing_logo = '';
    public $site_favicon;
    public $existing_favicon = '';
    
    // Hero Section Settings
    public $hero_title = '';
    public $hero_subtitle = '';
    public $hero_cta_text = '';
    public $hero_cta_url = '';
    public $background_image;
    public $existing_background_image = '';
    public $text_alignment = 'center';
    public $industry_image;
    public $existing_industry_image = '';

    // Booking Notifications Settings
    public $booking_email_notifications = true;
    public $booking_sms_notifications = false;
    public $booking_notification_email = '';

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Contact Settings
        $this->contact_email = Setting::get('contact_email', '');
        $this->contact_phone = Setting::get('contact_phone', '');
        $this->contact_address = Setting::get('contact_address', '');
        $this->contact_working_hours = Setting::get('contact_working_hours', '');

        // Social Media Settings
        $this->social_facebook = Setting::get('social_facebook', '');
        $this->social_twitter = Setting::get('social_twitter', '');
        $this->social_instagram = Setting::get('social_instagram', '');
        $this->social_linkedin = Setting::get('social_linkedin', '');
        $this->social_youtube = Setting::get('social_youtube', '');

        // Branding Settings
        $this->site_name = Setting::get('site_name', '');
        $this->site_tagline = Setting::get('site_tagline', '');
        $this->existing_logo = Setting::get('site_logo', '');
        $this->existing_favicon = Setting::get('site_favicon', '');

        // Hero Section Settings
        $this->hero_title = Setting::get('hero_title', '');
        $this->hero_subtitle = Setting::get('hero_subtitle', '');
        $this->hero_cta_text = Setting::get('hero_cta_text', '');
        $this->hero_cta_url = Setting::get('hero_cta_url', '');
        $this->existing_background_image = Setting::get('hero.background_image', '');
        $this->text_alignment = Setting::get('hero.text_alignment', 'center');
        $this->existing_industry_image = Setting::get('hero.industry_image', '');

        // Booking Notifications Settings
        $this->booking_email_notifications = Setting::get('booking_email_notifications', true);
        $this->booking_sms_notifications = Setting::get('booking_sms_notifications', false);
        $this->booking_notification_email = Setting::get('booking_notification_email', '');
    }

    protected function rules()
    {
        return [
            // Contact
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'contact_working_hours' => 'nullable|string|max:255',
            
            // Social
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            
            // Branding
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:512',
            
            // Hero
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:1000',
            'hero_cta_text' => 'nullable|string|max:100',
            'hero_cta_url' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|max:4096',
            'text_alignment' => 'nullable|in:left,center,right',
            'industry_image' => 'nullable|image|max:4096',
            
            // Booking Notifications
            'booking_email_notifications' => 'boolean',
            'booking_sms_notifications' => 'boolean',
            'booking_notification_email' => 'nullable|email|max:255',
        ];
    }

    public function removeLogo()
    {
        $this->site_logo = null;
        $this->existing_logo = '';
    }

    public function removeFavicon()
    {
        $this->site_favicon = null;
        $this->existing_favicon = '';
    }

    public function saveContact()
    {
        $this->validate([
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'contact_working_hours' => 'nullable|string|max:255',
        ]);

        Setting::set('contact_email', $this->contact_email);
        Setting::set('contact_phone', $this->contact_phone);
        Setting::set('contact_address', $this->contact_address);
        Setting::set('contact_working_hours', $this->contact_working_hours);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Contact settings saved successfully'
        ]);
    }

    public function saveSocial()
    {
        $this->validate([
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ]);

        Setting::set('social_facebook', $this->social_facebook);
        Setting::set('social_twitter', $this->social_twitter);
        Setting::set('social_instagram', $this->social_instagram);
        Setting::set('social_linkedin', $this->social_linkedin);
        Setting::set('social_youtube', $this->social_youtube);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Social media settings saved successfully'
        ]);
    }

    public function saveBranding()
    {
        $this->validate([
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:512',
        ]);

        Setting::set('site_name', $this->site_name);
        Setting::set('site_tagline', $this->site_tagline);

        // Handle logo upload
        if ($this->site_logo) {
            $logoPath = $this->site_logo->store('branding', 'public');
            Setting::set('site_logo', $logoPath);
            $this->existing_logo = $logoPath;
            
            // Delete old logo if exists
            if ($this->existing_logo && Storage::disk('public')->exists($this->existing_logo)) {
                Storage::disk('public')->delete($this->existing_logo);
            }
        } elseif ($this->existing_logo) {
            Setting::set('site_logo', $this->existing_logo);
        }

        // Handle favicon upload
        if ($this->site_favicon) {
            $faviconPath = $this->site_favicon->store('branding', 'public');
            Setting::set('site_favicon', $faviconPath);
            $this->existing_favicon = $faviconPath;
            
            // Delete old favicon if exists
            if ($this->existing_favicon && Storage::disk('public')->exists($this->existing_favicon)) {
                Storage::disk('public')->delete($this->existing_favicon);
            }
        } elseif ($this->existing_favicon) {
            Setting::set('site_favicon', $this->existing_favicon);
        }

        $this->site_logo = null;
        $this->site_favicon = null;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Branding settings saved successfully'
        ]);
    }

    public function saveHero()
    {
        $this->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:1000',
            'hero_cta_text' => 'nullable|string|max:100',
            'hero_cta_url' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|max:4096',
            'text_alignment' => 'nullable|in:left,center,right',
            'industry_image' => 'nullable|image|max:4096',
        ]);

        Setting::set('hero_title', $this->hero_title);
        Setting::set('hero_subtitle', $this->hero_subtitle);
        Setting::set('hero_cta_text', $this->hero_cta_text);
        Setting::set('hero_cta_url', $this->hero_cta_url);
        Setting::set('hero.text_alignment', $this->text_alignment);

        // Handle background image upload
        if ($this->background_image) {
            $bgPath = $this->background_image->store('hero', 'public');
            Setting::set('hero.background_image', $bgPath);
            $this->existing_background_image = $bgPath;
            $this->background_image = null;
        }

        // Handle industry page image upload
        if ($this->industry_image) {
            $industryPath = $this->industry_image->store('hero', 'public');
            Setting::set('hero.industry_image', $industryPath);
            $this->existing_industry_image = $industryPath;
            $this->industry_image = null;
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Hero section settings saved successfully'
        ]);
    }

    public function saveBookingNotifications()
    {
        $this->validate([
            'booking_email_notifications' => 'boolean',
            'booking_sms_notifications' => 'boolean',
            'booking_notification_email' => 'nullable|email|max:255',
        ]);

        Setting::set('booking_email_notifications', $this->booking_email_notifications);
        Setting::set('booking_sms_notifications', $this->booking_sms_notifications);
        Setting::set('booking_notification_email', $this->booking_notification_email);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Booking notification settings saved successfully'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-form');
    }
}
