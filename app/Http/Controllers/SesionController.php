<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;
use App\Http\Requests\sesiones\StoreSesionRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;




class SesionController extends Controller
{

    public function store(StoreSesionRequest $request)
    {
        $datos = $request->validated();
        dd($datos);


        $diaSemanaFecha = date('l', strtotime($request->fecha)); // Devuelve 'Monday', etc.

        Sesion::create($request->all());

        return redirect()->back();
    }
}
