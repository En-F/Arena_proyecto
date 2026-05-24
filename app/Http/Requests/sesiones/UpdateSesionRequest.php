<?php

namespace App\Http\Requests\sesiones;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class UpdateSesionRequest extends FormRequest
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
            'centro_id'    => 'required',
            'curso_id'     => 'required',
            'actividad_id' => 'required',
            'horario_id'   => 'required',
            'fecha'        => 'required|date',
            'capacidad'    => 'required|integer|min:1',
        ];
    }
}