<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BuscarUsuarioRequest extends FormRequest
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
            'nombre' => 'nullable|string|max:100',
            'email' => 'nullable|string|max:100',
            'dni' => 'nullable|string|max:20',
            'centro_id' => 'nullable|integer|exists:centros,id',
            'activo' => 'nullable|boolean',
        ];
    }
    public function messages(): array
{
    return [
            'nombre.max' => 'La búsqueda no puede exceder 50 caracteres',
            'email.max' => 'El email no puede exceder 50 caracteres',
            'dni.max' => 'El DNI no puede exceder 20 caracteres',
            'centro_id.exists' => 'El centro seleccionado no existe',
        ];
}
}