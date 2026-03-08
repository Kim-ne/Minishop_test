<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\Interface\ProductServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use stdClass;

class CartController extends Controller
{
//     public function __construct(
//         protected ProductServiceInterface $ProductService
//     ) {}

    /**
     * Get cart product
     * @return View
     */
    function getCart():View
    {
        $cart = collect(session('cart', []));
        $sub_total = $cart->sum(function($item){
            return $item->price * $item->buy_qty;
        });
        $shipping = $sub_total * 0.05;
        $total = $sub_total + $shipping;

        return view('frontend.product.cart.cart',[
            'cart' => $cart,
            'categories' => Category::all(),
            'sub_total' => $sub_total,
            'shipping' => $shipping,
            'total' => $total
        ]);
    }

    function addToCart(Request $request, $id)
    {
        $item = Product::where(['status'=>1, 'id'=>$id])->first();
        if(!$item){
            return redirect()->route('product.index')->with('error', 'Product not found');
        }
        $carts = session('cart');
        if(isset($carts[$item->id])){
            $carts[$item->id]->buy_qty += 1;
        }else{
            $cartItem = new stdClass();
            $cartItem->id = $item->id;
            $cartItem->name = $item->name;
            $cartItem->buy_qty = 1;
            $cartItem->price = $item->price;
            $cartItem->image = $item->image;
            $carts[$item->id] = $cartItem;
        }
        session(['cart'=>$carts]);
        return redirect()->route('product.cart')->with('success', 'Product added to cart');

    }

}
