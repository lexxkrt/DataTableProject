<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand = Brand::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();
        $prefix = str($brand->name)->substr(0, 2);
        $model = $prefix.'-'.fake()->numerify('####');
        $sku = fake()->numerify('00-00####');
        $name = str(fake()->words(3, true))->title();
        [$width, $height] = Product::make()->imageSize();

        return [
            'name' => $name,
            'image' => fake_image_url($width, $height, $name),
            'description' => fake()->paragraph(3),
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'price' => fake()->numberBetween(1000, 10000),
            'quantity' => fake()->numberBetween(0, 10),
            'position' => fake()->numberBetween(1, 100),
            'status' => fake()->boolean(80),
        ];
    }
}
