<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helper\ApiResponse;

class ForgotPasswordApiRequest extends FormRequest
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
            'email' => ['required', 'email','string'],
        ];
    }

    public function messages():array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
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
