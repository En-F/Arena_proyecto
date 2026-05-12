<?php

namespace App\Policies;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;



class CursoPolicy
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
    public function view(User $user, Curso $curso): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user && ($user->Admin() || $user->Jefe())){
            return true;
        } 
        return false;
    
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Curso $curso): bool
    {
        if ($user->Admin()){
            return true;
        } 

        if ($user->Jefe()) {

        $misCentrosIds = $user->centros->pluck('id')->toArray();
        
        return $curso->centros()
                     ->whereIn('centros.id', $misCentrosIds)
                     ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Curso $curso): bool
    {
       if ($user->Admin()){
            return true;
        } 

        if ($user->Jefe()) {

        $misCentrosIds = $user->centros->pluck('id')->toArray();
        
        return $curso->centros()
                     ->whereIn('centros.id', $misCentrosIds)
                     ->exists();
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Curso $curso): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Curso $curso): bool
    {
        return false;
    }
}
