<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(5);
        return view('frontend.product.index', [
            'products' => $products
        ]);
    }
}
