<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order  extends Model
{
    use HasFactory;

    const STATUS_RECEIVED = 1;
    const STATUS_SHIPPING = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_CANCELLED = 4;

    const STATUS_LABEL = [
        self::STATUS_RECEIVED => 'Received',
        self::STATUS_SHIPPING => 'Shipping',
        self::STATUS_DELIVERED => 'Delivered',
        self::STATUS_CANCELLED => 'Cancelled',
    ];

    protected $fillable = [
        'code',
        'email',
        'payment_method',
        'customer_id',
        'notes',
        'status',
        'total_amount',
        'order_date',
    ];
    public function items(){
        return $this->hasMany(OrderProduct::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABEL[$this->status] ?? 'Unknown';
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public static function generateCode(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

}
