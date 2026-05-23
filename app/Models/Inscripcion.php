<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $fillable = [
    'user_id',
    'centro_id',
    'tarifa_id', 
    'fecha_alta',
    'fecha_inicio',
    'fecha_fin',
    'stripe_id',
    'status',
    'factura_url',
    'activo'
    ];

    protected $table = 'inscripciones';

    protected $casts = [
    'fecha_inicio' => 'date',
    'fecha_fin' => 'date',
    ];

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class, 'tarifa_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
