<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    
    public function translations()
    {
        return $this->morphMany(\App\Models\ContentTranslation::class, 'model');
    }
    
    public function setTranslation(string $field, string $locale, $value): void
    {
        $this->translations()
            ->updateOrCreate(
                [
                    'field' => $field,
                    'language_code' => $locale,
                ],
                ['value' => $value]
            );
    }

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
