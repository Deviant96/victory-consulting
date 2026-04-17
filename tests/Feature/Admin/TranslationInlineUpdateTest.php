<?php

namespace Tests\Feature\Admin;

use App\Models\Language;
use App\Models\TranslationKey;
use App\Models\TranslationValue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslationInlineUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_inline_update_preserves_other_language_values(): void
    {
        Language::create(['code' => 'en', 'label' => 'English', 'is_active' => true]);
        Language::create(['code' => 'id', 'label' => 'Indonesian', 'is_active' => true]);

        $translationKey = TranslationKey::create([
            'key' => 'home.hero.title',
            'group' => 'home',
        ]);

        TranslationValue::create([
            'translation_key_id' => $translationKey->id,
            'language_code' => 'en',
            'value' => 'Welcome',
        ]);

        TranslationValue::create([
            'translation_key_id' => $translationKey->id,
            'language_code' => 'id',
            'value' => 'Selamat datang',
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->putJson(route('admin.translations.inline', $translationKey), [
            'language_code' => 'en',
            'value' => 'Welcome back',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('translation_values', [
            'translation_key_id' => $translationKey->id,
            'language_code' => 'en',
            'value' => 'Welcome back',
        ]);

        $this->assertDatabaseHas('translation_values', [
            'translation_key_id' => $translationKey->id,
            'language_code' => 'id',
            'value' => 'Selamat datang',
        ]);
    }
}
