<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'price'       => ['required', 'numeric', 'min:0.01'],
            'image_url'   => ['nullable', 'url'],
            'available'   => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'El nombre del producto es obligatorio.',
            'price.required'     => 'El precio es obligatorio.',
            'price.numeric'      => 'El precio debe ser un número.',
            'price.min'          => 'El precio debe ser mayor a 0.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'image_url.url'      => 'La imagen debe ser una URL válida.',
        ];
    }
}
