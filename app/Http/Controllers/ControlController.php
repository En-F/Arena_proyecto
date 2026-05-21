<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

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

    public function historial()
    {
        // {
        //     $usuario = Auth::user();
        //     $hoy = Carbon::now();

        //     // 1. Reservas que vendrán (hoy o después)
        //     $proximas = $usuario->reservas()
        //         ->with('centro')
        //         ->where('fecha', '>=', $hoy->toDateString())
        //         ->orderBy('fecha', 'asc')
        //         ->get();

        //     // 2. Reservas que ya pasaron
        //     $pasadas = $usuario->reservas()
        //         ->with('centro')
        //         ->where('fecha', '<', $hoy->toDateString())
        //         ->orderBy('fecha', 'desc')
        //         ->get();

        //     // Enviamos los datos a la vista de React
        //     return Inertia::render('Settings/Historial', [
        //         'proximas' => $proximas,
        //         'pasadas' => $pasadas
        //     ]);
        // }
    }

    public function contacto () {
        return Inertia::render('Contacto/index');
    }

    public function enviarContacto(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:100',
            'email'   => 'required|email',
            'mensaje' => 'required|string|min:10',
        ]);

        $adminEmail = 'admin@admin.com';

        try {
            Mail::raw("Has recibido un nuevo mensaje de contacto:\n\n" .
                "Nombre: {$request->nombre}\n" .
                "Email: {$request->email}\n" .
                "Mensaje: {$request->mensaje}",
                function ($message) use ($adminEmail, $request) {
                    $message->to($adminEmail)
                            ->subject('NUEVO CONTACTO: ' . $request->nombre)
                            ->from($request->email, $request->nombre);
                }
            );

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
