<?php

namespace App\Services;

use App\Http\Requests\OrderPostRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Http\Request;

interface CartServiceInterface
{
    public function getCart(): mixed;

    public function addToCart(Request $request, $product , string|int $id): mixed;

    public function removeFromCart(string|int $id): mixed;

    public function updateCart(UpdateCartRequest $request, string|int $id): mixed;

    public function stockCheck($product, $qty): bool;

    public function checkCartItem(string|int $id): mixed;

    public function orderCart(): mixed;

    public function orderPostCart(OrderPostRequest $request): mixed;

    public function orderCompleted(): mixed;
}
