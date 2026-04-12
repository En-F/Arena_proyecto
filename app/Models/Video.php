<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = ['url'];

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'actividad_video', 'video_id', 'actividad_id');
    }   
}
