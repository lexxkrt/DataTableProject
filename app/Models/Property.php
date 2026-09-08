<?php

namespace App\Models;

use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Traits\HasUuid;

#[Fillable(['name'])]
class Property extends Model
{
    /** @use HasFactory<PropertyFactory> */
    use HasFactory;

    use HasUuid;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_property')
            ->withPivot(['value', 'position']);
    }
}
