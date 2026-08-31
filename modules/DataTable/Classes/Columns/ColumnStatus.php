<?php

namespace Modules\DataTable\Classes\Columns;

class ColumnStatus extends Column
{
    public $view = 'data-table::columns.status';

    public $size = 'size-10';

    public function size(string $size): static
    {
        $this->size = $size;

        return $this;
    }
}
