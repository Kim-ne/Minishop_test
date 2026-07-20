<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;


class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAdminProductPaginate(array $filters = []): LengthAwarePaginator
    {
        $query = Product::with('category')->orderBy('created_at', 'desc');

        // Filler by keyword
        if(!empty($filler['search']))
        {
            $query->where(function($q) use ($filters)
            {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('sku', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Filter by category
        if (isset($filler['category_id']) && $filler['category_id'] !== '')
        {
            $query->where('category_id', $filler['category_id']);
        }

        // Filter by status
        if (isset($filler['status']) && $filler['status'] !== '')
        {
            $query->where('status', $filler['status']);
        }

        // Filler by Featured
        if (isset($filler['featured']) && $filler['featured'] !== '')
        {
            $query->where('featured', $filler['featured']);
        }

        // Sort
        $sortBy  = in_array($filters['sort_by']  ?? '', ['price', 'name', 'created_at', 'qty'])
                            ? $filters['sort_by'] : 'created_at';
        $sortDir = ($filters['sort_dir'] ?? 'desc') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDir);

        $perPage = min((int) ($filters['per_page'] ?? 10), 100);

        return $query->paginate($perPage);

    }

}
