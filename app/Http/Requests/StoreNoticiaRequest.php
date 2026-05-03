<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreNoticiaRequest extends FormRequest
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
            'titulo'    => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9À-ÿ\s]+$/'],
            'contenido' => ['required', 'string', 'regex:/^[a-zA-Z0-9À-ÿ\s\r\n]+$/'],
            'centro_id' => ['required', 'exists:centros,id'],
            'fecha'     => ['required', 'date'],
            'imagen'    => ['nullable', 'image', 'mimes:jpg,jpeg','max:2048'],
        ];
    }

    public function messages(): array
{
    return [
        'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpg, jpeg o png.',
        'imagen.max'   => 'La imagen es demasiado pesada (máximo 2MB).',
        'titulo.required' => '¡Oye! No olvides ponerle un título a la noticia.',
    ];
}
}
