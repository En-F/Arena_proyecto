<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'imagen','video'];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'beneficio_curso', 'beneficio_id', 'curso_id');
    }
}
