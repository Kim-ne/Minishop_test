<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InfoUpdateRequest extends FormRequest
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
            'phone' => 'nullable|numeric|digits_between:9,15',
            'country' => [Rule::in(['Germany', 'Canada', 'Usa', 'Aus']),'nullable'],
            'company' => 'max:100|min:2|string|nullable',
            'address' => 'max:255|min:5|string|nullable',
            'first_name' => 'max:50|min:2|string|nullable',
            'last_name' => 'max:50|min:2|string|nullable',
            'city' => 'max:100|min:2|string|nullable',
            'Postal_code' => 'digits_between:5,10|numeric|nullable',
            'about_me' => 'max:255|min:10|string|nullable',
            'avartar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ];
    }
}
