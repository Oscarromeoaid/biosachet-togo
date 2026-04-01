<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public function log(string $section, string $action, string $description, ?Model $subject = null, array $properties = []): void
    {
        ActivityLog::query()->create([
            'user_id' => Auth::id(),
            'section' => $section,
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'properties' => $properties ?: null,
        ]);
    }
}
