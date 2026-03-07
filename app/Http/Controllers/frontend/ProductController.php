<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\Interface\ProductServiceInterface;

class ProductController extends Controller
{
    Public function __construct(
        protected ProductServiceInterface $ProductService){}
    function index()
    {
        $productList = $this->ProductService->getListProduct();
        $categories =  $this->ProductService->getListCategory();

        return view('frontend.product.index', [
            'products' => $productList,
            'categories' => $categories]);
    }
}
