<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = ['user_id', 'sesion_id', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }
}
