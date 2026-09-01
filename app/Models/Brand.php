<?php

namespace App\Models;

use Database\Factories\BrandFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Traits\HasImage;
use Modules\Traits\HasSlug;
use Modules\Traits\HasUuid;

#[Fillable(['name', 'slug', 'image', 'position', 'status'])]
class Brand extends Model
{
    /** @use HasFactory<BrandFactory> */
    use HasFactory;

    use HasImage;
    use HasSlug;
    use HasUuid;

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $attributes = [
        'position' => 100,
        'status' => true,
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function imageSize()
    {
        return [300, 300];
    }
}
