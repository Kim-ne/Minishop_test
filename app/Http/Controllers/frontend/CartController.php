<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\Interface\ProductServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $ProductService
    ) {}

    /**
     * Get cart product
     * @return Collection
     */
    function getCartProduct($ids):Collection
    {
        return Product::getCartProduct($ids);
    }
}
