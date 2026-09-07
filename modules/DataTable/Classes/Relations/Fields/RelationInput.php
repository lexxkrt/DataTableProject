<?php

namespace Modules\DataTable\Classes\Relations\Fields;

class RelationInput
{
    public string $view = 'data-table::relations.fields.input';

    public string $name = '';

    public string $label = '';

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
}
