<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\HasTranslations;

class WhyChooseItem extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'order',
        'is_active'
    ];

    protected array $translatable = [
        'title',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function getIconIsImageAttribute(): bool
    {
        if (!$this->icon) {
            return false;
        }

        $path = parse_url($this->icon, PHP_URL_PATH) ?? $this->icon;
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($extension, ['jpg', 'jpeg', 'png', 'svg'], true);
    }

    public function getIconUrlAttribute(): ?string
    {
        if (!$this->icon) {
            return null;
        }

        if (Str::startsWith($this->icon, ['http://', 'https://'])) {
            return $this->icon;
        }

        if (Str::startsWith($this->icon, ['/storage/', 'storage/'])) {
            return asset(ltrim($this->icon, '/'));
        }

        return Storage::disk('public')->url($this->icon);
    }

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order items by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
