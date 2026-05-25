<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $fillable = [
        'titulo',
        'precio',
        'centro_id',
        'periodo',
        'tipo',
        'hora_inicio',
        'hora_fin',
        'reservas_semanales',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'descuento' => 'integer',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i'
    ];

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'tarifa_id');
    }
}
