<?php

namespace Modules\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::saving(function (Model $model) {
            $model->generateSlugOnCreateOrUpdate();
        });
    }

    protected function generateSlugOnCreateOrUpdate()
    {
        if (! $this->isDirty($this->slugSource()) && ! empty($this->slug)) {
            return;
        }

        $base = $this->{$this->slugSource()};

        $slug = Str::slug($base);

        $originalSlug = $slug;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($this->exists, function ($query) {
                    $query->where($this->getKeyName(), '!=', $this->getKey());
                })
                ->exists()
        ) {
            $slug = $originalSlug.'-'.$i++;
        }
        $this->slug = $slug;
    }

    protected function slugSource()
    {
        return 'name';
    }
}
