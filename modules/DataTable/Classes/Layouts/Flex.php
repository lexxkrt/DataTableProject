<?php

namespace Modules\DataTable\Classes\Layouts;

class Flex
{
    public string $view = 'data-table::layouts.flex';

    public array $fields = [];

    public function __construct() {}

    public static function make()
    {
        return new static;
    }

    public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }
}
