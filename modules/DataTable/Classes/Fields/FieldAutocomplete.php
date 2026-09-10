<?php

namespace Modules\DataTable\Classes\Fields;

use Illuminate\Database\Eloquent\Builder;

class FieldAutocomplete extends Field
{
    public string $view = 'data-table::fields.autocomplete';
    public ?Builder $query = null;  
}
