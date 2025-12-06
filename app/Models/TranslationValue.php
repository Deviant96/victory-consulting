<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'translation_key_id',
        'language_code',
        'value',
    ];

    public function translationKey()
    {
        return $this->belongsTo(TranslationKey::class);
    }
}
