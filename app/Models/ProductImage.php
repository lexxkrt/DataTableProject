<?php

namespace App\Models;

use App\Traits\HasNullable;
use Database\Factories\ProductImageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Traits\HasImage;
use Modules\Traits\ModelChangeLogger;

#[Fillable(['product_id', 'image', 'position'])]
class ProductImage extends Model
{
    /** @use HasFactory<ProductImageFactory> */
    use HasFactory;

    use HasImage;
    use HasNullable;
    use ModelChangeLogger;

    protected $nullable = ['image'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
