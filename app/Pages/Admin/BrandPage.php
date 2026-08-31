<?php

namespace App\Pages\Admin;

use App\Models\Brand;
use Modules\DataTable\Classes\Columns\Column;
use Modules\DataTable\Classes\Columns\ColumnImage;
use Modules\DataTable\DataTable;

class BrandPage extends DataTable
{
    protected $class = Brand::class;

    public function columns(): array
    {
        return [
            Column::make('id')->width('w-12')->center(),
            ColumnImage::make('image')->width('w-12')->center(),
            Column::make('name'),
            Column::make('slug'),
            Column::make('position')->width('w-20')->center(),
            Column::make('status')->width('w-20')->center(),
        ];
    }
}
