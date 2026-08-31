<?php

namespace Modules\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasUuid
{
    public static function bootHasUuid()
    {
        static::saving(function (Model $model) {
            if (empty($model->{$model->getKeyUuid()})) {
                $model->{$model->getKeyUuid()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    protected function keyUuid(): string
    {
        return 'uuid';
    }

    public function getKeyUuid(): string
    {
        return $this->keyUuid();
    }
}
