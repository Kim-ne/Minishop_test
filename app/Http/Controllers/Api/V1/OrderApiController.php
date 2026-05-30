<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\StoreOrderApiRequest;
use App\Http\Requests\Api\UpdateStatusOrderApiRequest;
use App\Http\Resources\OrderResource;
use App\Services\Contracts\OrderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderApiController extends BaseApiV1Controller
{
    public function __construct(
        protected OrderServiceInterface $orderService,
    ) {}

    /**
     * Summary of index
     * Get /api/orders
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search',
            'status',
            'customer_id',
            'per_page',
        ]);

        $orders = $this->orderService->getPaginated($filters);

        return $this->success(
            $orders->through(fn($orders) => new OrderResource($orders)),
            'Orders retrieved successfully'
        );
    }

    /**
     * Summary of show
     * Get /api/orders/{id}
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string|int $id): JsonResponse
    {
        $product = $this->orderService->show($id);

        return $this->success(new OrderResource($product), 'Product retrieved successfully');
    }

    /**
     * Summary of store
     * Post /api/orders
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderApiRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $orders = $this->orderService->store($validated);

            return $this->success(new OrderResource($orders), 'Order created successfully');
        } catch (\Exception $e) {
            [$message, $code] = $this->parseException($e,'Failed to create order.');

            return $this->error($message, $code);
        }
    }

    /**
     * Summary of destroy
     * Delete /api/orders/{id}
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string|int $id): JsonResponse
    {
        try {
            $this->orderService->destroy($id);

            return $this->success(null, 'Order deleted successfully');

        } catch (\Exception $e) {
            [$message, $code] = $this->parseException($e,'Failed to delete order.');

            return $this->error($message, $code);
        }
    }

    /**
     * Summary of updateStatus
     * Patch /api/orders/{id}/status
     * @param UpdateStatusOrderApiRequest $request
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(UpdateStatusOrderApiRequest $request, string|int $id): JsonResponse
    {
        $validated = $request->validated();

        try {
            $order = $this->orderService->updateStatus($id, $validated['status']);

            return $this->success(new OrderResource($order), 'Order status updated successfully');

        } catch (\Exception $e) {
            [$message, $code] = $this->parseException($e,'Failed to update order status.');

            return $this->error($message, $code);
        }
    }
}
