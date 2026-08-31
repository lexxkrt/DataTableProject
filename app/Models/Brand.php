<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Traits\HasSlug;
use Modules\Traits\HasUuid;

#[Fillable(['name', 'slug', 'image', 'position', 'status'])]
class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;
    use HasSlug;
    use HasUuid;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
