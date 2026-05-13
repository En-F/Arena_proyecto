<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use App\Models\Curso;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class BeneficioController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       $this->authorize('create', Beneficio::class);

        $curso_id = $request->curso;
        return Inertia::render('Beneficio/create',['curso'=> $curso_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            'descripcion' => ['required', 'string'],
            'curso_id' => ['required', 'exists:cursos,id']
        ]);
        $cursoId = $datos['curso_id'];

        $beneficio = Beneficio::create([
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
        ]);

        $beneficio->cursos()->sync($cursoId);

        return redirect()->route('cursos.show',$cursoId);

    }

    /**
     * Display the specified resource.
     */
    public function show(Beneficio $beneficio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beneficio $beneficio,Request $request)
    {
        $this->authorize('update', $beneficio);

        $cursoId = $request->input('curso_id');

        return Inertia::render('Beneficio/edit',
        ['beneficio'=> $beneficio,
        'curso'=> $cursoId]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beneficio $beneficio)
    {

        $this->authorize('update', $beneficio);
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            'descripcion' => ['required', 'string'],
            'curso_id' => ['required', 'exists:cursos,id']
        ]);

        $beneficio->update($datos);

        return redirect()->route('cursos.show',$datos['curso_id']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beneficio $beneficio,Request $request)
    {
        $this->authorize('delete', $beneficio);

        $cursoId = $request->input('curso');

        if ($cursoId) {
            $beneficio->cursos()->detach($cursoId);

            return redirect()->back();
        }
        return redirect()->back();
    }

    public function biblioteca(Request $request){

        $cursoId = $request->query('curso_id');

        $curso = Curso::findOrFail($cursoId);

        $this->authorize('update', $curso);

        $beneficiosDisponibles = Beneficio::whereDoesntHave('cursos', function ($query) use ($cursoId) {
            $query->where('cursos.id', $cursoId);
        })->get();

        return Inertia::render('Beneficio/biblioteca', [
            'curso' => $curso,
            'beneficios' => $beneficiosDisponibles
        ]);

    }

    public function asociar(Request $request, Curso $curso) {

        $this->authorize('update', $curso);

        $request->validate([
        'beneficio_id' => ['required', 'exists:beneficios,id'],
        ]);

        $curso->beneficios()->syncWithoutDetaching([$request->input('beneficio_id')]);
        return redirect()->route('cursos.show', $curso->id);

    }
}
