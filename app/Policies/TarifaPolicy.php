<?php

namespace App\Policies;

use App\Models\Tarifa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TarifaPolicy
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
    public function view(User $user, Tarifa $tarifa): bool
    {
        return false;
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
    public function update(User $user, Tarifa $tarifa): bool
    {
        if ($user->Admin()) {
            return true;
        }
        return $user->centros->contains('id', $tarifa->centro_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tarifa $tarifa): bool
    {
       if ($user->Admin()) {
            return true;
        }

        return $user->centros->contains('id', $tarifa->centro_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tarifa $tarifa): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tarifa $tarifa): bool
    {
        return false;
    }
}
