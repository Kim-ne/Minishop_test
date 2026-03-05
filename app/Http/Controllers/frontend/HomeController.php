<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Interface\HomeServiceInterface;

class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected HomeServiceInterface $homeService
    )
    {}
    function index()
    {
       $productList = $this->homeService->getListProduct();
       $categoryList = $this->homeService->getListCategory();
       $productListRecent = $this->homeService->getListProductRecent();
       $data = [
        'products'=>$productList,
        'categories'=>$categoryList,
        'productsRecent'=>$productListRecent
       ];
       return view('frontend.Home', $data);
    }
    function getList()
    {
        $categories = Category::all()->take(8);
        return view('frontend.home',[
            'categories'=>$categories
        ]);
    }
}
