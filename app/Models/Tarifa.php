<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
<<<<<<< HEAD
    protected $fillable = ['titulo', 'precio', 'tipo', 'descripcion', 'centro_id'];
=======
    protected $fillable = ['titulo', 'precio', 'descripcion', 'centro_id'];
>>>>>>> fb55ae0 (Intregración de las cookies)

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}
