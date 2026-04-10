<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';  

    protected $fillable = ['titulo', 'duracion', 'nivel', 'descripcion', 'imagen', 'video'];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'actividad_curso', 'actividad_id', 'curso_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorito', 'actividad_id', 'user_id');
    }
    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'actividad_id'); 
    }
    

}
