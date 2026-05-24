<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $fillable = ['titulo', 'precio', 'descripcion', 'centro_id', 'periodo','tipo','descuento'];

    protected $casts = [
        'descripcion' => 'array',
        'precio' => 'decimal:2',
        'descuento' => 'integer'
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
