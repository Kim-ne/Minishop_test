<?php

namespace App\Services;


use App\Models\Customer;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Services\Contracts\CustomerApiServiceInterface;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Api\ForgotPasswordApiRequest;
use App\Http\Requests\Api\ResetPasswordApiRequest;
use App\Http\Requests\Api\LoginApiRequest;
use App\Models\User;
use App\Events\CustomerRegistered;
use App\Events\CustomerForgotPassword;
use App\Events\CustomerEmailVerification;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CustomerApiService implements CustomerApiServiceInterface
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ){}
    /**
     * Summary of index
     * Get /api/v1/customer
     * @return Collection
     */
    public function index(): Collection
    {
        $customers = Customer::forStatus();

        return $customers;
    }

    /**
     * Summary of login
     * Post /api/v1/customer/login
     * @param LoginApiRequest $request
     * @return array
     */
    public function login(LoginApiRequest $request): array
    {
        $credentials = $request->only(['email', 'password']);
        $attempted = Auth::guard('buyer')->attempt($credentials);


        if (!$attempted) {
            throw new \Exception('Invalid email or password.', 401);
        }

        $customer = Auth::guard('buyer')->user();

        if (!$customer) {
            throw new \Exception('User not found after authentication.', 500);
        }

        if(!$customer->hasVerifiedEmail())
        {
            Auth::guard('buyer')->logout();
            throw new \Exception('Please verify your email before logging.', 40);
        }

        $customer->tokens()->delete();
        $remember = $request->boolean('remember');


        $token = $remember
                ? $customer->createToken('api-token')->plainTextToken
                : $customer->createToken('api-token', ['*'], now()->addMinutes(120))->plainTextToken;

        return [
            'token'      => $token,
            'token_type' => 'Bearer',
            'expires_at' => $remember ? null : now()->addMinutes(120)->toDateTimeString(),
            'user'       => [
                'id'    => $customer->id,
                'name'  => $customer->name,
                'email' => $customer->email,
            ],
        ];
    }

    /**
     * Summary of logout
     * Post /api/v1/customer/logout
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }

    /**
     * Summary of toggleStatus
     * Put /api/v1/customer/{id}
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
     * Put /api/v1/customer/{id}
     * @param int $id
     * @return Customer
     */

    public function show(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    /**
     * Summary of destroy
     * Delete /api/v1/customer/{id}
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
     * Post /api/v1/customer/register
     * @param RegisterRequest $request
     * @return void
     */
    public function register(RegisterRequest $request): void
    {
        $validated = $request->validated();

        if(User::emailExists($validated['email']))
        {
            throw new \Exception('Email already exists', 403);
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

        CustomerEmailVerification::dispatch($customer);

    }

    /**
     * Sumary forgot password
     * Post /api/v1/customer/ForgotPassword
     * @param ForgotPasswordApiRequest $request
     * @return void
     */
    public function forgotPassword(ForgotPasswordApiRequest $request): void
    {
        $validated = $request->validated();
        $Customer = Customer::where('email', $validated['email'])->first();

        if(!$Customer)
        {
            return;
        }

        $token = Str::random(64);
        $this->authRepository->createToken($Customer->email, $token);

        CustomerForgotPassword::dispatch($Customer, $token);
    }

    /**
     * Summary of resetPassword
     * Post /api/v1/customer/ResetPassword
     * @param ResetPasswordApiRequest $request
     * @return void
     */
    public function resetPassword(ResetPasswordApiRequest $request): void
    {
        $validated = $request->validated();
        $record =$this->authRepository->findByEmailAndTokens($validated['email'], $validated['token']);

        if(!$record)
        {
            throw new \Exception('Token not found or expired', 400);
        }

        $customer = Customer::where('email', $validated['email'])->first();

        if(!$customer)
        {
            throw new \Exception('Customer not found', 404);
        }

        $customer->update(['password' => $validated['password']]);

        $this->authRepository->deleteByEmail($validated['email']);
    }

    /**
     * Summary of resendVerificationEmail
     * Post /api/v1/customer/ResendVerificationEmail
     * @param string $email
     * @return void
     */
    public function resendVerificationEmail(string $email): void
    {
        $customer = Customer::where('email', $email)->first();

        if(!$customer || $customer->hasVerifiedEmail())
        {
            return;
        }

        CustomerEmailVerification::dispatch($customer);
    }

    /**
     * Summary of verifyEmail
     * Get /api/v1/customer/verify/{id}/{hash}
     * @param int $id
     * @param string $hash
     * @return void
     */
    public function verifyEmail(int $id, string $hash): void
    {
        $customer = Customer::findOrFail($id);

        if(! hash_equals($hash, sha1($customer->email)))
        {
            throw new \Exception('Invalid verification link', 400);
        }

        if($customer->hasVerifiedEmail())
        {
            throw new \Exception('Email already verified', 400);
        }

        $customer->markEmailAsVerified();

        CustomerRegistered::dispatch($customer);
    }
}

