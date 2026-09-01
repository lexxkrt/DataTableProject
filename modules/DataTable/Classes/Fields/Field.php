<?php

namespace Modules\DataTable\Classes\Fields;

class Field
{
    public string $view = 'data-table::fields.field';

    public string $name = '';

    public string $label = '';

    public string $key = '';

    public string $rules = '';

    public string $width = 'w-full';

    public string $type = 'text';

    public string $placeholder = '';

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

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function key(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function view(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function width(string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function rules(string $rules): static
    {
        $this->rules = $rules;

        return $this;
    }
}
