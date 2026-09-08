<?php

namespace Modules\DataTable\Classes\Relations\Fields;

class RelationSelect extends RelationInput
{
    public string $view = 'data-table::relations.fields.select';

    public array $options = [];

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }
}
