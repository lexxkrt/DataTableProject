<?php

namespace Modules\DataTable\Classes\Filters;

class Filter
{
    public string $view = 'data-table::filters.filter';

    public string $name = '';

    public string $label = '';

    public array $options = [];

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public static function make(string $name, string $label = '')
    {
        empty($label) and $label = str($name)->replace(['_', '-'], ' ')->title()->value();

        return new static($name, $label);
    }

    public function view(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }
}
