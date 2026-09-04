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
use Modules\DataTable\Classes\Relations\Relation;

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

    public array $formRelations = [];

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

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortField = $field;
        }

        $this->resetPage();
    }

    public function rowAction(string $name, string $key): void
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

    public function columnAction(string $name, string $key): void
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

    public function updated(string $property): void
    {
        if (! str($property)->startsWith(['form'])) {
            $this->resetPage();
        }
    }

    public function create(): void
    {
        // $this->authorize('create');
        $this->model = $this->query()->make();
        $this->formOpen();
    }

    public function edit(string $key): void
    {
        // $this->authorize('update');
        $this->model = $this->query()->find($key);
        $this->formOpen();
    }

    public function delete(string $key): void
    {
        // $this->authorize('delete');
        /** @var Model $row */
        $row = $this->query()->find($key);
        $row->delete();
    }

    private function getRelations(array $fields): array
    {
        $results = [];
        foreach ($fields as $field) {
            if ($field instanceof Relation) {
                $results[$field->name] = $field;
            } elseif ($field instanceof Tabs) {
                foreach ($field->tabs as $tab) {
                    $results += $this->getRelations($tab->fields);
                }
            } elseif (isset($field->fields)) {
                $results += $this->getRelations($field->fields);
            }
        }

        return $results;
    }

    private function getFields(array $fields): array
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

        $relations = $this->getRelations($this->fields());

        foreach ($relations as $relation) {
            $data = $this->formRelations[$relation->name];
            $original = $this->model->{$relation->name}->toArray();

            // $ids_data = collect($data)->pluck('id');
            $ids_original = collect($original)->pluck('id');

            // $diff = $ids_original->diff($ids_data);
            // $this->model->{$relation->name}()->find($diff)->each(fn ($item) => $item->delete());

            $changed = array_udiff($data, $original,
                function ($a, $b) {
                    return array_udiff($a, $b, fn ($a, $b) => strcmp($a, $b));
                });
            // dd($data, $original, $changed);
            // fn($a, $b) => strcmp($a, $b));
            // dd($changed);

            // foreach ($changed as $item) {
            //     $this->model->{$relation->name}()->updateOrCreate(Arr::only($item, 'id'), $item);
            // }

            // $this->model->{$relation->name}()->delete([]);
            // $ids = collect($changed)->where(fn ($item) => isset($item['id'])); // ->map(fn ($item) => $item['id']);
            // ->map(fn ($item) => $item['id'])->toArray();
            // dd($ids->toArray(), $changed);
            // Arr::where($changed, fn ($item) => isset($item['id']))
            // $ids = Arr::map($changed, function ($item) {
            //     return $item['id'];
            // });
            // $ids = collect($changed)->map(function ($item) {
            //     return $item['id'];
            // });
            // $ids = Arr::only($changed, ['id']);
            // $this->model->{$relation->name}()->each(fn ($item) => $item->delete());
            $this->model->{$relation->name}()->delete();
            $this->model->{$relation->name}()->createMany($changed);
            // if ($relation->type == 'belongsTo') {
            //     $data[$relation->related->getKeyName()] = $this->model->{$relation->related->getForeignKeyName()};
            // }
            // $this->model->{$relation->name}()
            //     ->updateOrCreate(Arr::only($data, [$this->model->{$relation->name}()->getKeyName()]), $data ?? []);
        }

        $this->formClose();
    }

    /* form methods */

    #[On('formOpen')]
    public function formOpen()
    {
        $this->formData = $this->model->toArray();
        $this->formUploads = [];
        foreach ($this->getRelations($this->fields()) as $relation) {
            $this->formRelations[$relation->name] = $this->model?->{$relation->name}->toArray();
        }
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

    public function addRelation(string $relation)
    {
        $this->formRelations[$relation][] = [];
    }

    public function removeRelation(string $relation, int $index)
    {
        unset($this->formRelations[$relation][$index]);
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
