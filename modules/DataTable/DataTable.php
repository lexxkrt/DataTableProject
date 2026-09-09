<?php

namespace Modules\DataTable;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
use Modules\DataTable\Classes\Relations\Fields\RelationImage;
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
    public function data(): mixed
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

    public function store(): void
    {
        $this->resetValidation();
        $fields = $this->getFields($this->fields());
        $inputs = collect($fields)->filter(fn ($field) => $field->type != 'file');
        $files = collect($fields)->filter(fn ($field) => $field->type == 'file');

        $rules = collect($fields)->mapWithKeys(fn ($field) => [$field->key => $field->rules])->toArray();
        $attributes = collect($fields)->mapWithKeys(fn ($field) => [$field->key => trans($field->label)])->toArray();

        $relations = $this->getRelations($this->fields());
        foreach ($relations as $relation) {
            foreach ($relation->fields as $field) {
                $key = 'formRelations'.'.'.$relation->name.'.*.'.$field->name;
                $rules[$key] = $field->rules;
                $attributes[$key] = trans($field->label);
            }
        }

        $validated = $this->validate($rules, [], $attributes);

        $formData = Arr::only($validated['formData'], $inputs->keys()->toArray());

        $table = app($this->class)->getTable();

        $files->each(function ($field) use (&$formData, $table) {
            Arr::has($this->formData, $field->name) && blank($this->formData[$field->name]) and $formData[$field->name] = null;
            Arr::has($this->formUploads, $field->name) and $formData[$field->name] = $this->formUploads[$field->name]->store($table, 'local');
        });

        $this->model = $this->model->updateOrCreate([$this->model->getKeyName() => $this->model->getKey()], $formData);

        foreach ($relations as $relation) {
            collect($relation->fields)
                ->where(fn ($field) => $field instanceof RelationImage)
                ->each(function ($field) use ($relation) {
                    // dump($this->formRelations[$relation->name]);
                    foreach ($this->formRelations[$relation->name] as $key => $value) {
                        $index = "{$relation->name}_{$key}_{$field->name}";
                        $table = $this->model->getTable();
                        // dump($index, $this->formUploads);
                        if (Arr::has($this->formUploads, $index)) {
                            // dump($this->formUploads[$index]);
                            $file = $this->formUploads[$index]->store($table, 'local');
                            $this->formRelations[$relation->name][$key][$field->name] = $file;
                            // dump($this->formRelations[$relation->name]);
                        }
                    }
                    // $this->formUploads[$field->name]->store($table, 'local');
                    // dd($field, $relation);
                });
            if (app($this->class)->{$relation->name}() instanceof HasMany) {
                $this->storeHasMany($relation->name);
            } elseif (app($this->class)->{$relation->name}() instanceof BelongsToMany) {
                $this->storeBelongsToMany($relation->name);
            }
        }

        $this->formClose();
    }

    private function storeImage($field)
    {
        $table = app($this->class)->getTable();

        $files->each(function ($field) use (&$formData, $table) {
            Arr::has($this->formData, $field->name) && blank($this->formData[$field->name]) and $formData[$field->name] = null;
            Arr::has($this->formUploads, $field->name) and $formData[$field->name] = $this->formUploads[$field->name]->store($table, 'local');
        });

    }

    private function storeBelongsToMany(string $relation): void
    {
        $foreignKeyName = app($this->class)->{$relation}()->getForeignPivotKeyName(); // product_id
        $relatedKeyName = app($this->class)->{$relation}()->getRelatedPivotKeyName(); // property_id

        $data = collect($this->formRelations[$relation])
            ->where(fn ($item) => isset($item[$relatedKeyName]))
            ->mapWithKeys(fn ($item) => [$item[$relatedKeyName] => $item]);

        $this->model->{$relation}()->sync($data);
    }

    private function storeHasMany(string $relation): void
    {
        $keyName = app($this->class)->{$relation}()->getRelated()->getKeyName();
        $data = collect($this->formRelations[$relation]);

        $this->model->{$relation}()->whereNotIn($keyName, $data->pluck($keyName))->delete();
        $this->model->{$relation}()->createMany($data->whereNull($keyName)->toArray());
        $data->whereNotNull($keyName)->each(fn ($item) => $this->model->{$relation}()->updateOrCreate(Arr::only($item, $keyName), $item));
    }

    /* form methods */

    #[On('formOpen')]
    public function formOpen(): void
    {
        $this->formData = $this->model->toArray();
        $this->formUploads = [];
        $this->formRelations = [];
        foreach ($this->getRelations($this->fields()) as $relation) {
            if ($this->model->{$relation->name}() instanceof BelongsToMany) {
                $this->formRelations[$relation->name] = $this->model?->{$relation->name}->pluck('pivot')->toArray();
                // empty($this->formRelations[$relation->name]) and $this->formRelations[$relation->name] =
            } elseif ($this->model->{$relation->name}() instanceof HasMany) {
                $this->formRelations[$relation->name] = $this->model?->{$relation->name}->toArray();
            }
        }
        $this->formShow = true;
    }

    #[On('formClose')]
    public function formClose(): void
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

    public function relationImageUrl(string $field)
    {
        return $this->model?->{$field}?->getImage();
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

    public function imageRelation(string $relation)
    {
        if (Arr::has($this->formUploads, $relation)) {
            return $this->formUploads[$relation]->temporaryUrl();
        } else {
            return $this->formRelations[$relation][0]['image'];
        }
    }

    /* end form methods */

    // public function paginationView()
    // {
    //     return 'data-table::pagination';
    // }

    public function formView()
    {
        return 'data-table::form';
    }

    #[Layout('layouts::admin')]
    public function render()
    {
        return view('data-table::data-table');
    }
}
