<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'group',
    ];

    public function values()
    {
        return $this->hasMany(TranslationValue::class);
    }

    public function valueForLocale(string $locale): ?string
    {
        return optional($this->values->firstWhere('language_code', $locale))->value;
    }
}
