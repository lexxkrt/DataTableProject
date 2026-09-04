<?php

namespace Modules\DataTable\Classes\Relations;

class Relation
{
    public string $view = 'data-table::relations.relation';

    public string $name = '';

    public string $label = '';

    public array $fields = [];

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public static function make(string $name, string $label = '')
    {
        empty($label) and $label = str($name)->replace(['-', '_'], ' ')->title()->value();

        return new static($name,$label);
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

    public function fields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }
}
