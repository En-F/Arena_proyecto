<?php

namespace App\Policies;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoticiaPolicy
{
    use HandlesAuthorization;

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
    public function view(User $user, Noticia $noticia): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Simplificado: retorna true si es admin o jefe
        return $user->Admin() || $user->Jefe();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Noticia $noticia): bool
    {
        if ($user->Admin()) {
            return true;
        }

        return $user->id === $noticia->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Noticia $noticia): bool
    {
        if ($user->Admin()) {
            return true;
        }

        return $user->id === $noticia->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Noticia $noticia): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Noticia $noticia): bool
    {
        return false;
    }
}