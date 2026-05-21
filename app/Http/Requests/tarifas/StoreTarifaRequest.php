<?php

namespace App\Http\Requests\tarifas;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


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
                'decimal:0,2',
                'min:0',
            ],
            'periodo' => [
                'required',
                'string',
                'regex:/^[a-zA-ZÀ-ÿ]+$/'
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
