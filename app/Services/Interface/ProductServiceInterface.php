<?php

namespace App\Services\Interface;

use App\Models\Product;

interface ProductServiceInterface
{
    /**
     * Get Paginate with product and category
     * @return mixed
     */
    public function getListProduct(): mixed;
    public function getListCategory(): mixed;
    public function detail($alias): mixed;
    public function getRelatedProduct(Product $product): mixed;
}
