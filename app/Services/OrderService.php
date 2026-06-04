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

    public function show(int $id): Order
    {
        return $this->OrderRepository->show($id);
    }

    public function store(array $data): Order
    {
        $order = $this->OrderRepository->store($data);
        OrderPlaced::dispatch($order);

        return $order;
    }

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

