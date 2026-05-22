<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class StoreSocioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $regexPassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/';
        $regexDni = '/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';
        $regexTelefono = '/^[6789]\d{8}$/';

        $rules = [
            'centro_id' => ['required', 'exists:centros,id'],
            'tarifa_id' => ['required', 'exists:tarifas,id'],
            'dni'       => ['required', 'string', 'regex:' . $regexDni],
            'telefono'  => ['required', 'string', 'regex:' . $regexTelefono],
        ];

        if (!Auth::check()) {
            $rules['name']     = 'required|string|max:255';
            $rules['email']    = 'required|email|unique:users,email';
            $rules['password'] = ['required', 'confirmed', 'regex:' . $regexPassword];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'dni.regex'      => 'El DNI no tiene un formato válido (8 números y letra).',
            'password.regex' => 'La clave debe tener 8 caracteres, una mayúscula, una minúscula y un símbolo.',
            'email.unique'   => 'Este correo ya está registrado, por favor inicia sesión.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->dni && !$this->validarLetraDNI($this->dni)) {
                $validator->errors()->add('dni', 'La letra del DNI no corresponde al número proporcionado.');
            }
        });
    }

    private function validarLetraDNI($dni) {
        $letra = strtoupper(substr($dni, -1));
        $numeros = substr($dni, 0, 8);
        if(!is_numeric($numeros)) return false;
        return $letra === substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1);
    }
}