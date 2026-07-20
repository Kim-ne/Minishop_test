<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService implements ProductServiceInterface
{
    function __construct
    (
        protected ProductRepositoryInterface $productRepository
    ) {}
    /**
     * Get paginated list of products for the product  index page.
     * @return LengthAwarePaginator
     * @return Collection
     * @return mixed
     */
    public function getProductPaginate(): LengthAwarePaginator
    {
        return Product::getProductPaginate();
    }

    public function getListCategory(): Collection
    {
        return Category::getList();
    }

    public function detail($alias): mixed
    {
        $product = Product::detail($alias);
        if(!$product){
            return null;
        }
        return $product;
    }

    public function getRelatedProduct(Product $product): Collection
    {
        return Product::getRelatedProduct($product);
    }

    /**
     * Get search bar
     * @param LengthAwarePaginator $keyword
     * @return LengthAwarePaginator
     */
    public function search($keyword) : LengthAwarePaginator
    {
        return Product::search($keyword);
    }

    public function getProductByStatusAndId(string|int $id): mixed
    {
        return Product::getProductByStatusAndId($id);
    }

    // manage product in admin

    /**
     * Summary of index
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return Product::getAdminListProduct();
    }

    /**
     * Summary of getAdminProductPaginate
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAdminProductPaginate(array $filters): LengthAwarePaginator
    {
        return $this->productRepository->getAdminProductPaginate($filters);
    }

    /**
     * Summary of store
     * @param StoreProductRequest $request
     * @return Product
     */
    public function store(StoreProductRequest $request): Product
    {
        $validated = $request->validated();
        $imagePath = $this->handleImageUpload($request);


        $validated['description'] = $validated['description'] ?? 'No description provided.';
        $validated['alias'] = $this->generateUniqueAlias($validated['name']);
        $validated['image'] = $imagePath;
        $validated['featured'] = $validated['featured'] ?? Product::FEATURED_NO;

        return Product::create($validated);
    }

    /**
     * Summary of show
     * @param int $id
     * @return Product
     */
    public function show(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * Summary of update
     * @param int $id
     * @param UpdateProductRequest $request
     * @return Product
     */
    public function update(int $id, UpdateProductRequest $request): Product
    {
        $product = Product::findOrFail($id);
        $validated = $request->validated();

        if($validated['name'] !== $product->name){
            $validated['alias'] = $this->generateUniqueAlias($validated['name'], $id);
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $validated['image'] = $this->handleImageUpload($request);
        } else {
            unset($validated['image']);
        }

        $product->update($validated);

        return $product;
    }

    /**
     * Summary of updateStock
     * @param int $id
     * @param UpdateStockRequest $request
     * @return Product
     */
    public function updateStock(int $id, UpdateStockRequest $request): Product
    {
        $product = Product::findOrFail($id);

        $product->update([
            'qty' => $request->validated()['qty']
        ]);

        return $product;
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $product = Product::findOrFail($id);
        $this->deleteImage($product->image);
        $product->delete();

        return true;
    }

    /**
     * Summary of toggleStatus
     * @param int $id
     * @return Product
     */
    public function toggleStatus(int $id): Product
    {
        $product = Product::findOrFail($id);
        $product->toggleStatus();

        return $product;
    }

    /**
     * Summary of toggleFeatured
     * @param int $id
     * @return Product
     */
    public function toggleFeatured(int $id): Product
    {
        $product = Product::findOrFail($id);
        $product->toggleFeatured();

        return $product;
    }

    // Helper methods for image handling and alias generation
    private function deleteImage(?string $imagePath): void
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath )) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    private function handleImageUpload(StoreProductRequest|UpdateProductRequest $request): ?string
    {
        if (!$request->hasFile('image'))
        {
            return null;
        }

        return $request->file('image')->store('products', 'public');
    }

    private function generateUniqueAlias(string $name, ?int $excludeId = null): string
    {
        $alias = Str::slug($name);
        $original = $alias;
        $counter = 1;

        while (Product::aliasExists($alias, $excludeId))
        {
           $alias = $original . '-' . $counter++;
        }

        return $alias;
    }

}
