<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HomeService implements HomeServiceInterface
{
    /**
     * Get paginated list of products and categories for the home page.
     * @return LengthAwarePaginator
     * @return Collection
     */
    public function getListProduct(): LengthAwarePaginator
    {
        return Product::getList();
    }
     public function getListProductRecent(): LengthAwarePaginator
    {
        return Product::getListRecent();
    }
      public function getListCategory(): Collection
    {
        return Category::getList();
    }
}
