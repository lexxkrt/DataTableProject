<?php

namespace Modules\DataTable\Classes\Actions;

use Closure;

class Action
{
    public string $view = 'data-table::actions.action';

    public string $name = '';

    public string $label = '';

    public bool $confirm = false;

    public string $confirmMessage = '';

    public ?Closure $action = null;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public static function make(string $name, string $label = '')
    {
        empty($label) && $label = str($name)->replace(['_', '-'], ' ')->title()->value();

        return new static($name, $label);
    }

    public function view(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function confirm(string $message = 'Are you sure?'): static
    {
        $this->confirm = true;
        $this->confirmMessage = $message;

        return $this;
    }

    public function action(Closure $action): static
    {
        $this->action = $action;

        return $this;
    }
}
