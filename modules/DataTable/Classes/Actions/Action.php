<?php

namespace Modules\DataTable\Classes\Actions;

use Closure;

class Action
{
    public $view = 'data-table::actions.action';

    public $name = '';

    public $label = '';

    public $confirm = false;

    public ?Closure $action = null;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public static function make(string $name, string $label = '')
    {
        empty($label) && $label = str($name)->replace('_', ' ')->title();

        return new static($name, $label);
    }

    public function confirm(bool $confirm = true): static
    {
        $this->confirm = $confirm;

        return $this;
    }

    public function action(Closure $action): static
    {
        $this->action = $action;

        return $this;
    }
}
