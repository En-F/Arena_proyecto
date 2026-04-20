<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoraciones';

<<<<<<< HEAD
    protected $fillable = ['titulo', 'comentario', 'puntuacion', 'user_id', 'curso_id'];
=======
    protected $fillable = ['titulo', 'comentario', 'puntuacion', 'user_id', 'centro_id'];
>>>>>>> fb55ae0 (Intregración de las cookies)

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}
