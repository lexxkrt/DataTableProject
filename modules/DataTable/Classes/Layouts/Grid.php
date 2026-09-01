<?php

namespace Modules\DataTable\Classes\Layouts;

class Grid
{
    public string $view = 'data-table::layouts.grid';

    public int $column = 2;

    public array $fields = [];

    public string $css = '';

    public function __construct(int $column = 2)
    {
        $this->column = $column;
    }

    public static function make(int $column = 2)
    {
        return new static($column);
    }

    public function fields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }

    public function column(int $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function css(string $css): static
    {
        $this->css = $css;

        return $this;
    }
}
