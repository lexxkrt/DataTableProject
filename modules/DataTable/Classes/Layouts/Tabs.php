<?php

namespace Modules\DataTable\Classes\Layouts;

class Tabs
{
    public string $view = 'data-table::layouts.tab';

    public array $tabs = [];

    public function __construct() {}

    public static function make()
    {
        return new static;
    }

    public function tabs(array $tabs): static
    {
        $this->tabs = $tabs;

        return $this;
    }

    public function addTab(Tab $tab): static
    {
        $this->tabs[] = $tab;

        return $this;
    }
}
