<?php

namespace App\Http\Requests\sesiones;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreSesionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()->Admin() || Auth::user()->Jefe()) {
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
            'centro_id'    => 'required|exists:centros,id',
            'curso_id'     => 'required|exists:cursos,id',
            'actividad_id' => 'required|exists:actividades,id',
            'horario_id'   => 'required|exists:horarios,id',
            'fecha'        => 'required|date',
            'instructor'   => 'required|string|max:255',
            'cantidad'     => 'required|integer|min:1',
        ];
    }
}