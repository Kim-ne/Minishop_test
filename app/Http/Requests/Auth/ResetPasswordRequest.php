<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class ResetPasswordRequest extends FormRequest
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
                'confirmed',
                'string',
                Password::min(8)->letters()->mixedCase()->numbers()
            ],
            'token' => ['required','string'],
        ];
    }

    public function messages():array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.letters' => 'Password must contain at least one letter',
            'password.mixedCase' => 'Password must contain at least one uppercase and one lowercase letter',
            'password.numbers' => 'Password must contain at least one number',
            'token.required' => 'Token is required',
        ];
    }
}
