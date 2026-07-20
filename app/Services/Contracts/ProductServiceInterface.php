<?php

namespace App\Services\Contracts;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    /**
     * Get Paginate with product and category
     * @return mixed
     */
    public function getProductPaginate(): LengthAwarePaginator;
    public function getListCategory(): mixed;
    public function detail($alias): mixed;
    public function getRelatedProduct(Product $product): mixed;

    /**
     * Get search bar
     * @param mixed $keyword
     * @return mixed
     */
    public function search($keyword): mixed;

    public function getProductByStatusAndId(string|int $id): mixed;


    public function index(): LengthAwarePaginator;
    public function getAdminProductPaginate(array $filters): LengthAwarePaginator;
    public function store(StoreProductRequest $request): Product;
    public function show(int $id): Product;
    public function update(int $id, UpdateProductRequest $request): Product;
    public function destroy(int $id): bool;
    public function toggleStatus(int $id): Product;
    public function toggleFeatured(int $id): Product;
    public function updateStock(int $id, UpdateStockRequest $request): Product;

}
