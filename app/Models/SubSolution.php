<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSolution extends Model
{
    protected $fillable = [
        'business_solution_id',
        'title',
        'order',
        'is_active'
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
