<?php

namespace App\Casts;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ImageCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (empty($value)) {
            return null;
        }
        if (Str::startsWith($value, ['http', 'https'])) {
            return $value;
        }
        return Storage::url($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
