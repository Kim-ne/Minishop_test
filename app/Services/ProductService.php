<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    /**
     * Get paginated list of products for the product  index page.
     * @return LengthAwarePaginator
     * @return Collection
     * @return mixed
     */
    public function getListProduct(): LengthAwarePaginator
    {
        return Product::getListProductPage();
    }

    public function getListCategory(): Collection
    {
        return Category::getList();
    }

    public function detail($alias): mixed
    {
        $product = Product::detail($alias);
        if(!$product){
            return null;
        }
        return $product;
    }

    public function getRelatedProduct(Product $product): Collection
    {
        return Product::getRelatedProduct($product);
    }

    /**
     * Get search bar
     * @param LengthAwarePaginator $keyword
     * @return LengthAwarePaginator
     */
    public function search($keyword) : LengthAwarePaginator
    {
        return Product::search($keyword);
    }

    public function getProductByStatusAndId(string|int $id): mixed
    {
        return Product::getProductByStatusAndId($id);
    }
}
