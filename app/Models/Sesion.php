<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesion';

    protected $fillable = ['horario_id', 'centro_id', 'actividad_id', 'curso_id', 'capacidad', 'fecha'];

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
