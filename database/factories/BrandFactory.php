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

        return [
            'name' => $name,
            'image' => fake_image_url(400, 400, $name),
        ];
    }
}
