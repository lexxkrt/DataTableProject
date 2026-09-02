<?php

namespace App\Pages\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\DataTable\Classes\Columns\Column;
use Modules\DataTable\Classes\Columns\ColumnImage;
use Modules\DataTable\Classes\Columns\ColumnToggle;
use Modules\DataTable\Classes\Fields\Field;
use Modules\DataTable\Classes\Fields\FieldImage;
use Modules\DataTable\Classes\Fields\FieldSelect;
use Modules\DataTable\Classes\Fields\FieldToggle;
use Modules\DataTable\Classes\Filters\Filter;
use Modules\DataTable\Classes\Layouts\Flex;
use Modules\DataTable\Classes\Layouts\Grid;
use Modules\DataTable\Classes\Layouts\Section;
use Modules\DataTable\DataTable;

class ProductPage extends DataTable
{
    protected string $class = Product::class;

    public string $sortField = 'name';

    public string $formSize = 'max-w-xl';

    public function columns(): array
    {
        return [
            Column::make('id')->width('w-12')->center()->sortable()->searchable()->hidden(),
            ColumnImage::make('image')->width('w-12')->center()->value(fn (Model $row) => $row->getImage()),
            Column::make('name')->sortable()->searchable(),
            // Column::make('slug')->sortable()->searchable(),
            Column::make('brand.name', 'Brand')->sortable()->searchable(),
            Column::make('brand.slug', 'Brand slug')->sortable()->searchable(),
            Column::make('category.name', 'Category')->sortable()->searchable(),
            Column::make('category.slug', 'Category slug')->sortable()->searchable(),
            Column::make('quantity')->width('w-20')->center()->sortable()->searchable(),
            Column::make('price')->width('w-20')->center()->sortable()->searchable(),
            Column::make('position')->width('w-20')->center()->sortable()->searchable(),
            ColumnToggle::make('status')->width('w-30')->center()->sortable()->toggle(),
        ];
    }

    public function fields(): array
    {
        return [
            Flex::make()->fields([
                Section::make()->fields([
                    FieldImage::make('image'),
                ])->css('shrink-0')->bordered(),
                Section::make()->fields([
                    Field::make('name'),
                    // Field::make('slug'),
                    Section::make()->fields([
                        FieldSelect::make('brand_id', 'Brand')->options(Brand::orderBy('name')->pluck('name', 'id')->toArray()),
                        FieldSelect::make('category_id', 'Category')->options(Category::orderBy('name')->pluck('name', 'id')->toArray()),
                    ])->bordered(),
                    Section::make()->fields([
                        Field::make('quantity'),
                        Field::make('price'),
                    ])->bordered(),
                    Grid::make()->fields([
                        Field::make('position'),
                    ]),
                    FieldToggle::make('status'),
                ])->css('grow')->bordered(),
            ]),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::make('status')->options(['1' => 'Enabled', '0' => 'Disabled']),
            Filter::make('category_id', 'Category')->options(Category::orderBy('name')->pluck('name', 'id')->toArray()),
            Filter::make('brand_id', 'Brand')->options(Brand::orderBy('name')->pluck('name', 'id')->toArray()),
        ];
    }
}
