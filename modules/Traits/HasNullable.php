<?php

namespace Modules\Traits;

trait HasNullable
{
    protected static function bootHasNullable()
    {
        static::saving(function ($model) {
            foreach ($model->nullable ?? [] as $field) {
                empty($model->{$field}) and $model->{$field} = null;
            }
        });
    }
}
