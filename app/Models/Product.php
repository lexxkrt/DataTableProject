<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Traits\HasImage;
use Modules\Traits\HasSlug;
use Modules\Traits\HasUuid;

#[Fillable(['name', 'slug', 'image', 'description', 'brand_id', 'category_id', 'price', 'quantity', 'position', 'status'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use HasImage;
    use HasSlug;
    use HasUuid;

    protected $attributes = [
        'price' => 0,
        'quantity' => 0,
        'position' => 100,
        'status' => true,
    ];

    protected function casts(): array
    {
        return [
            'price' => MoneyCast::class,
            'status' => 'boolean',
        ];
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
