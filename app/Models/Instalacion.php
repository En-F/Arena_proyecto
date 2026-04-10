<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instalacion extends Model
{
    protected $table = 'instalaciones';
    
    protected $fillable = ['nombre', 'imagen'];

    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'centro_instalacion', 'instalacion_id', 'centro_id');
    }
}
