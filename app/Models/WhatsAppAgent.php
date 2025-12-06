<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppAgent extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_agents';

    protected $fillable = [
        'name',
        'phone_number',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get active agents ordered by order column
     */
    public static function getActiveAgents()
    {
        return self::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get formatted WhatsApp URL
     */
    public function getWhatsAppUrlAttribute()
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone_number);
        return "https://wa.me/{$phone}";
    }
}
