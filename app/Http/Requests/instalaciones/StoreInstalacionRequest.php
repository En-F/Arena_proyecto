<?php

namespace App\Http\Requests\instalaciones;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreInstalacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario_logeado = Auth::user();
        if ($usuario_logeado->Admin() || $usuario_logeado->Jefe()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'    => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ0-9\s]+$/'],
            'imagen'    => ['required'],
            'centros_ids' => ['nullable', 'array'],
            'centros_ids.*' => ['exists:centros,id'],
            'es_activo' => ['required', 'in:true,false,1,0,on,off']
        ];
    }

    public function messages(): array
{
    return [
        'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpg, jpeg o png.',
        'imagen.max'   => 'La imagen es demasiado pesada (máximo 2MB).',
        'nombre.required' => '¡Oye! No olvides ponerle un título a la instalacion.',
        'centros_ids.required' => 'Debes seleccionar al menos un centro para esta instalacion.',
        'nombre.unique' => 'Ya existe una instalacion con el mismo nombre.',
    ];
    }
}
