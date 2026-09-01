<?php

class Field
{
    public string $view = 'data-table::fields.field';

    public string $name = '';

    public string $key = '';

    public string $label = '';

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->key = 'formData.'.$name;
        $this->label = $label;
    }

    public static function make(string $name, string $label = '')
    {
        empty($label) and $label = str($name)->replace('_', ' ')->title()->value();

        return new static($name, $label);
    }
}
