<?php

namespace App\Http\Requests\Table;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Aquí podrías agregar lógica de autorización si es necesario
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number'   => ['required', 'string', 'max:10', 'unique:tables,number'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'status'   => ['sometimes', 'in:available,occupied,reserved,maintenance'],
            'active'   => ['sometimes', 'boolean'],
        ];
    }

     public function messages(): array
    {
        return [
            'number.required'   => 'El número de mesa es obligatorio.',
            'number.unique'     => 'Ya existe una mesa con ese número.',
            'capacity.required' => 'La capacidad es obligatoria.',
            'capacity.min'      => 'La capacidad mínima es 1 persona.',
            'capacity.max'      => 'La capacidad máxima es 20 personas.',
            'status.in'         => 'El estado no es válido.',
        ];
    }
}
