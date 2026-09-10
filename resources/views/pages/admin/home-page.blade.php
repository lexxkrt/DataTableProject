<div class="">
    <h1>Home</h1>
    {{-- <livewire:product-autocomplete /> --}}
    {{-- <livewire:category-autocomplete /> --}}
    <div class="space-y-3">
        <div class="w-64">
            <livewire:autocomplete :model="\App\Models\Product::class" />
        </div>
        <div class="w-80">
            <livewire:autocomplete :model="\App\Models\Category::class" />
        </div>
    </div>
    <div class="w-64">
        <livewire:autocomplete :model="\App\Models\Brand::class" />
    </div>
    @dump($product?->toArray())
    @dump($category?->toArray())
    @dump($brand?->toArray())
</div>