<?php

namespace App\Traits;

use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;

trait LogsAdminActivity
{
    protected function logAdminActivity(string $action, $model = null, ?string $description = null): void
    {
        if (!Auth::check()) {
            return;
        }

        AdminLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->getKey(),
            'description' => $description,
        ]);
    }
}
