<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productCount()
    {
        return $this->product()->count();
    }

    public static function getList():Collection
    {
        return self::withCount('products')
                    ->orderBy('name', 'asc')->take(8)->get();
    }

}
