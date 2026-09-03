<?php

namespace Modules\DataTable;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Modules\DataTable\Classes\Actions\Action;
use Modules\DataTable\Classes\Columns\Column;
use Modules\DataTable\Classes\Fields\Field;
use Modules\DataTable\Classes\Layouts\Tabs;

class DataTable extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected string $class = Model::class;

    public string $sortField = 'id';

    public string $sortDirection = 'asc';

    protected bool $withoutPagination = false;

    public int $perPage = 10;

    public string $search = '';

    public array $filters = [];

    /* form */
    public ?Model $model = null;

    public array $formData = [];

    public array $formUploads = [];

    public bool $formShow = false;

    public string $formSize = 'max-w-md';
    /* end form */

    public function title(): string
    {
        return str(app($this->class)->getTable())->replace('_', ' ')->title();
    }

    public function formTitle(): string
    {
        return $this->model ? __('Edit') : __('Create');
    }

    public function columns(): array
    {
        $props = app($this->class)->getFillable();
        $columns = Arr::map($props, fn ($value) => Column::make($value));

        return $columns;
    }

    public function fields(): array
    {
        $pros = app($this->class)->getFillable();
        $fields = Arr::map($pros, fn ($value) => Field::make($value));

        return $fields;
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            Action::make('edit'),
            Action::make('delete')->confirm(),
        ];
    }

    public function query(): Builder
    {
        return app($this->class)->query();
    }

    private function getRelationTable(string $relation): string
    {
        return app($this->class)->{$relation}()->getRelated()->getTable();
    }

    private function getTable(): string
    {
        return app($this->class)->getTable();
    }

    private function getFieldName(string $field): string
    {
        if (str_contains($field, '.')) {
            [$relation, $fieldName] = explode('.', $field);

            return $this->getRelationTable($relation).'.'.$fieldName;
        } else {
            return $this->getTable().'.'.$field;
        }
    }

    #[Computed]
    public function data()
    {
        $query = $this->query();
        $query->select($this->getTable().'.*');

        $related = collect($this->columns())->where(fn ($field) => str_contains($field->name, '.'))->pluck('name')->toArray();
        $relations = array_values(array_unique(Arr::map($related, fn ($field) => explode('.', $field)[0])));
        Arr::map($relations, function ($relation) use ($query) {
            $relation = app($this->class)->{$relation}();
            $foreignKey = $relation->getForeignKeyName();
            $related = $relation->getRelated();
            $primaryKey = $related->getKeyName();
            $related_table = $related->getTable();
            $query->leftJoin($related_table, $related_table.'.'.$primaryKey, $this->getTable().'.'.$foreignKey);
        });

        if ($this->search) {
            $searchable = collect($this->columns())->where('searchable', true)->pluck('name')->toArray();
            $fields = Arr::map($searchable, fn ($field) => $this->getFieldName($field));
            $query->whereAny($fields, 'like', '%'.$this->search.'%');
        }

        $query->where(Arr::where($this->filters, fn ($value) => $value !== ''));

        $field = collect($this->columns())->where('sortable', true)->firstWhere('name', $this->sortField);
        if ($field) {
            $query->orderBy($this->getFieldName($field->name), $this->sortDirection);
        }
        // $query->dumpRawSql();

        if ($this->withoutPagination) {
            return $query->get();
        } else {
            return $query->paginate($this->perPage);
        }
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortField = $field;
        }

        $this->resetPage();
    }

    public function rowAction(string $name, string $key)
    {
        // $this->authorize('update');
        $action = collect($this->actions())->firstWhere('name', $name);
        if ($action) {
            if ($action->action instanceof Closure) {
                $row = $this->query()->find($key);
                value($action->action, $row);
            } else {
                if (method_exists($this, $action->name)) {
                    call_user_func([$this, $action->name], $key);
                }
            }
        }
    }

    public function columnAction(string $name, string $key)
    {
        // $this->authorize('update');
        $column = collect($this->columns())->firstWhere('name', $name);
        if ($column) {
            if ($column->action instanceof Closure) {
                $row = $this->query()->find($key);
                value($column->action, $row);
            }
        }
    }

    public function updated(string $property)
    {
        if (! str($property)->startsWith(['form'])) {
            $this->resetPage();
        }
    }

    public function create()
    {
        // $this->authorize('create');
        $this->model = $this->query()->make();
        $this->formOpen();
    }

    public function edit(string $key)
    {
        // $this->authorize('update');
        $this->model = $this->query()->find($key);
        $this->formOpen();
    }

    public function delete(string $key)
    {
        // $this->authorize('delete');
        /** @var Model $row */
        $row = $this->query()->find($key);
        $row->delete();
    }

    private function getFields(array $fields)
    {
        $results = [];
        foreach ($fields as $field) {
            if ($field instanceof Field) {
                $results[$field->name] = $field;
            } elseif ($field instanceof Tabs) {
                foreach ($field->tabs as $tab) {
                    if (isset($tab->fields)) {
                        $results += $this->getFields($tab->fields);
                    }
                }
            } elseif (isset($field->fields)) {
                $results += $this->getFields($field->fields);
            }
        }

        return $results;
    }

    public function store()
    {
        $this->resetValidation();
        $fields = $this->getFields($this->fields());
        $inputs = collect($fields)->filter(fn ($field) => $field->type != 'file');
        $files = collect($fields)->filter(fn ($field) => $field->type == 'file');

        $rules = collect($fields)->mapWithKeys(fn ($field) => [$field->key => $field->rules])->toArray();
        // $messages = collect($fields)->mapWithKeys(fn ($field) => [$field->key => $field->messages])->toArray();
        $attributes = collect($fields)->mapWithKeys(fn ($field) => [$field->key => trans($field->label)])->toArray();

        $validated = $this->validate($rules, [], $attributes);

        $formData = Arr::only($validated['formData'], $inputs->keys()->toArray());

        $table = app($this->class)->getTable();

        $files->each(function ($field) use (&$formData, $table) {
            Arr::has($this->formData, $field->name) && blank($this->formData[$field->name]) and $formData[$field->name] = null;
            Arr::has($this->formUploads, $field->name) and $formData[$field->name] = $this->formUploads[$field->name]->store($table, 'local');
        });

        $this->model->updateOrCreate([$this->model->getKeyName() => $this->model->getKey()], $formData);

        $this->formClose();
    }

    /* form methods */

    #[On('formOpen')]
    public function formOpen()
    {
        $this->formData = $this->model->toArray();
        $this->formShow = true;
    }

    #[On('formClose')]
    public function formClose()
    {
        $this->resetValidation();
        $this->reset(['formData', 'formUploads', 'formShow', 'model']);
    }

    public function formImageUrl(string $field)
    {
        if (Arr::has($this->formUploads, $field)) {
            return $this->formUploads[$field]->temporaryUrl();
        } else {
            return $this->model?->getImage();
        }
    }

    public function formImageRemove(string $field)
    {
        unset($this->formUploads[$field]);
        $this->formData[$field] = null;
        $this->model->{$field} = null;
    }

    /* end form methods */

    // public function paginationView()
    // {
    //     return 'data-table::pagination';
    // }

    #[Layout('layouts::admin')]
    public function render()
    {
        return view('data-table::data-table');
    }
}
