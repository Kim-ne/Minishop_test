<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Collection;

interface CustomerServiceInterface
{
    public function index(): Collection;

    public function show(int $id): Customer;

    public function toggleStatus(int $id): Customer;

    public function destroy(int $id): bool;


}
