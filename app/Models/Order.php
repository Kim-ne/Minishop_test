<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Order  extends Model
{
    use HasFactory,Notifiable;
    // static function getCart($id): Collection
    // {
    //     return self::where('id',$id)->get();
    // }
    protected $fillable = [
        'code',
        'email',
        'payment_method',
        'customer_id',
        'notes',
        'status',
    ];
    function items(){
        return $this->hasMany(OrderProduct::class);
    }

    function getStatusLabelAttribute(){
        switch  ($this->status) {
            case 1:
                return 'Received';
                break;
            case 2:
                return 'Shipping';
                break;
            case 3:
                return 'Delivered';
                break;
            case 4:
                return 'Cancelled';
                break;
            default:
                return 'Received';
        }
    }
}
