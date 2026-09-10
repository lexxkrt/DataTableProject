<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProperty extends Pivot
{
    /** @use HasFactory<\Database\Factories\CategoryPropertyFactory> */
    use HasFactory;
}
