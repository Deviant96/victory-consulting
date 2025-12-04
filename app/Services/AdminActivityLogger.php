<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AdminActivityLogger
{
    public static function log(string $action, ?Model $subject = null, ?string $description = null): AdminActivityLog
    {
        $user = Auth::user();

        return AdminActivityLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'description' => $description,
        ]);
    }
}
