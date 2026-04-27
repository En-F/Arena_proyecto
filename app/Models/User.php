<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'dni'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',

        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'user_id', 'rol_id');
    }

    public function Admin(): bool
    {
        return $this->roles->contains('rol', 'admin');
    }

    public function Jefe(): bool
    {
        return $this->roles->contains('rol', 'jefe');
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'inscripcion', 'user_id', 'centro_id')->withPivot('fecha_alta')->withTimestamps();
    }


    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'favorito', 'user_id', 'actividad_id')->withTimestamps();
    }
}
