<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UsuarioRegistradoMail;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ],[
            'name.regex' => 'El nombre debe empezar con Mayúscula y no contener números.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido (ejemplo: usuario@correo.com).',
            'email.unique' => 'Este correo ya está registrado en el equipo.',
            'email.max' => 'El correo es demasiado largo.',


            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.letters' => 'La contraseña debe incluir al menos una letra.',
            'password.mixed' => 'La contraseña debe tener mayúsculas y minúsculas.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
            'password.symbols' => 'La contraseña debe incluir al menos un símbolo especial.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ])->validate();

        $usuario =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

       $rol = Rol::where('rol', 'registrado')->first();

        if ($rol) {
            $usuario->roles()->attach($rol->id);
        }

        Mail::to($usuario->email)->send(new UsuarioRegistradoMail($usuario));

        return $usuario;

    }
    public function messages(): array
    {
        return [
            'name.regex' => 'El nombre debe empezar por mayúscula y no contener números.',
            'email.email' => 'Por favor, introduce un correo electrónico válido.',
            'password.regex' => 'La contraseña no cumple con los requisitos de seguridad.',
        ];
    }

}