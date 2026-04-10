<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $fillable = ['titulo', 'precio', 'tipo', 'descripcion', 'centro_id'];

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}
