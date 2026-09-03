<?php

namespace App\Pages\Admin;

use App\Models\ModelChangeLog;
use Modules\DataTable\Classes\Actions\Action;
use Modules\DataTable\Classes\Columns\Column;
use Modules\DataTable\Classes\Filters\Filter;
use Modules\DataTable\DataTable;

class ModelChangeLogPage extends DataTable
{
    protected string $class = ModelChangeLog::class;

    public string $sortField = 'updated_at';

    public string $sortDirection = 'desc';

    public function columns(): array
    {
        return [
            Column::make('model_type'),
            Column::make('model_id')->searchable(),
            Column::make('user_id')->searchable(),
            Column::make('username')->searchable(),
            Column::make('ip')->searchable()->hidden(),
            Column::make('user_agent')->hidden(),
            Column::make('action'),
            Column::make('changes')->searchable()->width('w-28'),
            Column::make('created_at')->hidden(),
            Column::make('updated_at')->width('w-28')->sortable(),
        ];
    }

    public function actions(): array
    {
        return [
            Action::make('view'),
        ];
    }

    public function filters(): array
    {
        $model_type = ModelChangeLog::pluck('model_type')->unique()->mapWithKeys(fn ($item) => [$item => $item]);
        $actions = ModelChangeLog::pluck('action')->unique()->mapWithKeys(fn ($item) => [$item => $item]);

        return [
            Filter::make('model_type')->options($model_type->toArray()),
            Filter::make('action')->options($actions->toArray()),
        ];
    }
}
