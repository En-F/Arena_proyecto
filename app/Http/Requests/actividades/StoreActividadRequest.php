<?php

namespace App\Http\Requests\actividades;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreActividadRequest extends FormRequest
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
            'nombre'    => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s\'"]+$/'],
            'nivel' => ['required', 'string'],
            'descripcion' => ['required', 'string'],
            'imagen'    => ['nullable', 'image', 'mimes:jpg,jpeg,png','max:2048'],
            'tipo_id' => ['required', 'exists:tipos,id'],
            'cursos_ids' => ['required', 'array', 'min:1'],
            'cursos_ids.*' => ['exists:cursos,id'],
            'es_activo' => ['required', 'in:true,false,1,0,on,off']
        ];
    }

    public function messages(): array
{
    return [
        'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpg, jpeg o png.',
        'imagen.max'   => 'La imagen es demasiado pesada (máximo 2MB).',
        'nombre.required' => '¡Oye! No olvides ponerle un título a la actividad.',
        'cursos_ids.required' => 'Debes seleccionar al menos un centro para esta actividad.',
        'nivel.required'   => 'Indica si la actividad es fácil, intermedia o difícil.',
    ];
    }
}
