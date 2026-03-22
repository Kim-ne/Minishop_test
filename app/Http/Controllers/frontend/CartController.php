<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Services\Interface\ProductServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use stdClass;
use function PHPUnit\Framework\isEmpty;

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
        $qty = max(1, (int)$request->input('qty', 1));
        $carts = session('cart',[]);
        if(isset($carts[$item->id])){
            $carts[$item->id]->buy_qty += $qty;
        }else{
            $cartItem = new stdClass();
            $cartItem->id = $item->id;
            $cartItem->name = $item->name;
            $cartItem->buy_qty = $qty;
            $cartItem->price = $item->price;
            $cartItem->image = $item->image;
            $carts[$item->id] = $cartItem;
        }
        session(['cart'=>$carts]);
        return redirect()->route('product.cart')->with('success', 'Product added to cart');

    }
    function removeFromCart($id)
    {
        $cart = session('cart');
        if(isset($cart[$id]))
        {
            unset($cart[$id]);
            session(['cart'=>$cart]);
            // dd($cart);
            return redirect()->route('product.cart')->with('success', 'Product removed from cart');
        }else{
            return redirect()->route('product.cart')->with('error', 'Product not found in cart');
        }

    }
    function updateCart(Request $request,$id)
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:0'
        ]);
        $newQty = $validated['qty'];
        $cart = collect(session('cart', []));
        if(!$cart->has($id)){
            return redirect()->route('product.cart')->with('error', 'Product not found in cart');
        }
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('product.cart')->with('error', 'Product not found');
        }
        $er = '';
        $stock = $product->qty ?? 0;
        if($newQty > $stock){
            return redirect()->route('product.cart')->with('error', 'Product '.$product->name.' stock not enough');
        }

        if($newQty <= 0){
            $cart->forget($id);
        }else{
            $cart[$id]->buy_qty = $newQty;
        }
        session(['cart'=>$cart->toArray()]);
        return redirect()->route('product.cart')->with('success', 'Product quantity updated');
    }

    function order()
    {
        $order = collect(session('cart', []));
        $sub_total = $order->sum(function($item){
            return $item->price * $item->buy_qty;
        });
        $shipping = $sub_total * 0.05;
        $total = $sub_total + $shipping;
        if($order->isEmpty()){
            return redirect()->route('product.cart')->with('error', 'Cart is empty');
        }
        return view('frontend.product.cart.checkout',[
            'order' => $order,
            'categories' => Category::all(),
            'sub_total' => $sub_total,
            'shipping' => $shipping,
            'total' => $total,
            'i' => 1
        ]);
    }

    function orderPost(Request $request){
        $cart = collect(session('cart', []));

        if($cart->isEmpty()){
            return redirect()->route('product.cart')->with('error', 'Cart is empty');
        }
        $request->validate([
            'firstname' => 'required|max:50|min:4',
            'lastname' => 'required|max:50|min:4',
            'email' => 'required|email|max:100',
            'phone' => 'required|numeric|digits_between:9,15',
            'address' => 'required|max:100',
            'country' => 'required|max:50|string',
            'state' => 'required|string|max:50',
            'city'  => 'required|string|max:50',
            'zipcode' => 'numeric|digits_between:4,10',
            'payment_method' => ['required', Rule::in(['COD', 'BT', 'PP'])]
            ]);
        // ],[
        //     'firstname.required' => 'First name is required',
        //     'firstname.max' => 'First name is too long',
        //     'firstname.min' => 'First name is too short',
        //     'lastname.required' => 'Last name is required',
        //     'lastname.max' => 'Last name is too long',
        //     'lastname.min' => 'Last name is too short',
        //     'email.required' => 'Email is required',
        //     'email.email' => 'Email is invalid',
        //     'email.max' => 'Email is too long',
        //     'phone.required' => 'Phone number is required',
        //     'phone.numeric' => 'Phone number is invalid',
        //     'phone.max' => 'Phone number is too long',
        //     'address.required' => 'Address is required',
        //     'address.max' => 'Address is too long',
        //     'country.required' => 'Country is required',
        //     'country.max' => 'Country is too long',
        //     'city.required' => 'City is required',
        //     'city.max' => 'City is too long',
        //     'zipcode.numeric' => 'Zipcode is invalid',
        //     'zipcode.max' => 'Zipcode is too long',
        // ]);
        $fillable = $request->all();
        $fillable['code'] = rand(100000, 999999);
        $order = Order::create($fillable);
        $total_amount = 0;
        foreach($cart as $item){
           $fillitem = [
               'order_id' => $order->id,
               'product_id' => $item->id,
               'qty' => $item->buy_qty,
               'price' => $item->price,
           ];
           $total_amount += $item->price * $item->buy_qty;
           OrderProduct::create($fillitem);
        }
        if($request -> is_create){
            $customer = new Customer();
            $customer->firstname = $request->firstname;
            $customer->lastname = $request->lastname;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->country = $request->country;
            $customer->city = $request->city;
            $customer->zipcode = $request->zipcode;
            // Customer dont have ship address
            $customer->ship_firstname = $request->firstname;
            $customer->ship_lastname = $request->lastname;
            $customer->ship_email = $request->email;
            $customer->ship_phone = $request->phone;
            $customer->ship_address = $request->address;
            $customer->ship_country = $request->country;
            $customer->ship_city = $request->city;
            $customer->ship_zipcode = $request->zipcode;
            // Have ship address
            if($request->is_shipping){
                $customer->ship_firstname = $request->ship_firstname;
                $customer->ship_lastname = $request->ship_lastname;
                $customer->ship_email = $request->ship_email;
                $customer->ship_phone = $request->ship_phone;
                $customer->ship_address = $request->ship_address;
                $customer->ship_country = $request->ship_country;
                $customer->ship_city = $request->ship_city;
                $customer->ship_zipcode = $request->ship_zipcode;
            }
            $customer->password = Hash::make($request->password);
            $customer->save();
            $order->customer_id = $customer->id;
            $order->save();

        }
        $order->status = 1;
        $order->order_date = now();
        $shipping = $total_amount * 0.05;
        $order->total_amount = $total_amount + $shipping;
        $order->save();
        session()->forget('cart');
        return redirect()->route('cart.completed')->with(['ordered' => $cart]);
    }

    function orderCompleted()
    {
        $ordered = session('ordered');
        if(!$ordered)
            { return redirect()->route('product.cart');}
        return view('frontend.product.cart.completed',[
            'categories' => Category::all(),
            'ordered' => $ordered
        ]);
    }
}
