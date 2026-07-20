<?php

namespace App\Services\Contracts;

use App\Models\Customer;
use Illuminate\Support\Collection;
use App\Http\Requests\RegisterRequest;

interface CustomerServiceInterface
{
    public function index(): Collection;

    public function show(int $id): Customer;

    public function toggleStatus(int $id): Customer;

    public function destroy(int $id): bool;

    public function register(RegisterRequest $request): Customer;

}
