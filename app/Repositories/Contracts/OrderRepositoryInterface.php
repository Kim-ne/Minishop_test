<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function getPaginated(array $filters = []):LengthAwarePaginator;

    public function show(int $id): Order;

    public function store(array $data): Order;

    public function returnStock(Object $data): void;
}
