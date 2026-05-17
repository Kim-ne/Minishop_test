<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('id'); // Get the product ID from the route parameter

        return [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'qty'         => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku'         => 'nullable|string|max:100|unique:products,sku,' . $productId,
            'keywords'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:0,1',
            'featured'    => 'nullable|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}

