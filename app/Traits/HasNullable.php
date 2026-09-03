<?php
namespace App\Traits;

trait HasNullable
{
    protected static function bootHasNullable()
    {
        static::saving(function ($model) {
            self::setNullables($model);
        });
    }

    protected static function setNullables($model)
    {
        foreach ($model->nullable ?? [] as $field) {
            empty($model->{$field}) and $model->{$field} = null;
        }
    }
}
