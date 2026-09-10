<?php

namespace App\Livewire;

use App\Models\Product;

class ProductAutocomplete extends Autocomplete
{
    public string $model = Product::class;

    protected function query()
    {
        return Product::where('name', 'like', '%'.$this->search.'%')->orderBy('name')->limit(10)->pluck('name', 'id');
    }

    public function select(string $key, string $name)
    {
        parent::select($key, $name);
        $this->dispatch('selectProduct', $key);
    }
}
