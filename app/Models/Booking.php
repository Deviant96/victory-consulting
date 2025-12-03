<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_interest',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public const STATUSES = [
        'pending',
        'confirmed',
        'rescheduled',
        'completed',
        'cancelled',
    ];
}
