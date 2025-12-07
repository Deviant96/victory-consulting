<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class BusinessSolution extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'order',
        'is_active'
    ];

    /**
     * Fields that can be translated via the content translations table.
     */
    protected array $translatable = [
        'title',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the sub-solutions for this business solution.
     */
    public function subSolutions()
    {
        return $this->hasMany(SubSolution::class);
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
