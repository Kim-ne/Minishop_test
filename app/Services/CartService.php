<?php

namespace App\Services;

use App\Http\Requests\OrderPostRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Services\Contracts\CartServiceInterface;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class CartService implements CartServiceInterface
{
    public function getCart(): mixed
    {
        $cart = collect(session('cart', []));
        $sub_total = $cart->sum(function($item){
            return $item->price * $item->buy_qty;
        });
        $shipping = $sub_total * 0.05;
        $total = $sub_total + $shipping;

        return $cart = [
            'cart' => $cart,
            'categories' => Category::all(),
            'sub_total' => $sub_total,
            'shipping' => $shipping,
            'total' => $total
        ];
    }

    public function addToCart(Request $request, $product, string|int $id): mixed
    {
        $qty = max(1, (int)$request->input('qty', 1));
        $carts = session('cart',[]);
        if(isset($carts[$product->id])){
            $carts[$product->id]->buy_qty += $qty;
        }else{
            $cartItem = new stdClass();
            $cartItem->id = $product->id;
            $cartItem->name = $product->name;
            $cartItem->buy_qty = $qty;
            $cartItem->price = $product->price;
            $cartItem->image = $product->image;
            $carts[$product->id] = $cartItem;
        }

        return $carts;
    }

    public function removeFromCart(string|int $id): mixed
    {
        $cart = session('cart');

        return $cart;
    }

    public function stockCheck($product, $qty): bool
    {
        $stock = $product->qty ?? 0;

        if($qty > $stock){

            return false;
        }
        return true;
    }

    public function checkCartItem(string|int|null $id): mixed
    {
        if($id === null)
        {
            return false;
        }

        $cart = collect(session('cart', []));

        if(!$cart->has($id))
        {
            return false;
        }

        $item = $cart->get($id);
        if(!$item || !isset($item->id)){
            return false;
        }

        return $item && isset($item->id);
    }
    public function updateCart(UpdateCartRequest $request, string|int $id): bool
    {

        $newQty = $request->qty;
        $cartData = $this->getCart();
        $cart = collect($cartData['cart']);

        if($newQty <= 0){
            $cart->forget($id);
        }else{
            if(!$cart->has($id)){

                return false;
            }
            $cart[$id]->buy_qty = $newQty;
        }
        session(['cart'=>$cart->toArray()]);

        return $newQty;
    }

    public function orderCart(): bool|array
    {
        $order = collect(session('cart', []));
        $sub_total = $order->sum(function($item){
            return $item->price * $item->buy_qty;
        });
        $shipping = $sub_total * 0.05;
        $total = $sub_total + $shipping;
        if($order->isEmpty()){
            return false;
        }
        return [
            'order' => $order,
            'sub_total' => $sub_total,
            'shipping' => $shipping,
            'total' => $total
        ];
    }

    public function orderPostCart(OrderPostRequest $request): mixed
    {
        $cart = collect(session('cart', []));

        if($cart->isEmpty())
        {
            throw new \Exception('Cart is empty');
        }

        $fillable = $request->validated();
        $fillable['code'] = rand(100000, 999999);
        $order = Order::create($fillable);
        $total_amount = 0;

        foreach($cart as $item){
            $price = (float)$item->price;
            $qty = (int)$item->buy_qty;
            $fillitem = [
               'order_id' => $order->id,
               'product_id' => $item->id,
               'qty' => $qty,
               'price' => $price,
            ];
            $total_amount += $item->price * $item->buy_qty;

            if($total_amount < 0)
            {
                throw new \Exception('Total amount must be greater than 0');
            }

            OrderProduct::create($fillitem);
        }

        if($request -> is_create)
        {
            $customer = new Customer();
            $customer->firstname = $request->firstname;
            $customer->lastname = $request->lastname;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->country = $request->country;
            $customer->city = $request->city;
            $customer->zipcode = $request->zipcode;
            $customer->status = 1;
            $customer->notes = $request->notes ?? 'Nothing';

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
        } else
            {
                $customer = Customer::where('email', $request->email)->first();
                if(!$customer){
                    $customer = Customer::create([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'country' => $request->country,
                        'city' => $request->city,
                        'zipcode' => $request->zipcode,
                        'notes' => $request->notes ?? 'Nothing',
                        'status' => 1,
                        'password' => Hash::make('guest123'), // guest
                        'ship_firstname' => $request->boolean('is_shipping') ? $request->ship_firstname : $request->firstname,
                        'ship_lastname'  => $request->boolean('is_shipping') ? $request->ship_lastname : $request->lastname,
                        'ship_phone'     => $request->boolean('is_shipping') ? $request->ship_phone : $request->phone,
                        'ship_email'     => $request->boolean('is_shipping') ? $request->ship_email : $request->email,
                        'ship_address'   => $request->boolean('is_shipping') ? $request->ship_address : $request->address,
                        'ship_country'   => $request->boolean('is_shipping') ? $request->ship_country : $request->country,
                        'ship_city'      => $request->boolean('is_shipping') ? $request->ship_city : $request->city,
                        'ship_zipcode'   => $request->boolean('is_shipping') ? $request->ship_zipcode : $request->zipcode,
                    ]);
                }
                $order->customer_id = $customer->id;
                $order->save();
            }
        $order->update([
            'shipping' => $shipping = $total_amount * 0.05,
            'total_amount' => $total_amount + $shipping,
            'status' => 1,
            'order_date' => now(),
        ]);

        session()->forget('cart');

        return $order;
    }

    public function orderCompleted(): bool|array
    {
        $order = session('order');
        $ordered = collect(session('ordered',[])); //cart

        if(!$order)
        {
            return false;
        }

        return [
            'order' => $order,
            'ordered' => $ordered
        ];
    }


}

