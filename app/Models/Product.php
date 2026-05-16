<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\LengthAwarePaginator;

class Product extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const FEATURED_YES = 1;
    const FEATURED_NO = 0;

    protected $fillable = [
        'name',
        'price',
        'qty',
        'image',
        'alias',
        'category_id',
        'status',
        'sku',
        'keywords',
        'supplier_id',
        'description',
    ];

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
    public static function getList(): LengthAwarePaginator
    {
        return self::with('category')->orderBy('price', 'desc')
                                                ->where('status', 1)->paginate(8);
    }
    public static function getListProductPage(): LengthAwarePaginator
    {
        return self::with('category')->orderBy('price', 'desc')
                                                ->where('status', 1)->paginate(9);
    }
    public static function getListRecent(): LengthAwarePaginator
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

    public static function detail($alias)
    {
        $productDetail = self::where(['status'=>1, 'alias'=>$alias])->first();
        return $productDetail;
    }

    /**
     * Summary of getRelated
     * @param mixed $product
     * @return mixed
     */
    public static function getRelatedProduct($product)
    {
        return self::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)->take(4)->get();
    }

    /**
     * Summary of search
     * @param LengthAwarePaginator $keyword
     * @return LengthAwarePaginator
     */
    public static function search($keyword)
    {
        return self::where('name', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%")
                    ->paginate(8);
    }

    public static function getProductByStatusAndId(string|int $id)
    {
        return self::where(['status'=>self::STATUS_ACTIVE, 'id'=>$id])->first();
    }

}


