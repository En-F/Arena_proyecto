<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = ['titulo', 'contenido', 'imagen', 'user_id','es_activo','centro_id', 'fecha'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}
