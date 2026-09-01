<?php

namespace Modules\DataTable\Classes\Layouts;

class Section
{
    public string $view = 'data-table::layouts.section';

    public array $fields = [];

    public string $css = '';

    public bool $bordered = false;

    public function __construct() {}

    public static function make()
    {
        return new static;
    }

    public function fields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }

    public function css(string $css): static
    {
        $this->css = $css;

        return $this;
    }

    public function bordered(bool $bordered = true): static
    {
        $this->bordered = $bordered;

        return $this;
    }
}
