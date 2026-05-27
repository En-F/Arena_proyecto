<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoRecibidoMail;
use Illuminate\Support\Facades\Log;

class ControlController extends Controller
{
    public function create()
    {
        return Inertia::render('Login/login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/inicio');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/inicio');
    }

    public function socio(Request $request) {

    }

    public function contacto () {

        $usuario = Auth::user();

        return Inertia::render('Contacto/index', [
            'user_auth' => $usuario ? [
                'name'  => $usuario->name,
                'email' => $usuario->email,
            ] : null
        ]);
    }

    public function enviarContacto(Request $request)
    {
        $datos = $request->validate([
            'nombre'  => 'required|string|max:100',
            'email'   => 'required|email',
            'mensaje' => 'required|string|',
        ]);

        $destinatarios = [
            'admin@admin.com',
            'jefe@admin.com'
        ];

        try {
           Mail::to('admin@admin.com')
            ->cc('jefe@admin.com')
            ->send(new ContactoRecibidoMail($datos));

            return back();

        } catch (\Exception $e) {
            Log::error("Error enviando correo: " . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo enviar el mensaje.']);
        }
    }

    public function nosotros () {
        return Inertia::render('SNosotro/index');
    }


}