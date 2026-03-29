<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\Interface\ProductServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $ProductService
    ) {}
    /**
     * Summary of index
     * @return View
     */
    function index()
    {
        $productList = $this->ProductService->getListProduct();
        $categories =  $this->ProductService->getListCategory();

        return view('frontend.product.index', [
            'products' => $productList,
            'categories' => $categories
        ]);
    }


    /**
     * Detail page of product
     *
     * @param Request $request
     * @param string $alias
     *
     * @return mixed
    */

    function detail(Request $request, $alias)
    {
        $categories = $this->ProductService->getListCategory();

        $product = $this->ProductService->detail($alias);

        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Product not found');
        }
        $related = $this->ProductService->getRelatedProduct($product);

        return view('frontend.product.cart.product_detail', [
            'product' => $product,
            'related' => $related,
            'categories' => $categories
        ]);

    }

    function search(Request $request)
    {
        $keyword = $request->keyword;
        $products = $this->ProductService->search($keyword);
        return view('frontend.product.search', [
            'products' => $products,
            'keyword' => $keyword,
            'categories' => Category::all()
        ]);
    }
}
