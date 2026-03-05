<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
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
        $categories = ['clothes', 'books', 'electronics', 'furniture', 'toys','shoes','beauty','others'];
        return [
            'name' => $this->faker->randomElement($categories),
            'alias' => fn(array $attributes) => Str::slug($attributes['name']),
            'keywords' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
