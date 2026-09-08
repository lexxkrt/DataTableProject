<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Traits\ModelChangeLogger;

#[Fillable(['value', 'position'])]
class ProductProperty extends Pivot
{
    use ModelChangeLogger;

    protected $table = 'product_property';

    protected $primaryKey = ['product_id', 'property_id'];

    public $incrementing = false;

    public $timestamps = false;
}
