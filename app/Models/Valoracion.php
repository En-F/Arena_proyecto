<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoraciones';

    protected $fillable = ['titulo', 'comentario', 'puntuacion', 'user_id', 'centro_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}
