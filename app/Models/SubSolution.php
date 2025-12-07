<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SubSolution extends Model
{
    use HasTranslations;

    protected $fillable = [
        'business_solution_id',
        'title',
        'order',
        'is_active'
    ];

    /**
     * Fields that can be translated via the content translations table.
     */
    protected array $translatable = [
        'title',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the business solution that owns the sub-solution.
     */
    public function businessSolution()
    {
        return $this->belongsTo(BusinessSolution::class);
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
