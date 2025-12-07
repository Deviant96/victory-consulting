<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Faq extends Model
{
    use HasTranslations;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'order',
        'published',
    ];

    /**
     * Fields that can be translated via the content translations table.
     */
    protected array $translatable = [
        'question',
        'answer',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
