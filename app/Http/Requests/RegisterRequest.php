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
            'firstname' => 'required|min:4|max:50',
            'lastname' => 'required|min:4|max:50',
            'email' => 'required|email|confirmed|unique:customers,email|unique:users,email|max:100',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()
            ],
            'password_confirmation' => 'required|same:password',
            'email_confirmation' => 'required|email|same:email',
            'phone' => 'digits_between:9,15|nullable',
            'country'=>'max:50|min:2|string|nullable',
            'address'=>'max:255|min:5|string|nullable',
            'city'=>'max:100|min:2|string|nullable',
            'state'=>'max:100|min:2|string|nullable',
            'zipcode'=>'digits_between:5,10|numeric',
            'ship_firstname' => 'min:4|max:50|string|nullable',
            'ship_lastname' => 'min:4|max:50|string|nullable',
            'ship_email' => 'email|nullable',
            'ship_phone' => 'digits_between:9,15|nullable',
            'ship_country'=>'max:50|min:2|string|nullable',
            'ship_address'=>'max:255|min:5|string|nullable',
            'ship_city'=>'max:100|min:2|string|nullable',
            'ship_zipcode'=>'digits_between:5,10|numeric',
            'notes' => 'max:255|string|nullable',
            'status' => 'default:1|integer|in:0,1',
        ];
    }
}
