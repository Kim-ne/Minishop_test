<?php

namespace App\Services;


use App\Models\Customer;
use App\Services\Contracts\CustomerServiceInterface;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Events\CustomerRegistered;



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
     * @param int $id
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

    /**
     * sumary of register
     * @param RegisterRequest $request
     * @return Customer
     */
    public function register(RegisterRequest $request): Customer
    {
        $validated = $request->validated();

        $customer = Customer::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
        ]);

        CustomerRegistered::dispatch($customer);

        return $customer;

    }
}

