<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'clothes', 'alias' => 'clothes', 'keywords' => 'clothes, fashion, apparel', 'description' => 'A category for clothing items.'],
            ['name' => 'books', 'alias' => 'books', 'keywords' => 'books, literature, reading', 'description' => 'A category for books and literature.'],
            ['name' => 'electronics', 'alias' => 'electronics', 'keywords' => 'electronics, gadgets, technology', 'description' => 'A category for electronic devices and gadgets.'],
            ['name' => 'furniture', 'alias' => 'furniture', 'keywords' => 'furniture, home decor, interior design', 'description' => 'A category for furniture and home decor items.'],
            ['name' => 'toys', 'alias' => 'toys', 'keywords' => 'toys, games, entertainment', 'description' => 'A category for toys and games.'],
            ['name' => 'shoes', 'alias' => 'shoes', 'keywords' => 'shoes, footwear, fashion', 'description' => 'A category for shoes and footwear.'],
            ['name' => 'beauty', 'alias' => 'beauty', 'keywords' => 'beauty, cosmetics, skincare', 'description' => 'A category for beauty products and cosmetics.'],
            ['name' => 'others', 'alias' => 'others', 'keywords' => '', 'description' => 'A category for other items.']
        ];
        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
