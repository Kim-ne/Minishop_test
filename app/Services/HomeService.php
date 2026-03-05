<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Services\Interface\HomeServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HomeService implements HomeServiceInterface
{
    /**
     * Get paginated list of products and categories for the home page.
     * @return LengthAwarePaginator
     * @return Collection
     */
    // public function index()
    // {
    //     // Lấy danh sách category và product
    //     $listCategory = Category::orderBy('name', 'asc')
    //                             ->take(8)->get();
    //     $listProduct = Product::with('category')
    //                             ->orderBy('price', 'desc')->paginate(8);
    //     return [
    //         'categories'=>$listCategory,
    //         'products'=>$listProduct
    //     ];
    // }
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
