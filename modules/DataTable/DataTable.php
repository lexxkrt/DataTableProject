<?php

namespace Modules\DataTable;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Modules\DataTable\Classes\Actions\Action;
use Modules\DataTable\Classes\Columns\Column;

class DataTable extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $class = Model::class;

    public $sortField = 'id';

    public $sortDirection = 'asc';

    public $perPage = 10;

    public $search = '';

    public function title(): string
    {
        return str(app($this->class)->getTable())->replace('_', ' ')->title();
    }

    public function columns(): array
    {
        $columns = [];

        foreach (app($this->class)->getFillable() as $column) {
            $columns[] = Column::make($column);
        }

        return $columns;
    }

    public function fields():array
    {
        return [];
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

    #[Computed]
    public function data()
    {
        $query = $this->query();

        if ($this->search) {
            $searchable = collect($this->columns())->where('searchable', true)->pluck('name')->toArray();
            $query->whereAny($searchable, 'like', '%'.$this->search.'%');
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
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

    public function create()
    {
        // $this->authorize('create');
        $row = $this->query()->make();
        dd($row);
    }

    public function edit(string $key)
    {
        // $this->authorize('update');
        /** @var Model $row */
        $row = $this->query()->find($key);
        dd($row);
    }

    public function delete(string $key)
    {
        // $this->authorize('delete');
        /** @var Model $row */
        $row = $this->query()->find($key);
        $row->delete();
    }

    #[Layout('layouts::admin')]
    public function render()
    {
        return view('data-table::data-table');
    }
}
