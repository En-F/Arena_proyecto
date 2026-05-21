<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $fillable = ['tipo'];

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'actividad_tipo');
    }
}
