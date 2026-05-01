<?php

namespace App\Http\Requests\Table;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tableId = $this->route('table')->id;

        return [
            'number'   => ['sometimes', 'string', 'max:10', "unique:tables,number,{$tableId}"],
            'capacity' => ['sometimes', 'integer', 'min:1', 'max:20'],
            'active'   => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'number.unique'  => 'Ya existe una mesa con ese número.',
            'capacity.min'   => 'La capacidad mínima es 1 persona.',
            'capacity.max'   => 'La capacidad máxima es 20 personas.',
        ];
    }
}
