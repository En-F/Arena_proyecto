<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedSocial extends Model
{
    protected $tabkle = 'redes_sociales';

    protected $fillable = ['nombre', 'imagen', 'url','centro_id'];

    public function centro(){
        return $this->belongsTo(Centro::class);
    }
}
