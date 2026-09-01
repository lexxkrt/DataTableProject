<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = str(fake()->words(3, true))->plural()->title()->value();

        return [
            'name' => $name,
            'image' => fake_image_url(400, 400, $name),
            'position' => fake()->numberBetween(1, 100),
            'status' => fake()->boolean(),
        ];
    }
}
