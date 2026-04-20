<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $fillable = ['nombre', 'telefono', 'email', 'direccion', 'imagen', 'ubicacion'];

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function redesSociales()
    {
        return $this->hasMany(RedSocial::class);
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'centro_curso', 'centro_id', 'curso_id');
    }

    public function instalaciones()
    {
        return $this->belongsToMany(Instalacion::class, 'centro_instalacion', 'centro_id', 'instalacion_id');
    }

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'inscripcion', 'centro_id', 'user_id')->withTimestamps()->withPivot('fecha_alta');
    }
}
