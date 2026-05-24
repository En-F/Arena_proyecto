<?php

namespace App\Policies;

use App\Models\Sesion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SesionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sesion $sesion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sesion $sesion): bool
    {
        if ($user->Admin()) {
            return true;
        }
        if ($user->Jefe()) {
            return $user->centros()
                    ->where('centros.id', $sesion->centro_id)
                    ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sesion $sesion): bool
    {
        if ($user->Admin()) {
            return true;
        }
        if ($user->Jefe()) {
            return $user->centros()
                    ->where('centros.id', $sesion->centro_id)
                    ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Sesion $sesion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Sesion $sesion): bool
    {
        return false;
    }
}
