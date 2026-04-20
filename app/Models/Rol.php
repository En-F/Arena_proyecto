<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = ['nombre'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'usuario_rol', 'rol_id', 'user_id');
    }
}
