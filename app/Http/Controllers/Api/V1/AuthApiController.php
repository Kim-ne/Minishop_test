<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Contracts\AuthApiServiceInterface;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\Api\ResetPasswordApiRequest;
use App\Http\Requests\Api\StoreUserApiRequest;
use App\Http\Requests\Api\ResendVerificationApiRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;



class AuthApiController extends BaseApiV1Controller
{
    public function __construct(
        protected AuthApiServiceInterface $authApiService
    ) {
    }

    /**
     * Summary of login
     * Post /api/v1/auth/login
     * @param LoginApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginApiRequest $request): JsonResponse
    {
        $data = $this->authApiService->login($request);

        return $this->success($data, 'Login successfully');
    }

    /**
     * Summary of logout
     * Post /api/v1/auth/logout
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
     * Get /api/v1/auth/me
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
     * Post /api/v1/auth/register
     * @param StoreUserApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserApiRequest $request): JsonResponse
    {
        $this->authApiService->register($request);

        return $this->success(null, 'Register successfully');
    }

    /**
     * Summary of forgotPassword
     * Post /api/v1/auth/ForgotPassword
     * @param ForgotPasswordApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(ForgotPasswordApiRequest $request): JsonResponse
    {

        $this->authApiService->forgotPassword($request);

        return $this->success(null, 'if email exist, pleasecheck your email');
    }

    /**
     * Summary of showResetPassword
     * Get /api/v1/auth/ResetPassword
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showResetPassword(Request $request): JsonResponse
    {
        $email = $request->query('email');
        $token = $request->query('token');

        if(!$email || !$token)
        {
            return $this->error(null, 'Invalid or expired reset password link', 400);
        }

        try{
            $isValid = $this->authApiService->isValidResetToken($email, $token);

            if(!$isValid)
            {
                return $this->error(null, 'Invalid or expired reset password link', 400);
            }

            return $this->success(['email' => $email,
                                    'token' => $token,
                                    'Valid' => true], 'Reset Password link is valid');
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 400);
        }
    }
    /**
     * Summary of resetPassword
     * Post /api/v1/auth/ResetPassword
     * @param ResetPasswordApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(ResetPasswordApiRequest $request): JsonResponse
    {
        $this->authApiService->resetPassword($request);

        return $this->success(null, 'Reset password successfully, Please login');
    }

    /**
     * Summary of resendVerificationEmail
     * Post /api/v1/auth/resend
     * @param ResendVerificationApiRequest $request
     * @return JsonResponse
     */
    public function resendVerificationEmail(ResendVerificationApiRequest $request): JsonResponse
    {
        $this->authApiService->resendVerificationEmail($request->validated('email'));

        return $this->success(null, 'If the email exist and not verified, a verification email will be sent.');
    }

    /**
     * Summary of verifyEmail
     * Get /api/v1/auth/verify/{id}/{hash}
     * @param Request $request
     * @param int $id
     * @param string $hash
     * @return JsonResponse
     */
    public function verifyEmail(Request $request, int $id, string $hash): JsonResponse
    {

        $this->authApiService->verifyEmail($id, $hash);

        return $this->success(null, 'Email verified successfully, Please login');
    }
}
