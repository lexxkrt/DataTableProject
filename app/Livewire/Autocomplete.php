<?php

namespace App\Livewire;

use Livewire\Component;

class Autocomplete extends Component
{
    public $search = '';

    public $results = [];

    public string $model = '';

    public bool $opened = false;

    public function mount(string $model)
    {
        $this->model = $model;
    }

    protected function query()
    {
        return app($this->model)->where('name', 'like', '%'.$this->search.'%')->pluck('name', 'id');
    }

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->results = [];
            $this->opened = false;
        } else {
            $this->results = $this->query();
            $this->opened = true;
        }
    }

    public function select(string $key, string $name)
    {
        $this->search = $name;
        $this->results = [];
        $class = class_basename($this->model);
        $this->dispatch('select'.$class, $key);
    }

    public function render()
    {
        return view('components.autocomplete');
    }
}
