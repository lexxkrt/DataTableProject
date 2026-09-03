<?php

namespace Modules\Traits;

use App\Models\ModelChangeLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ModelChangeLogger
{
    public static function bootModelChangeLogger()
    {
        static::created(function (Model $model) {
            $model->logChanges($model->getAttributes(), 'created');
        });
        static::updated(function (Model $model) {
            $originalAttributes = $model->getOriginal();
            $updatedAttributes = $model->getAttributes();
            $changedAttributes = array_diff_assoc($updatedAttributes, $originalAttributes);

            unset($changedAttributes['updated_at']);

            if (empty($changedAttributes)) {
                return;
            }

            $changes = [];
            foreach ($changedAttributes as $key => $value) {
                $changes[$key] = [
                    'old_value' => $originalAttributes[$key] ?? null,
                    'new_value' => $value,
                ];
            }

            $model->logChanges($changes, 'updated');
        });
        static::deleted(function (Model $model) {
            $model->logChanges($model->getAttributes(), 'deleted');
        });
    }

    public function changeLogs(): MorphMany
    {
        return $this->morphMany(ModelChangeLog::class, 'model')->latest();
    }

    public function logChanges(array $changes, string $action)
    {
        ModelChangeLog::create([
            'model_id' => $this->getKey(),
            'model_type' => get_class($this),
            'changes' => $changes,
            'user_id' => auth()?->id() ?? null,
            'username' => auth()?->user()?->name ?? null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'action' => $action,
        ]);
    }
}
