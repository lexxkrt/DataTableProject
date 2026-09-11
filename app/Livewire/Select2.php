<?php

namespace App\Livewire;

use Livewire\Component;

class Select2 extends Component
{
    public $model;

    public $name;

    public $search;

    public $results;

    public $selected;

    public function mount($model, $name)
    {
        $this->model = $model;
        $this->name = $name;
        $this->search = '';
        $this->results = [];
        $this->selected[$name] = [];
    }

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->results = [];
        } else {
            $this->results = app($this->model)->where('name', 'like', '%'.$this->search.'%')->pluck('name', 'id');
        }
    }

    public function select($id, $name)
    {
        if (array_key_exists($id, $this->selected[$this->name])) {
            unset($this->selected[$this->name][$id]);
        } else {
            $this->selected[$this->name][$id] = $name;
        }
        $keys = implode(',', array_keys($this->selected[$this->name]));
        $this->dispatch('multiselect', $this->name, $keys);
    }

    public function render()
    {
        return view('select2');
    }
}
