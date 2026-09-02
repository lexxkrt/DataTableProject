<?php

namespace Modules\DataTable\Classes\Columns;

class ColumnToggle extends Column
{
    public string $view = 'data-table::columns.toggle';

    public function toggle(): static
    {
        $this->action = fn ($row) => $row->update([$this->name => ! $row->{$this->name}]);

        return $this;
    }
}
