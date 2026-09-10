<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        Brand::factory(10)->create();
        Property::factory(100)->create();
        Category::factory(3)->create()->each(function (Category $category) {
            Category::factory(3, ['parent_id' => $category->id])->create()->each(function (Category $category) {
                Category::factory(3, ['parent_id' => $category->id])->create()->each(function (Category $category) {
                    Product::factory(rand(3, 5), ['category_id' => $category->id])->create()
                        ->each(function (Product $product) {
                            [$width, $height] = Product::make()->imageSize();
                            $product->images()->createMany(
                                ProductImage::factory(rand(1, 3))->sequence(fn ($sequence) => [
                                    'position' => $sequence->index,
                                ])->make()->toArray()
                            );
                            // product attributes
                            // $product->properties()->attach(Property::inRandomOrder()->random(rand(1, 3)));
                            // product filters
                        });
                    $properties = Property::inRandomOrder()->take(rand(3, 5))->get();
                    $props = $properties->mapWithKeys(fn ($property, $index) => [$property->id => ['position' => $index]]);
                    $category->properties()->sync($props);
                    $category->products()->each(function (Product $product) use ($properties) {
                        $props = $properties->mapWithKeys(fn ($property, $index) => [$property->id => ['position' => $index, 'value' => fake()->word()]]);
                        $product->properties()->sync($props);
                    });
                    // $category->products()->each(function (Product $product) use ($properties) {
                    //     $product_properties = [];
                    //     foreach ($properties as $key => $property) {
                    //         $product_properties[$property->id] = [
                    //             'value' => fake()->word(),
                    //             'position' => $key,
                    //         ];
                    //     }
                    //     $product->properties()->sync($product_properties);
                    // });
                });
            });
        });
    }
}
