<?php

namespace Modules\DataTable\Classes\Columns;

class ColumnImage extends Column
{
    public string $view = 'data-table::columns.image';

    public string $size = 'size-10';

    public function size(string $size): static
    {
        $this->size = $size;

        return $this;
    }
}
