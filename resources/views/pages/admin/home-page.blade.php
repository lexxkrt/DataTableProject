<div class="">
    <h1>Home</h1>
    {{-- <livewire:product-autocomplete /> --}}
    {{-- <livewire:category-autocomplete /> --}}
    {{-- <div class="space-y-3">
        <div class="w-64">
            <livewire:autocomplete :model="\App\Models\Product::class" />
        </div>
        <div class="w-80">
            <livewire:autocomplete :model="\App\Models\Category::class" />
        </div>
    </div>
    <div class="w-64">
        <livewire:autocomplete :model="\App\Models\Brand::class" />
    </div> --}}

    <div class="w-5xl">
        <livewire:select2 name="brands"
                          :model="\App\Models\Brand::class" />
    </div>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus tempore minima expedita numquam
        perspiciatis vero nobis fuga quae saepe commodi quis, iusto velit ullam corporis doloribus obcaecati consequatur
        eos nesciunt. Repellat ut iste aut fugiat similique alias accusamus, impedit delectus fuga animi deleniti autem
        eius nesciunt totam obcaecati ducimus unde soluta quod sequi et ipsa. Esse repudiandae et assumenda quae
        doloribus? Magnam quasi eaque incidunt aliquam fugiat ullam repudiandae quaerat architecto voluptatem ducimus
        quidem, at mollitia illum excepturi explicabo corporis officia, facere autem ipsum neque culpa veniam totam?
        Odio aperiam neque fugiat molestias tenetur velit earum reprehenderit. Saepe, maiores veniam.</p>
    <div class="w-5xl">
        <livewire:select2 name="products"
                          :model="\App\Models\Product::class" />
    </div>
    {{--
    @dump($product?->toArray())
    @dump($category?->toArray())
    @dump($brand?->toArray()) --}}
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis vero a possimus quod saepe maiores facilis iste
        velit eveniet molestias cumque consectetur, qui suscipit, itaque quo quaerat libero odio nisi ad magnam ut quos
        alias. Maxime harum error sunt perferendis debitis in ea minima reiciendis amet vero sed et blanditiis nam,
        explicabo vel deserunt consequatur id. Incidunt architecto consequatur veniam autem facilis iusto quaerat esse
        aut, expedita laudantium saepe qui nostrum vel vitae ullam, rem dolores aliquid aliquam deserunt voluptatem
        ratione quibusdam voluptate non laboriosam? Atque minima qui voluptatibus culpa facere. Officia modi non quod
        consequuntur. Itaque ea nesciunt velit.</p>
    <div class="">
        {{ var_dump($multiselect) }}
    </div>
</div>
