<?php

namespace Modules\DataTable\Classes\Fields;

use Modules\DataTable\Classes\Fields\Field;

class FieldImage extends Field
{
    public string $view = 'data-table::fields.image';
    public string $type = 'file';
}
