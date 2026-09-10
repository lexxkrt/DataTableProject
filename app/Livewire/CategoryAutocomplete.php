<?php

namespace App\Livewire;

use App\Models\Category;

class CategoryAutocomplete extends Autocomplete
{
    public string $model = Category::class;

    protected function query()
    {
        return Category::where('name', 'like', '%'.$this->search.'%')->orderBy('name')->limit(10)->pluck('name', 'id');
    }

    public function select(string $key, string $name)
    {
        parent::select($key, $name);
        $this->dispatch('selectCategory', $key);
    }
}
