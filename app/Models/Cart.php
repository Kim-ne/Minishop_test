<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Collection\Collection;

class Cart  extends Model
{
    use HasFactory,Notifiable;
    function category()
    {
        return $this->belongsTo(Category::class);
    }

    static function getCartProduct($id): Collection
    {
        return Product::where('id',$id)->get();
    }
}




