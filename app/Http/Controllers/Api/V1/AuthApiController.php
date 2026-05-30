<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Contracts\AuthApiServiceInterface;
use App\Http\Requests\Api\LoginApiRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;



class AuthApiController extends BaseApiV1Controller
{
    public function __construct(
        protected AuthApiServiceInterface $authApiService
    ) {}

    /**
     * Summary of login
     * Post /api/auth/login
     * @param LoginApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginApiRequest $request): JsonResponse
    {
        try {
            $data = $this->authApiService->login($request);

            return $this->success($data, 'Login successfully');
        } catch (\Exception $e) {
            [$message, $code] = $this->parseException($e,'Failed to login.');
            return $this->error($message, $code);
        }
    }

    /**
     * Summary of logout
     * Post /api/auth/logout
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {

        $this->authApiService->logout($request);

        return $this->success(null, 'Logout successfully');
    }


    /**
     * Summary of me
     * Get /api/auth/me
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {

        $data = $this->authApiService->me($request);

        return $this->success($data, 'User retrieved successfully');
    }
}
