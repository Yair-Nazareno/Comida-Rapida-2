<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'name'        => ['sometimes', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'price'       => ['sometimes', 'numeric', 'min:0.01'],
            'image_url'   => ['nullable', 'url'],
            'available'   => ['sometimes', 'boolean'],
        ];
    }
}
