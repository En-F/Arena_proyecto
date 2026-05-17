<?php

namespace App\Http\Requests\usuarios;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
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
        $usuarioId = $this->route('usuario');

        return [
            'name'    => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZÀ-ÿ0-9\s]+$/'],
            'email'    => [
                'required', 
                'string', 
                'email', 
                'max:50', 
                Rule::unique('users', 'email')->ignore($usuarioId) 
            ],
            'dni'      => [
                'nullable', 
                'string', 
                'max:20', 
                Rule::unique('users', 'dni')->ignore($usuarioId)
            ],
            
            'telefono' => ['nullable', 'string', 'max:20'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'     => 'El nombre es obligatorio.',
            'name.max'          => 'El nombre no puede exceder los 50 caracteres.',
            'name.regex'        => 'El nombre solo puede contener letras y espacios.',
            
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Por favor, introduce un correo electrónico válido.',
            'email.max'         => 'El correo electrónico no puede exceder los 50 caracteres.',
            'email.unique'      => 'Este correo electrónico ya está registrado por otro usuario.',
            
            'dni.max'           => 'El DNI no puede exceder los 20 caracteres.',
            'dni.unique'        => 'Este DNI ya está registrado por otro usuario.',
            
            'telefono.max'      => 'El teléfono no puede exceder los 20 caracteres.',
        ];
    }
}
