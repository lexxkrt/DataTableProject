<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = str(fake()->words(3, true))->title()->value();
        [$width, $height] = Brand::make()->imageSize();

        return [
            'name' => $name,
            'image' => fake_image_url($width, $height, $name),
            'position' => fake()->numberBetween(1, 100),
            'status' => fake()->boolean(),
        ];
    }
}
