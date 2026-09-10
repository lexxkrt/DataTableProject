<?php

namespace App\Pages\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts::admin')]
class HomePage extends Component
{
    public $category = null;

    public $product = null;

    public $brand = null;

    #[On('selectProduct')]
    public function selectProduct($id)
    {
        $product = Product::find($id);
        $this->product = $product;
        // dd($product);
    }

    #[On('selectCategory')]
    public function selectCategory($id)
    {
        $category = Category::find($id);
        $this->category = $category;
        // dump($category);
    }

    #[On('selectBrand')]
    public function selectBrand($id)
    {
        $brand = Brand::find($id);
        $this->brand = $brand;
        // dump($category);
    }

    public function render()
    {
        return view('pages::admin.home-page');
    }
}
