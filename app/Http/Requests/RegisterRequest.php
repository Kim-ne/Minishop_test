<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:4|max:50',
            'email' => 'required|email|confirmed|unique:users,email|max:100',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()
            ],
            'password_confirmation' => 'required|same:password',
            'email_confirmation' => 'required|email|same:email',
            'phone' => 'digits_between:9,15|nullable',
            'country'=>'max:50|min:2|string|nullable',
        ];
    }
}
