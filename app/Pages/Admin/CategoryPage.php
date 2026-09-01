<?php

namespace App\Pages\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Modules\DataTable\Classes\Columns\Column;
use Modules\DataTable\Classes\Columns\ColumnImage;
use Modules\DataTable\Classes\Columns\ColumnStatus;
use Modules\DataTable\Classes\Fields\Field;
use Modules\DataTable\Classes\Fields\FieldImage;
use Modules\DataTable\Classes\Fields\FieldSelect;
use Modules\DataTable\Classes\Filters\Filter;
use Modules\DataTable\Classes\Layouts\Flex;
use Modules\DataTable\Classes\Layouts\Grid;
use Modules\DataTable\Classes\Layouts\Section;
use Modules\DataTable\DataTable;

class CategoryPage extends DataTable
{
    protected string $class = Category::class;

    public string $sortField = 'name';

    public string $formSize = 'max-w-xl';

    public function columns(): array
    {
        return [
            Column::make('id')->width('w-12')->center()->sortable()->searchable()->hidden(),
            ColumnImage::make('image')->width('w-12')->center(),
            Column::make('name')->sortable()->searchable(),
            Column::make('slug')->sortable()->searchable(),
            Column::make('parent_id', 'Parent')->sortable()->searchable()->value(fn (Model $row) => $row->parent?->name),
            Column::make('position')->width('w-20')->center()->sortable()->searchable(),
            ColumnStatus::make('status')->width('w-30')->center()->sortable()
                ->action(fn (Model $row) => $row->update(['status' => ! $row->status])),
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
                    FieldSelect::make('parent_id', 'Parent')->options(Category::whereHas('children')->pluck('name', 'id')->toArray()),
                    // Field::make('slug'),
                    Grid::make()->fields([
                        Field::make('status'),
                        Field::make('position'),
                    ]),
                ])->css('grow')->bordered(),
            ]),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::make('status')->options(['1' => 'Enabled', '0' => 'Disabled']),
            Filter::make('parent_id', 'Parent')->options(Category::whereHas('children')->pluck('name', 'id')->toArray()),
        ];
    }
}
