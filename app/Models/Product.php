<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Collection\Collection;

class Product extends Model
{
    use HasFactory,Notifiable;
    function category()
    {
        return $this->belongsTo(Category::class);
    }
    function items(){
        return $this->hasMany(OrderProduct::class);
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

    /**
     * Get product detail by alias.
     *
     * @param string $alias
     * @return mixed
     */

    static function detail($alias)
    {
        $productDetail = self::where(['status'=>1, 'alias'=>$alias])->first();
        return $productDetail;
        // if(!$productDetail){
        //     redirect()->route('product.index')->with('error', 'Product not found');
        // }
        // $related = Product::where('status',1 )
        //                     ->where('category_id', $productDetail->category_id)
        //                     ->where('id', '!=', $productDetail->id)->take(4)->get();
        // return self::with('category')->where('alias', $alias)->first();
    }

    /**
     * Summary of getRelated
     * @param mixed $product
     * @return mixed
     */
    static function getRelated($product)
    {
        return self::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)->take(4)->get();
    }

    /**
     * Summary of search
     * @param LengthAwarePaginator $keyword
     * @return LengthAwarePaginator
     */
    static function search($keyword)
    {
        return self::where('name', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%")
                    ->paginate(8);
    }

}


