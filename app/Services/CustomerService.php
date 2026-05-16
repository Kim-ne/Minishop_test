<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Collection;
use Override;

class CustomerService implements CustomerServiceInterface
{
    /**
     * Summary of index
     * @return Collection
     */
    public function index(): Collection
    {
        $customers = Customer::forStatus();

        return $customers;
    }

    /**
     * Summary of store

     * @return Customer
     */

    public function toggleStatus(int $id): Customer
    {

        $customer = Customer::findOrFail($id);
        $customer->update([
            'status' => $customer->isActive()
                        ? Customer::STATUS_INACTIVE
                        : Customer::STATUS_ACTIVE,
        ]);

        return $customer;
    }

    /**
     * Summary of update
     * @param int $id
     * @return Customer
     */

    public function show(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return bool
     */

    public function destroy(int $id): bool
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return true;
    }
}

