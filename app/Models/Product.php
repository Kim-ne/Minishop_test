<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;

class Product extends Model
{
    use HasFactory,Notifiable;
    function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get list of products with pagination.
     * @return LengthAwarePaginator
     */
    static function getList(): LengthAwarePaginator
    {
        return self::with('category')->orderBy('price', 'desc')
                                                ->where('status', 1)->paginate(8);
    }
    static function getListProductPage(): LengthAwarePaginator
    {
        return self::with('category')->orderBy('price', 'desc')
                                                ->where('status', 1)->paginate(9);
    }
     static function getListRecent(): LengthAwarePaginator
    {
        return self::with('category')->orderBy('created_at', 'desc')
                                                ->where('status', 1)->paginate(8);
    }

}

