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
        return $this->hasMany(Product::class);
    }
     static function getList():Collection
    {
        return self::orderBy('name', 'asc')->take(8)->get();
    }

}
