<?php

namespace Modules\DataTable\Classes\Filters;

class Filter
{
    public $view = 'data-table::filters.filter';

    public $name = '';

    public $label = '';

    public $options = [];

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public static function make(string $name, string $label = '')
    {
        empty($label) and $label = str($name)->replace('_', ' ')->title()->value();

        return new static($name, $label);
    }

    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }
}
