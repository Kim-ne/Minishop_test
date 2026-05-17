<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Services\ProductServiceInterface;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $productService
    ){}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $products = $this->productService->index();

        return view('backend.products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $product = $this->productService->show($id);

        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = $this->productService->getListCategory();

        return view('backend.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        try
        {
            $this->productService->store($request);

            return redirect()->route('user.products')->with('success', 'Product created successfully.');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $product = $this->productService->show($id);
        $categories = $this->productService->getListCategory();

        return view('backend.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateProductRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateProductRequest $request): RedirectResponse
    {
        try
        {
            $this->productService->update($id, $request);

            return redirect()->route('user.products')->with('success', 'Product updated successfully.');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param UpdateStockRequest $request
     * @return RedirectResponse
     */
    public function updateStock(int $id, UpdateStockRequest $request): RedirectResponse
    {
        try
        {
            $this->productService->updateStock($id, $request);

            return redirect()->route('user.products')->with('success', 'Product stock updated successfully.');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to update product stock: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the status of the specified resource.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        try
        {
            $this->productService->toggleStatus($id);

            return redirect()->route('user.products')->with('success', 'Product status updated successfully.');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to update product status: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the featured of the specified resource.
     * @param int $id
     * @return RedirectResponse
     */
    public function toggleFeatured(int $id): RedirectResponse
    {
        try
        {
            $this->productService->toggleFeatured($id);

            return redirect()->route('user.products')->with('success', 'Product featured updated successfully.');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to update product featured: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try
        {
            $this->productService->destroy($id);

            return redirect()->route('user.products')->with('success', 'Product deleted successfully.');

        } catch (\Exception $e)
        {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}
