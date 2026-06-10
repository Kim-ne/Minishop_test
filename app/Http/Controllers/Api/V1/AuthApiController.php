<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Contracts\AuthApiServiceInterface;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\Api\ResetPasswordApiRequest;
use App\Http\Requests\StoreUserRequest;
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

    /**
     * Summary of register
     * Post /api/auth/register
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        try {
            $data = $this->authApiService->register($request);

            return $this->success($data, 'Register successfully');

        } catch (\Exception $e) {
            [$message, $code] = $this->parseException($e,'Failed to register.');
            return $this->error($message, $code);
        }
    }

    /**
     * Summary of forgotPassword
     * Post /api/auth/ForgotPassword
     * @param ForgotPasswordApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(ForgotPasswordApiRequest $request): JsonResponse
    {
        try {
            $this->authApiService->forgotPassword($request);

            return $this->success(null, 'if email exist, pleasecheck your email');
        } catch (\Exception $e) {
            [$message, $code] = $this->parseException($e,'Failed to reset password.');

            return $this->error($message, $code);
        }
    }

    /**
     * Summary of resetPassword
     * Post /api/auth/ResetPassword
     * @param ResetPasswordApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(ResetPasswordApiRequest $request): JsonResponse
    {
        try {
            $this->authApiService->resetPassword($request);

            return $this->success(null, 'Reset password successfully, Please login');
        } catch (\Exception $e) {
            [$message, $code] = $this->parseException($e,'Failed to reset password.');

            return $this->error($message, $code);
        }
    }
}
