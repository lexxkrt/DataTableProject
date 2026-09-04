<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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
        Category::factory(3)->create()->each(function (Category $category) {
            Category::factory(3, ['parent_id' => $category->id])->create()->each(function (Category $category) {
                Category::factory(3, ['parent_id' => $category->id])->create()->each(function (Category $category) {
                    Product::factory(rand(3, 5), ['category_id' => $category->id])->create()
                        ->each(function (Product $product) {
                            [$width, $height] = Product::make()->imageSize();
                            $product->images()->createMany(
                                ProductImage::factory(rand(1, 3), [
                                    'image' => fake_image_url($width, $height, $product->name),
                                ])->sequence(fn ($sequence) => [
                                    'position' => $sequence->index,
                                ])->make()->toArray()
                            );
                            // product attributes
                            // product filters
                        });
                });
            });
        });
    }
}
