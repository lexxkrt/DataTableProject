<?php

namespace Modules\Traits;

trait HasCache{
    public static function bootHasCache(){
        static::saved(function($model){
            $model->flushCache();
        });
    }
}
    