<?php

namespace App\Http\Controllers\Api;

use App\Services\Contracts\CustomerApiServiceInterface;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\RedirectResponse;

class CustomerApiController extends BaseApiController
{
    public function __construct(
        protected CustomerApiServiceInterface $customerApiService,
    ) {}


    /**
     * Summary of register
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        try
        {
            $this->customerApiService->register($request);

            return redirect()->route('customer.index')->with('success', 'Customer registered successfully');

        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        };
    }
}
