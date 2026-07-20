<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerPasswordUpdateRequest extends FormRequest
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
            'current_password' =>
                        ['required',
                        'current_password:customer',
                        ],
            'password' =>
                        ['required',
                        'confirmed',
                        Password::min(8)->letters()->mixedCase()->numbers()],
            'password_confirmation' => 'required|same:password',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        if(request()->is('profile/password'))
        {
            $redirectRoute = 'profile';
            $redirectParams = ['tab' => 'password'];
        } else {
            $redirectRoute = 'userProfile';
            $redirectParams = ['tab' => 'password'];
        }

        throw new HttpResponseException(
            redirect()
                ->route($redirectRoute, $redirectParams)
                ->withErrors($validator)
                ->withInput()
        );
    }

}
