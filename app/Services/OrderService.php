<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
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
        return $this->OrderRepository->store($data);
    }

    public function updateStatus(int $id, int $status): Order
    {
        $order = Order::findOrFail($id);

        if($order->isDelivered() || $order->isCancelled())
        {
            throw new \Exception("Canot change status of a {$order->getStatusLabelAttribute()}", 422);
        }

        $order -> update(['status' => $status]);

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

