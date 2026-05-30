<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;


class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = Order::with('items')->orderBy('created_at', 'desc');

        // Filler by keyword
        if(!empty($filters['search']))
        {
            $query->where(function($q) use ($filters)
            {
                $q->where('code', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Filter by status
        if (isset($filters['status']) && $filters['status'] !== '')
        {
            $query->where('status', $filters['status']);
        }

        // Filler by customer_id
        if (isset($filters['customer_id']) && $filters['customer_id'] !== '')
        {
            $query->where('customer_id', $filters['customer_id']);
        }

        $perPage = min((int) ($filters['per_page'] ?? 10), 100);

        return $query->paginate($perPage);

    }

    public function show(int $id): Order
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);
        return $order;
    }

    public function store(array $data): Order
    {
        return DB::transaction(function () use ($data)
        {
            // toltal from items
            $total = 0;
            $itemsData = [];

            foreach ($data['items'] as $item)
            {
                // product - 404 if not exists
                $product = Product::findOrFail($item['product_id']);

                // check stock
                if($product->qty < $item['qty'])
                {
                    throw new \Exception("Product '{$product->name}' only has {$product->qty} in stock.", 422);
                }


                $price = $product->price;
                $total += $price * $item['qty'];

                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $price,
                    'status' => 1,
                ];

                // degree stock
                $product ->decrement('qty', $item['qty']);
            }

            $order = Order::create([
                'code' => Order::generateCode(),
                'customer_id' => $data['customer_id'] ?? null,
                'email' => $data['email'],
                'payment_method' => $data['payment_method'],
                'total_amount' => $total,
                'notes' => $data['notes'] ?? null,
                'order_date' => now(),
                'status' => Order::STATUS_RECEIVED,
            ]);

            $order->items()->createMany($itemsData);

            return $order ->load(['customer', 'items.product']);
        });
    }

    public function returnStock(object $order): void
    {
        DB::transaction(function () use ($order)
        {
            foreach ($order->items as $item)
            {
                Product::where('id', $item->product_id)
                        ->increment('qty', $item->qty);
            }

            $order->items()->delete();
            $order->delete();
        });
    }
}

