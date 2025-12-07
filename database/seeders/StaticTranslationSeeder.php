<?php

namespace Database\Seeders;

use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Illuminate\Database\Seeder;

class StaticTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $fallbackLocale = config('app.fallback_locale', 'en');

        $translations = [
            ['group' => 'frontend.navigation', 'key' => 'home', 'value' => 'Home'],
            ['group' => 'frontend.navigation', 'key' => 'services', 'value' => 'Services'],
            ['group' => 'frontend.navigation', 'key' => 'industries', 'value' => 'Industries'],
            ['group' => 'frontend.navigation', 'key' => 'team', 'value' => 'Team'],
            ['group' => 'frontend.navigation', 'key' => 'blog', 'value' => 'Blog'],
            ['group' => 'frontend.navigation', 'key' => 'contact', 'value' => 'Contact'],
            ['group' => 'frontend.common', 'key' => 'learn_more', 'value' => 'Learn More'],
            ['group' => 'frontend.search', 'key' => 'placeholder', 'value' => 'Search services, people, articles'],
            ['group' => 'frontend.search', 'key' => 'title', 'value' => 'Search our site'],
            ['group' => 'frontend.search', 'key' => 'searching_for', 'value' => 'Searching for'],
            ['group' => 'frontend.search', 'key' => 'subtitle', 'value' => 'Services, team, articles, and contact info'],
            ['group' => 'frontend.search', 'key' => 'no_results', 'value' => 'No matches found. Try another term.'],
            ['group' => 'frontend.search', 'key' => 'loading', 'value' => 'Loading search index...'],
            ['group' => 'frontend.home', 'key' => 'hero_primary_cta', 'value' => 'Our Services'],
            ['group' => 'frontend.home', 'key' => 'hero_secondary_cta', 'value' => 'Get Started'],
            ['group' => 'frontend.home', 'key' => 'services_heading', 'value' => 'Our Services'],
            ['group' => 'frontend.home', 'key' => 'services_subheading', 'value' => 'Comprehensive business solutions tailored to your unique challenges'],
            ['group' => 'frontend.home', 'key' => 'why_choose_heading', 'value' => 'Why Choose Victory Business Consulting'],
            ['group' => 'frontend.home', 'key' => 'why_choose_subheading', 'value' => 'Discover what sets us apart and makes us the ideal partner for your business growth'],
            ['group' => 'frontend.home', 'key' => 'solutions_heading', 'value' => 'Whatever Your Business, We Can Handle It'],
            ['group' => 'frontend.home', 'key' => 'solutions_subheading', 'value' => 'From startups to enterprises, we provide tailored solutions for every industry and challenge'],
            ['group' => 'frontend.home', 'key' => 'blog_heading', 'value' => 'Latest Insights'],
            ['group' => 'frontend.home', 'key' => 'blog_subheading', 'value' => 'Expert perspectives on business strategy and growth.'],
            ['group' => 'frontend.home', 'key' => 'blog_cta', 'value' => 'Read More Articles'],
            ['group' => 'admin.actions', 'key' => 'add_translation_key', 'value' => 'Add Translation Key'],
            ['group' => 'admin.actions', 'key' => 'edit', 'value' => 'Edit'],
            ['group' => 'admin.common', 'key' => 'translations_header', 'value' => 'Manage static labels for admin and frontend.'],
            ['group' => 'admin.common', 'key' => 'no_translations', 'value' => 'No translation keys have been added yet.'],
            ['group' => 'frontend.services', 'key' => 'meta_title', 'value' => 'Our Services'],
            ['group' => 'frontend.services', 'key' => 'heading', 'value' => 'Our Services'],
            ['group' => 'frontend.services', 'key' => 'subheading', 'value' => 'Comprehensive business solutions designed to drive growth and operational excellence'],
            ['group' => 'frontend.services', 'key' => 'empty', 'value' => 'No services available at the moment.'],
            ['group' => 'frontend.services', 'key' => 'cta_heading', 'value' => 'We can tailor our services to meet your specific business needs'],
            ['group' => 'frontend.services', 'key' => 'cta_button', 'value' => 'Book Now'],
            ['group' => 'frontend.contact', 'key' => 'meta_title', 'value' => 'Contact Us'],
            ['group' => 'frontend.contact', 'key' => 'heading', 'value' => 'Contact Us'],
            ['group' => 'frontend.contact', 'key' => 'subheading', 'value' => 'Get in touch with our team to discuss how we can help your business thrive'],
            ['group' => 'frontend.contact', 'key' => 'phone_label', 'value' => 'Phone'],
            ['group' => 'frontend.contact', 'key' => 'phone_note', 'value' => 'Available on phone and WhatsApp'],
            ['group' => 'frontend.contact', 'key' => 'email_label', 'value' => 'Email'],
            ['group' => 'frontend.contact', 'key' => 'email_note', 'value' => 'We answer emails promptly'],
            ['group' => 'frontend.contact', 'key' => 'address_label', 'value' => 'Address'],
            ['group' => 'frontend.contact', 'key' => 'hours_label', 'value' => 'Business Hours'],
            ['group' => 'frontend.contact', 'key' => 'hours_weekday', 'value' => 'Monday - Friday:'],
            ['group' => 'frontend.contact', 'key' => 'hours_weekday_value', 'value' => '9:00 AM - 6:00 PM'],
            ['group' => 'frontend.contact', 'key' => 'hours_saturday', 'value' => 'Saturday:'],
            ['group' => 'frontend.contact', 'key' => 'hours_saturday_value', 'value' => '10:00 AM - 4:00 PM'],
            ['group' => 'frontend.contact', 'key' => 'hours_sunday', 'value' => 'Sunday:'],
            ['group' => 'frontend.contact', 'key' => 'hours_sunday_value', 'value' => 'Closed'],
            ['group' => 'frontend.contact', 'key' => 'follow_label', 'value' => 'Follow Us'],
            ['group' => 'frontend.booking', 'key' => 'badge', 'value' => 'Book a consultation'],
            ['group' => 'frontend.booking', 'key' => 'heading', 'value' => 'Reserve time with our team'],
            ['group' => 'frontend.booking', 'key' => 'subheading', 'value' => "Share a few details and we'll confirm the best time for you."],
            ['group' => 'frontend.booking', 'key' => 'name_label', 'value' => 'Full name *'],
            ['group' => 'frontend.booking', 'key' => 'email_label', 'value' => 'Work email *'],
            ['group' => 'frontend.booking', 'key' => 'phone_label', 'value' => 'Phone'],
            ['group' => 'frontend.booking', 'key' => 'company_label', 'value' => 'Company'],
            ['group' => 'frontend.booking', 'key' => 'service_label', 'value' => 'Service of interest'],
            ['group' => 'frontend.booking', 'key' => 'service_placeholder', 'value' => 'Select a service'],
            ['group' => 'frontend.booking', 'key' => 'no_services', 'value' => 'No services available'],
            ['group' => 'frontend.booking', 'key' => 'custom_option', 'value' => 'Custom'],
            ['group' => 'frontend.booking', 'key' => 'date_label', 'value' => 'Preferred date'],
            ['group' => 'frontend.booking', 'key' => 'time_label', 'value' => 'Preferred time'],
            ['group' => 'frontend.booking', 'key' => 'message_label', 'value' => 'Project goals'],
            ['group' => 'frontend.booking', 'key' => 'message_placeholder', 'value' => 'Tell us what success looks like'],
            ['group' => 'frontend.booking', 'key' => 'confirmation_note', 'value' => 'Instant confirmation & friendly reminders.'],
            ['group' => 'frontend.booking', 'key' => 'submit', 'value' => 'Confirm my consultation'],
        ];

        foreach ($translations as $item) {
            $translationKey = TranslationKey::firstOrCreate([
                'group' => $item['group'],
                'key' => $item['group'] . '.' . $item['key'],
            ]);

            TranslationValue::updateOrCreate(
                [
                    'translation_key_id' => $translationKey->id,
                    'language_code' => $fallbackLocale,
                ],
                [
                    'value' => $item['value'],
                ]
            );
        }
    }
}
