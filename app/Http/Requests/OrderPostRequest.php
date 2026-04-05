<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderPostRequest extends FormRequest
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
            'firstname' => 'required|max:50|min:2',
            'lastname' => 'required|max:50|min:2',
            'email' => 'required|email|max:50',
            'phone' => 'required|numeric|digits_between:9,15',
            'address' => 'required|max:100',
            'country' => 'required|max:50|string',
            'state' => 'required|string|max:50',
            'city'  => 'required|string|max:50',
            'zipcode' => 'numeric|digits_between:4,10',
            'payment_method' => ['required', Rule::in(['COD', 'BT', 'PP'])]
        ];
    }
}
