<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active mission.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
