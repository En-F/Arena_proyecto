<?php

namespace App\Policies;

use App\Models\Beneficio;
use App\Models\User;
use App\Models\Curso;
use Illuminate\Auth\Access\Response;

class BeneficioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Beneficio $beneficio): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->Admin() || $user->Jefe();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Beneficio $beneficio): bool
    {
        if ($user->Admin()){
            return true;
        } 

        if ($user->Jefe()) {
            $cursosIds = Curso::whereHas('centros', function ($query) use ($user) {
                $query->whereIn('centros.id', $user->centros->pluck('id'));
            })->pluck('id');

        return $beneficio->cursos()
            ->whereIn('cursos.id', $cursosIds)
            ->exists();
            dd($beneficio);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Beneficio $beneficio): bool
    {
       if ($user->Admin()) return true;

        $cursoId = request()->input('curso_id');

        if ($cursoId) {
            $curso = \App\Models\Curso::find($cursoId);
            return $user->centros->contains($curso->centros()->first()->id);
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Beneficio $beneficio): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Beneficio $beneficio): bool
    {
        return false;
    }
}
