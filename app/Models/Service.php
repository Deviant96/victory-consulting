<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Traits\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'category_id',
        'price_note',
        'featured_image',
        'published',
    ];

    protected array $translatable = [
        'title',
        'summary',
        'description',
        'price_note',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(ServiceHighlight::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
