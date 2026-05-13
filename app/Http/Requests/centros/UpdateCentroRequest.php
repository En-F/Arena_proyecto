<?php

namespace App\Http\Requests\centros;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCentroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
        'nombre' => [
            'required',
            'string',
            'regex:/^[a-zA-ZÀ-ÿ0-9\s\+]+$/',
            'max:255',
        ],
        'telefono' => [
            'required',
            'string',
            'regex:/^[0-9\s]+$/',
        ],
        'email' => [
            'required',
            'email',
            'max:255',
        ],
        'direccion' => [
            'required',
            'string',
            'max:500',
        ],
        'descripcion' => [
            'required',
            'string',
        ],
        'es_activo' => [
            'required',
            'boolean',
        ],
        'imagen' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png',
            'max:2048',
        ],
        'latitud' => [
            'nullable',
            'numeric',
            'between:-90,90',
        ],
        'longitud' => [
            'nullable',
            'numeric',
            'between:-180,180',
        ],
    ];
    }

    public function messages(): array
    {
        return [
            'nombre.regex' => 'El nombre mantiene un formato no válido.',
            'email.email'  => 'Introduce una dirección de correo real.',
        ];
    }
}
