<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Contracts\CustomerApiServiceInterface;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\Api\ResetPasswordApiRequest;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\ResendVerificationApiRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerApiController extends BaseApiV1Controller
{
    public function __construct(
        protected CustomerApiServiceInterface $customerApiService,
    ) {
    }

    /**
     * Summary of register
     * Post /api/v1/customer/register
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $this->customerApiService->register($request);

        return $this->success(null, 'Customer registered successfully');
    }

    /**
     * Summary of login
     * Post /api/v1/customer/login
     * @param LoginApiRequest $request
     * @return JsonResponse
     */
    public function login(LoginApiRequest $request): JsonResponse
    {
        $data = $this->customerApiService->login($request);

        return $this->success($data, 'Login successfully');
    }

    /**
     * Summary of logout
     * Post /api/v1/customer/logout
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->customerApiService->logout($request);

        return $this->success(null, 'Logout successfully');
    }

    /**
     * Summary of forgotPassword
     * Post /api/v1/customer/ForgotPassword
     * @param ForgotPasswordApiRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordApiRequest $request): JsonResponse
    {
        $this->customerApiService->forgotPassword($request);

        return $this->success(null, 'if email exist,a reset link will be sent. Pleasecheck your email');
    }

    /**
     * Summary of resetPassword
     * Post /api/v1/customer/ResetPassword
     * @param ResetPasswordApiRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordApiRequest $request): JsonResponse
    {

        $this->customerApiService->resetPassword($request);

        return $this->success(null, 'Reset password successfully, Please login');
    }

    /**
     * Summary of resendVerificationEmail
     * Post /api/v1/customer/ResendVerificationEmail
     * @param ResendVerificationApiRequest $request
     * @return JsonResponse
     */
    public function resendVerificationEmail(ResendVerificationApiRequest $request): JsonResponse
    {

        $this->customerApiService->resendVerificationEmail($request->validated('email'));

        return $this->success(null, 'If the email exist and not verified, a verification email will be sent.');
    }

    /**
     * Summary of verifyEmail
     * Get /api/v1/customer/verify/{id}/{hash}
     * @param Request $request
     * @param int $id
     * @param string $hash
     * @return JsonResponse
     */
    public function verifyEmail(Request $request, int $id, string $hash): JsonResponse
    {
        $this->customerApiService->verifyEmail($id, $hash);

        return $this->success(null, 'Email verified successfully');

    }
}
