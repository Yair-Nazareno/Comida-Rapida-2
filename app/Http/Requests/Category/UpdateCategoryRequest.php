<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // ->id para obtener solo el número
        $categoryId = $this->route('category')->id;

        return [
            'name'   => ['sometimes', 'string', 'max:100', "unique:categories,name,{$categoryId}"],
            'active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Ya existe una categoría con ese nombre.',
            'name.max'    => 'El nombre no puede tener más de 100 caracteres.',
        ];
    }
}
