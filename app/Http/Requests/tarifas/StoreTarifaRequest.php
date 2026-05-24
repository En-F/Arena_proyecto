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
            'descuento' => [
                'required',
                'integer',
                'min:0',
                'max:99'
            ],
            'periodo' => [
                'required',
                'string',
                Rule::in(['mes', 'trimestre', 'semestre', 'año'])
            ],
            'descripcion' => [
                'required',
                'string',
            ],
            'centro_id' => [
                'required',
                'exists:centros,id',
            ],
            
        ];
    }

}
