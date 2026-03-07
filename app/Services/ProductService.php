<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Services\Interface\ProductServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    /**
     * Get paginated list of products for the product  index page.
     * @return LengthAwarePaginator
     */
    public function getListProduct(): LengthAwarePaginator
    {
        return Product::getListProductPage();
    }
    public function getListCategory(): Collection
    {
        return Category::getList();
    }
}
