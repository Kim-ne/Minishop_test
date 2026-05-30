<?php

namespace App\Services\Contracts;


use App\Models\User;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderServiceInterface
{
    public function getPaginated(array $filters = []): LengthAwarePaginator;

    public function show(int $id): Order;

    public function store(array $data): Order;

    public function updateStatus(int $id, int $status): Order;

    public function destroy(int $id): bool;


}
