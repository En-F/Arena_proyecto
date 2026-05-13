<?php

namespace App\Http\Requests\cursos;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCursoRequest extends FormRequest
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
            'nombre'    => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            'descripcion' => ['required', 'string'],
            'imagen'    => ['nullable', 'image', 'mimes:jpg,jpeg,png','max:2048'],
            'centros_ids' => ['required', 'array', 'min:1'],
            'centros_ids.*' => ['exists:centros,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpg, jpeg o png.',
            'imagen.max'   => 'La imagen es demasiado pesada (máximo 2MB).',
            'nombre.required' => '¡Oye! No olvides ponerle un título a la actividad.',
            'centros_ids.required' => 'Debes seleccionar al menos un centro para este curso.',
        ];
    }
}
