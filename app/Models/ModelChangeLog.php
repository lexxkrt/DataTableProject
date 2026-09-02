<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['model_type', 'model_id', 'user_id', 'username', 'ip', 'user_agent', 'action', 'changes'])]
class ModelChangeLog extends Model
{
    protected function casts(): array
    {
        return [
            'changes' => 'array',
        ];
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
