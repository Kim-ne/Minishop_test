<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $category = Category::inRandomOrder()->first();
        $productNamesByCategory = [
            'clothes' => ['T-shirt', 'Jeans', 'Jacket', 'Dress', 'Skirt'],
            'books' => ['The Great Gatsby', 'To Kill a Mockingbird', '1984'],
            'electronics' => ['Smartphone', 'Laptop', 'Headphones'],
            'furniture' => ['Sofa', 'Dining Table', 'Chair'],
            'toys' => ['Action Figure', 'Board Game', 'Puzzle'],
            'shoes' => ['Sneakers', 'Boots', 'Sandals'],
            'beauty' => ['Lipstick', 'Foundation', 'Mascara'],
            'others' => ['Gift Card', 'Mug', 'Poster'],
        ];
        $baseName =$category && isset($productNamesByCategory[$category->name])
                    ? $productNamesByCategory[$category->name] : ['Product','Item','Goods'];
        $baseName = $this->faker->randomElement($baseName);
        $name = $baseName.' '.$this->faker->words(2, true);
        $alias = Str::slug($name);
        return [
            'name' => $name,
            'qty' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(3, 100, 5000),
            'alias' => $alias,
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'category_id' => $category->id,
            'status' => 1,
            'sku' => strtoupper($alias).'-'.strtoupper($this->faker->bothify('??###')),
            'keywords' => implode(', ', $this->faker->words(5)),
            'supplier_id' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->paragraph(3, true),

        ];
    }
}
