<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory,Notifiable;
    function product()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    function count()
    {
        return $this->product()->count();
    }
    static function getList():Collection
    {
        return self::withCount('product')
                    ->orderBy('name', 'asc')->take(8)->get();
    }

}
