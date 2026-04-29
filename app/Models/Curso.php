<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'imagen', 'video','es_activo'];

    public function beneficios()
    {
        return $this->belongsToMany(Beneficio::class, 'beneficio_curso', 'curso_id', 'beneficio_id');
    }

    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'centro_curso', 'curso_id', 'centro_id');
    }

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'actividad_curso', 'curso_id', 'actividad_id');
    }

    public function videos()
{
    return $this->morphToMany(Video::class, 'videoable');
}
}
