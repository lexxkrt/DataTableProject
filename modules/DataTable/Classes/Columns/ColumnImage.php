<?php

namespace Modules\DataTable\Classes\Columns;

class ColumnImage extends Column
{
    public $view = 'data-table::columns.image';

    public $size = 'size-10';

    public function size(string $size): static
    {
        $this->size = $size;

        return $this;
    }
}
