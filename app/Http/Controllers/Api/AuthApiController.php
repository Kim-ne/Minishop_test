<?php

namespace App\Http\Controllers\Api;

use App\Services\Contracts\AuthApiServiceInterface;
use App\Http\Requests\Api\LoginApiRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;



class AuthApiController extends BaseApiController
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
            return response()->json([
                'exception_class'   => get_class($e),
                'exception_message' => $e->getMessage(),
                'exception_code'    => $e->getCode(),
                'file'              => $e->getFile(),
                'line'              => $e->getLine(),
            ], 500);
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
