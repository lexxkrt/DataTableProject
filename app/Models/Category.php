<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Traits\HasImage;
use Modules\Traits\HasSlug;
use Modules\Traits\HasUuid;

#[Fillable(['name', 'slug', 'image', 'parent_id', 'position', 'status'])]
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
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

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
