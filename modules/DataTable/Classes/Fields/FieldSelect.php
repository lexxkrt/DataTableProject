<?php

namespace Modules\DataTable\Classes\Fields;

class FieldSelect extends Field
{
    public string $view = 'data-table::fields.select';

    public array $options = [];

    public function options(array $options = []): static
    {
        $this->options = $options;

        return $this;
    }
}
