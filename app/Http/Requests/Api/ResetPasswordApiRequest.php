<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use App\Helper\ApiResponse;

class ResetPasswordApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()
            ],
            'token' => ['required','string'],
        ];
    }

    public function messages():array
    {
        return [
            'email.required' => 'Email is required',
            'email.exists' => 'Email does not exist',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.letters' => 'Password must contain at least one letter',
            'password.mixedCase' => 'Password must contain at least one uppercase and one lowercase letter',
            'password.numbers' => 'Password must contain at least one number',
            'token.required' => 'Token is required',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
       throw new HttpResponseException(
            ApiResponse::error(
                $validator->errors()
                ->first(), 422)

       );
    }
}
