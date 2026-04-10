<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{

    protected $fillable = ['titulo', 'contenido', 'imagen', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
