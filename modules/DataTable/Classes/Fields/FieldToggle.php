<?php

namespace Modules\DataTable\Classes\Fields;

use Modules\DataTable\Classes\Fields\Field;

class FieldToggle extends Field
{
    public string $view = 'data-table::fields.toggle';
    public string $type = 'checkbox';
}
