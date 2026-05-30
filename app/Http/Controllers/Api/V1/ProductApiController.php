<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\StoreProductApiRequest;
use App\Http\Requests\Api\UpdateProductApiRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Services\Contracts\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ProductApiController extends BaseApiV1Controller
{
    public function __construct(
        protected ProductServiceInterface $productService,
    ) {}

    /**
     * Summary of index
     * Get /api/products
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {


        $filters = $request->only([
            'search', 'category_id', 'status', 'featured',
            'sort_by', 'sort_dir', 'per_page',
        ]);

        $products = $this->productService->getAdminProductPaginate($filters);

        return $this->success(new  ProductCollection($products), 'Product retrieved successfully');
    }

    /**
     * Summary of show
     * Get /api/products/{id}
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string|int $id): JsonResponse
    {
        $product = $this->productService->show($id);

        return $this->success(new ProductResource($product), 'Product retrieved successfully');
    }

    /**
     * Summary of store
     * Post /api/products
     * @param StoreProductApiRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductApiRequest $request): JsonResponse
    {
        $validated = $request->validated();

         // Xử lý image nếu có upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                                          ->store('products', 'public');
        }

        // Tự generate alias từ name
        $validated['alias'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['description'] = $validated['description'] ?? 'No description provided.';

        $product = Product::create($validated);

        return $this->created(new ProductResource($product), 'Product created successfully');
    }

    /**
     * Summary of update
     * Put /api/products/{id}
     * @param UpdateProductApiRequest $request
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductApiRequest $request, string|int $id): JsonResponse
    {
        $product = $this->productService->show($id);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image)
            {
                if(Storage::disk('public')->exists($product->image))
                {
                    Storage::disk('public')->delete($product->image);
                }
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return $this->success(new ProductResource($product->fresh()), 'Product updated successfully');
    }

    /**
     * Summary of destroy
     * Delete /api/products/{id}
     * @param string|int $id
     * @return JsonResponse
     */
    public function destroy(string|int $id): JsonResponse
    {
        try {
            $this->productService->destroy($id);
            return $this->success(null, 'Product deleted successfully');

        } catch (\Exception $e) {
            [$message, $code] = $this->parseException($e,'Failed to delete product.');
            return $this->error($message, $code);
        }

    }

    /**
     * Summary of toggleStatus
     * Patch /api/products/{id}/status
     * @param string|int $id
     * @return JsonResponse
     */
    public function toggleStatus(string|int $id): JsonResponse
    {
        $product = $this->productService->toggleStatus($id);
        return $this->success(new ProductResource($product), 'Product status updated');
    }

    /**
     * Summary of toggleFeatured
     * Patch /api/products/{id}/featured
     * @param string|int $id
     * @return JsonResponse
     */
    public function toggleFeatured(string|int $id): JsonResponse
    {
        $product = $this->productService->toggleFeatured($id);
        return $this->success(new ProductResource($product), 'Product featured status updated');
    }

}
