<?php

namespace Modules\DataTable\Classes\Fields;

class FieldText extends Field
{
    public string $view = 'data-table::fields.text';

    public int $rows = 3;

    public function rows(int $rows): static
    {
        $this->rows = $rows;

        return $this;
    }
}
