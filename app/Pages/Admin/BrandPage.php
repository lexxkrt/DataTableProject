<?php

namespace App\Pages\Admin;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Modules\DataTable\Classes\Columns\Column;
use Modules\DataTable\Classes\Columns\ColumnImage;
use Modules\DataTable\Classes\Columns\ColumnStatus;
use Modules\DataTable\DataTable;

class BrandPage extends DataTable
{
    protected $class = Brand::class;

    public $sortField = 'name';

    public function columns(): array
    {
        return [
            Column::make('id')->width('w-12')->center()->sortable()->searchable()->hidden(),
            ColumnImage::make('image')->width('w-12')->center(),
            Column::make('name')->sortable()->searchable(),
            Column::make('slug')->sortable()->searchable(),
            Column::make('position')->width('w-20')->center()->sortable()->searchable(),
            ColumnStatus::make('status')->width('w-30')->center()->sortable()
                ->action(fn (Model $row) => $row->update(['status' => ! $row->status])),
        ];
    }

    public function filters(): array
    {
        return [];
    }
}
