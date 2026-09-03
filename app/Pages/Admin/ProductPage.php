<?php

namespace App\Pages\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
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
use Modules\DataTable\Classes\Layouts\Tab;
use Modules\DataTable\Classes\Layouts\Tabs;
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
            // ColumnImage::make('image')->width('w-12')->center()->value(fn (Model $row) => $row->getImage()),
            Column::make('name')->sortable()->searchable()->view('columns.name-with-image-and-description'),
            // Column::make('description')->sortable()->searchable(),
            // Column::make('slug')->sortable()->searchable(),
            Column::make('brand.name', 'Brand')->sortable()->searchable(),
            // Column::make('brand.slug', 'Brand slug')->sortable()->searchable(),
            Column::make('category.name', 'Category')->sortable()->searchable(),
            // Column::make('category.slug', 'Category slug')->sortable()->searchable(),
            Column::make('quantity')->width('w-20')->center()->sortable()->searchable(),
            Column::make('price')->width('w-20')->center()->sortable()->searchable(),
            Column::make('position')->width('w-20')->center()->sortable()->searchable(),
            ColumnToggle::make('status')->width('w-30')->center()->sortable()->toggle(),
        ];
    }

    public function fields(): array
    {
        return [
            Tabs::make()->tabs([
                Tab::make('General')->fields([
                    Flex::make()->fields([
                        Section::make()->fields([
                            FieldImage::make('image'),
                        ])->css('shrink-0')->bordered(),
                        Section::make()->fields([
                            Field::make('name'),
                            // Field::make('slug'),
                            Grid::make()->fields([
                                Field::make('quantity'),
                                Field::make('price'),
                            ]),
                            Grid::make()->fields([
                                Field::make('position'),
                            ]),
                            FieldToggle::make('status'),
                        ])->css('grow')->bordered(),
                    ]),
                ]),
                Tab::make('Images')->fields([
                    Section::make()->fields([
                        FieldSelect::make('brand_id', 'Brand')->options($this->getBrands()),
                        FieldSelect::make('category_id', 'Category')->options($this->getCategories()),
                    ])->bordered(),
                ]),
            ]),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::make('status')->options(['1' => 'Enabled', '0' => 'Disabled']),
            Filter::make('category_id', 'Category')->options($this->getCategories()),
            Filter::make('brand_id', 'Brand')->options($this->getBrands()),
        ];
    }

    private function getBrands()
    {
        static $brands;
        empty($brands) and $brands = Brand::orderBy('name')->pluck('name', 'id')->toArray();

        return $brands;
    }

    private function getCategories()
    {
        static $categories;
        empty($categories) and $categories = Cache::remember('categories', 60, fn () => Category::orderBy('name')->pluck('name', 'id')->toArray());

        return $categories;
    }
}
