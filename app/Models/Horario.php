<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['dia', 'hora_inicio', 'hora_fin','estado'];

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }

    


}
