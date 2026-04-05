<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderPostRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Category;
use App\Services\ProductServiceInterface;
use Illuminate\View\View;
use App\Services\CartServiceInterface;

class CartController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $ProductService,
        protected CartServiceInterface $CartService,
    ) {}

    /**
     * Get cart product
     * @return View
     */
    function getCart():View
    {
        $cart = $this->CartService->getCart();
        return view('frontend.product.cart.cart', $cart);

    }

    function addToCart(Request $request, string|int $id)
    {
        $product = $this->ProductService->getProductByStatusAndId($id);

        if(!$product){
            return redirect()->route('product.index')->with('error', 'Product not found');
        }

        $carts = $this->CartService->addToCart($request, $product, $id);
        session(['cart'=>$carts]);

        return redirect()->route('product.cart')->with('success', 'Product added to cart');

    }
    
    function removeFromCart(string|int $id): mixed
    {
        $cart = $this->CartService->removeFromCart($id);

        if(isset($cart[$id]))
        {
            unset($cart[$id]);
            session(['cart'=>$cart]);

            return redirect()->route('product.cart')->with('success', 'Product removed from cart');
        }else{

            return redirect()->route('product.cart')->with('error', 'Product not found in cart');
        }

    }

    function updateCart(UpdateCartRequest $request,string|int $id): mixed
    {
        $product = $this->ProductService->getProductByStatusAndId($id);

        if(!$product)
        {
            return redirect()->route('product.cart')->with('error', 'Product not found');
        }
        $stock = $this->CartService->stockCheck($this->ProductService->getProductByStatusAndId($id), $request->input('qty'));
        $newQty = $this->CartService->updateCart($request, $id);

        if($newQty > $stock)
        {
            return redirect()->route('product.cart')->with('error', 'Product '.$product->name.' stock not enough');
        }

        return redirect()->route('product.cart')->with('success', 'Product quantity updated');
    }

    function order()
    {
        $order = $this->CartService->orderCart();

        if(!$order || !isset($order['order']))
        {
            return redirect()->route('product.cart')->with('error', 'Cart is empty');
        }

        return view('frontend.product.cart.checkout', [
            'order' => $order['order'],
            'categories' => Category::all(),
            'sub_total' => $order['sub_total'],
            'shipping' => $order['shipping'],
            'total' => $order['total'],
            'i' => 1
            ]
        );
    }

    function orderPost(OrderPostRequest $request): mixed
    {
        $cart = collect(session('cart', []));

        if($cart->isEmpty())
        {
            return redirect()->route('product.cart')->with('error', 'Cart is empty');
        }

        try
        {
            $order = $this->CartService->orderPostCart($request);

            return redirect()->route('cart.completed')
                                ->with(['order' => $order,'ordered' => $cart])
                                ->with('success', 'Order placed successfully');
        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    function orderCompleted(): mixed
    {
        $completed = $this->CartService->orderCompleted();

        if(!$completed || !isset($completed['order']))
        {
            return redirect()->route('product.cart')->with('error', 'Order not found');
        }

        return view('frontend.product.cart.completed',[
            'categories' => Category::all(),
            'order' => $completed['order'],
            'ordered' => $completed['ordered']
        ]);
    }
}
