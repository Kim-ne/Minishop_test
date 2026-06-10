<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use App\Events\OrderPlaced;
use App\Events\OrderStatusUpdated;
use Illuminate\Pagination\LengthAwarePaginator;


class OrderService implements OrderServiceInterface
{
    public function __construct(
        protected OrderRepositoryInterface $OrderRepository
    )
    {}

    /**
     * Summary of getPaginated
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
       return $this->OrderRepository->getPaginated($filters);
    }

    /**
     * Summary of show
     * @param int $id
     * @return Order
     */
    public function show(int $id): Order
    {
        return $this->OrderRepository->show($id);
    }

    /**
     * Summary of store
     * @param array $data
     * @return Order
     */
    public function store(array $data): Order
    {
        $order = $this->OrderRepository->store($data);
        OrderPlaced::dispatch($order);

        return $order;
    }

    /**
     * Summary of updateStatus
     * @param int $id
     * @param int $status
     * @throws \Exception
     * @return Order
     */
    public function updateStatus(int $id, int $status): Order
    {
        $order = Order::findOrFail($id);

        if($order->isDelivered() || $order->isCancelled())
        {
            throw new \Exception("Canot change status of a {$order->getStatusLabelAttribute()}", 422);
        }

        $order -> update(['status' => $status]);

        OrderStatusUpdated::dispatch($order);

        return $order->load(['customer', 'items.product']);
    }

    /**
     * Summary of destroy
     * @param int $id
     * @throws \Exception
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $order = Order::with('items')->findOrFail($id);

        if(!$order->isCancelled())
        {
            throw new \Exception('Only cancelled orders can be deleted', 422);
        }

        $this->OrderRepository->returnStock($order);

        return true;

    }


}

