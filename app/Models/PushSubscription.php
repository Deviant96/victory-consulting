<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PushSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'endpoint',
        'public_key',
        'auth_token',
        'content_encoding',
        'expiration_time',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
