<?php

namespace Modules\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait HasLog
{
    public static function bootHasLog()
    {
        static::created(function (Model $model) {
            Log::info(get_class($model).' created ["'.$model->getKeyName().'": "'.$model->getKey().'"]', $model->toArray());
        });
        static::updated(function (Model $model) {
            if ($model->isDirty()) {
                Log::info(get_class($model).' updated (new) ["'.$model->getKeyName().'": "'.$model->getKey().'"]', $model->getDirty());
                Log::info(get_class($model).' updated (old) ["'.$model->getKeyName().'": "'.$model->getKey().'"]', Arr::only($model->getOriginal(), array_keys($model->getDirty())));
            }
        });
    }
}
