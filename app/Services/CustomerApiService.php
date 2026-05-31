<?php

namespace App\Services;


use App\Models\Customer;
use App\Services\Contracts\CustomerApiServiceInterface;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Events\CustomerRegistered;
use App\Models\User;


class CustomerApiService implements CustomerApiServiceInterface
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

    /**
     * sumary of register
     * @param RegisterRequest $request
     * @return Customer
     */
    public function register(RegisterRequest $request): Customer
    {
        $validated = $request->validated();

        if(User::emailExists($validated['email']))
        {
            throw new \Exception('Email already exists');
        }

        $customer = Customer::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'zipcode' => $validated['zipcode'],
            'status' => Customer::STATUS_ACTIVE,
            'ship_firstname' => $validated['ship_firstname'] ?? $validated['firstname'],
            'ship_lastname' => $validated['ship_lastname'] ?? $validated['lastname'],
            'ship_email' => $validated['ship_email'] ?? $validated['email'],
            'ship_phone' => $validated['ship_phone'] ?? $validated['phone'],
            'ship_address' => $validated['ship_address'] ?? $validated['address'],
            'ship_country' => $validated['ship_country'] ?? $validated['country'],
            'ship_city' => $validated['ship_city'] ?? $validated['city'],
            'ship_zipcode' => $validated['ship_zipcode'] ?? $validated['zipcode'],
            'notes' => $validated['notes'] ?? 'Nothing',
        ]);

        customerRegistered::dispatch($customer);

        return $customer;

    }
}

