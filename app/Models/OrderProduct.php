<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $table = 'order_product';

    protected $fillable = [
        'order_id',
        'customer_id',
        'qty',
        'price'
    ];
    function product()
    {
        return $this->belongsTo(Product::class);
    }
    function order()
    {
        return $this->belongsTo(Order::class);
    }
}
