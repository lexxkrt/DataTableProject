<?php

namespace Modules\DataTable\Classes\Relations\Fields;

class RelationInput
{
    public string $view = 'data-table::relations.fields.input';

    public string $name = '';

    public string $label = '';

    public string $rules = '';

    public string $type = 'text';

    public string $placeholder = '';

    public string $value = '';

    public string $width = '';

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

    public function rules(string $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function value(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function width(string $width): static
    {
        $this->width = $width;

        return $this;
    }
}
