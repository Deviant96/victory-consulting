<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HasTranslations;

class BlogPost extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'author',
        'tags',
        'published',
        'published_at',
    ];

    protected array $translatable = [
        'title',
        'excerpt',
        'content',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
