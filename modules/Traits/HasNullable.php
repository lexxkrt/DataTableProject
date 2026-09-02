<?php

namespace Modules\Traits;

trait HasNullable
{
    protected static function bootHasNullable()
    {
        static::saved(function ($model) {
            foreach ($model->nullable ?? [] as $field) {
                empty($model->{$field}) and $model->{$field} = null;
            }
        });
    }
}
