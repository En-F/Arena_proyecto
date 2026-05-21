<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = ['titulo', 'url'];

    public function cursos()
    {
        return $this->morphedByMany(Curso::class, 'videoable');
    }

    public function actividades()
    {
        return $this->morphedByMany(Actividad::class, 'videoable');
    }
}