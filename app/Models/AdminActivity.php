<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AdminActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public static function record(string $action, ?Model $subject = null, ?string $description = null, ?array $changes = null): self
    {
        return static::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'changes' => empty($changes) ? null : $changes,
        ]);
    }

    public static function diffFor(Model $model, array $original, array $ignore = ['updated_at', 'created_at', 'id']): array
    {
        return collect($model->getChanges())
            ->except($ignore)
            ->mapWithKeys(function ($value, $key) use ($original) {
                return [
                    $key => [
                        'from' => $original[$key] ?? null,
                        'to' => $value,
                    ],
                ];
            })
            ->toArray();
    }

    public static function snapshotFor(Model $model, array $ignore = ['created_at', 'updated_at', 'id']): array
    {
        return collect($model->getAttributes())
            ->except($ignore)
            ->map(fn ($value) => [
                'from' => null,
                'to' => $value,
            ])
            ->toArray();
    }
}
