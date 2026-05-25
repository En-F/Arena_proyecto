<?php

namespace App\Http\Requests\tarifas;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class StoreTarifaRequest extends FormRequest
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


    protected function prepareForValidation()
    {
        $this->merge([
            'hora_inicio' => $this->hora_inicio ? substr($this->hora_inicio, 0, 5) : null,
            'hora_fin'    => $this->hora_fin ? substr($this->hora_fin, 0, 5) : null,
        ]);
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo' => [
                'required',
                'string',
            ],
            'precio' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'hora_inicio' => [
                'required',
                'date_format:H:i',
            ],
            'hora_fin' => [
                'required',
                'date_format:H:i',
                'after:hora_inicio'
            ],
            'reservas_semanales' => [
                'required',
                'integer',
                'min:0'
            ],
            'periodo' => [
                'required',
                'string',
                Rule::in(['mes', 'trimestre', 'semestre', 'año'])
            ],
            'centro_id' => [
                'required',
                'exists:centros,id',
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'hora_fin.after' => 'La hora de fin no puede ser menor o igual a la hora de inicio.',
            'hora_inicio.required' => 'Debes indicar una hora de apertura.',
            'hora_fin.required' => 'Debes indicar una hora de cierre.',
            'hora_fin.date_format' => 'El formato de hora de cierre no es válido.',
        ];
    }

}