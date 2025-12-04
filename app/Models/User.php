<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PushSubscription;
use App\Models\AdminActivityLog;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pushSubscriptions(): HasMany
    {
        return $this->hasMany(PushSubscription::class);
    }

    public function updatePushSubscription(
        string $endpoint,
        string $publicKey,
        string $authToken,
        ?string $contentEncoding = null,
        ?string $expirationTime = null
    ): void {
        $this->pushSubscriptions()->updateOrCreate(
            ['endpoint' => $endpoint],
            [
                'public_key' => $publicKey,
                'auth_token' => $authToken,
                'content_encoding' => $contentEncoding ?? 'aesgcm',
                'expiration_time' => $expirationTime,
            ]
        );
    }

    public function deletePushSubscription(string $endpoint): void
    {
        $this->pushSubscriptions()->where('endpoint', $endpoint)->delete();
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(AdminActivityLog::class);
    }
}
