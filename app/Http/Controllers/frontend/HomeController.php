<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Interface\HomeServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected HomeServiceInterface $homeService,
    )
    {}
    function index(Request $request)
    {
       $productList = $this->homeService->getListProduct();
       $categoryList = $this->homeService->getListCategory();
       $productListRecent = $this->homeService->getListProductRecent();
       $data = [
        'products'=>$productList,
        'categories'=>$categoryList,
        'productsRecent'=>$productListRecent,
       ];
       return view('frontend.Home', $data);
    }


}
