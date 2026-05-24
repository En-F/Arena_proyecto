<?php

namespace App\Http\Requests\tarifas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateTarifaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario_logeado = Auth::user();

        if ($usuario_logeado->Admin()) {
            return true;
        }

        if ($usuario_logeado->Jefe()) {
            $tarifa = $this->route('tarifa'); 
            return $usuario_logeado->centros->contains('id', $tarifa->centro_id);
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
            'tipo' => [
                'required',
                'string',
            ],
            'periodo' => [ 
                'required',
                'string',
                Rule::in(['mes', 'trimestre', 'semestre', 'año']), 
            ],
            'precio' => [
                'required',
                'numeric',   
                'min:0.01',
            ],
            'descuento' => [
                'required',
                'integer',
                'min:0',
                'max:99'
            ],
            'descripcion' => [
                'required',
                'string',
            ],
            'centro_id' => [
                'required',
                'exists:centros,id',
            ],
            'origen' => [
            'nullable',
            'string'
            ]
        ];
    }
}
