<?php

namespace Modules\DataTable\Classes\Columns;

use Closure;

class Column
{
    public string $view = 'data-table::columns.column';

    public string $name = '';

    public string $label = '';

    public bool $sortable = false;

    public bool $searchable = false;

    public bool $hidden = false;

    public string $width = 'auto';

    public string $align = 'left';

    public ?Closure $value = null;

    public ?Closure $action = null;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public static function make(string $name, string $label = '')
    {
        empty($label) && $label = str($name)->replace(['_', '-'], ' ')->title()->value();

        return new static($name, $label);
    }

    public function sortable(bool $sortable = true): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function searchable(bool $searchable = true): static
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function hidden(bool $hidden = true): static
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function width(string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function align(string $align): static
    {
        $this->align = $align;

        return $this;
    }

    public function left(): static
    {
        return $this->align('left');
    }

    public function right(): static
    {
        return $this->align('right');
    }

    public function center(): static
    {
        return $this->align('center');
    }

    public function view(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function value(Closure $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function action(Closure $action): static
    {
        $this->action = $action;

        return $this;
    }
}
