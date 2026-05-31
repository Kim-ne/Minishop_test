<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Contracts\CustomerApiServiceInterface;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class CustomerApiController extends BaseApiV1Controller
{
    public function __construct(
        protected CustomerApiServiceInterface $customerApiService,
    ) {}

    /**
     * Summary of register
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try
        {
            $customer = $this->customerApiService->register($request);

            return $this->success($customer, 'Customer registered successfully');


        } catch (\Exception $e)
        {
            [$message, $code] = $this->parseException($e, 'Failed to register customer.');

            return $this->error($message, $code);
        };
    }
}
