<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user_id = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'dni' => '12345678A',
        ]);


        /////////// CENTROS //////////
        $centro_1 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro Ok+',
            'descripcion' => 'Un centro de aguas libres con instalaciones modernas y un equipo de entrenadores profesionales para ayudarte a alcanzar tus objetivos de fitness.',
            'direccion' => 'Avenida de la Rondeña, s/n',
            'telefono' => '234857432',
            'imagen' => '/images/centros/1.jpg',
            'email' => 'piscina@olimpiica.com'    
        ]);

        $centro_2 = DB::table('centros')->insertGetId([
            'nombre' => 'Gimnasio FitLife',
            'descripcion' => 'Un gimnasio equipado con las últimas máquinas de entrenamiento y un equipo de entrenadores profesionales para ayudarte a alcanzar tus objetivos de fitness.',
            'direccion' => 'Avenida del Deporte, 456',
            'telefono' => '989384321',
            'imagen' => '/images/centros/2.jpg',
            'email' => 'gimnasio@gim.com'   
        ]);

        $centro_3 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro de Actividades al aire libre',
            'descripcion' => 'Un centro de actividades al aire libre con una amplia variedad de actividades para disfrutar en la naturaleza, como senderismo, ciclismo y escalada.',
            'direccion' => 'Parque Natural, 123',
            'telefono' => '345678901',
            'imagen' => '/images/centros/3.jpg',
            'email' => 'airelibre@actividades.com'   
        ]);

        $centro_4 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro de Atletismo Alberto Nuñez',
            'descripcion' => 'Un centro de atletismo con instalaciones modernas y un equipo de entrenadores profesionales para ayudarte a alcanzar tus objetivos de fitness.',
            'direccion' => 'Calle del Atletismo, 456',
            'telefono' => '127958421',
            'imagen' => '/images/centros/4.jpg',
            'email' => 'atletismo@atletismo.com'   
        ]);

        $centro_5 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro de pilates Maria Luisa',
            'descripcion' => 'Un centro de pilates con instalaciones modernas y un equipo de entrenadores profesionales para ayudarte a alcanzar tus objetivos de fitness.',
            'direccion' => 'Calle del Pilates, 456',
            'telefono' => '987958121',
            'imagen' => '/images/centros/5.jpg',
            'email' => 'pilates@pilates.com'   
        ]);

        $centro_6 = DB::table('centros')->insertGetId([
            'nombre' => 'Polideportivo Marco Aurelio',
            'descripcion' => 'Polideportivo que ofrece una amplia variedad de instalaciones deportes para todos los niveles y para todas las edades.',
            'direccion' => 'Calle del Atletismo, 456, Ciudad',
            'telefono' => '981258421',
            'imagen' => '/images/centros/6.jpg',
            'email' => 'polideportivo@polideportivo.com'   
        ]);




        /////////// ACTIVIDADES //////////

        $actividad_1 = DB::table('actividades')->insertGetId([
            'titulo' => 'Natación',
            'descripcion' => 'Una actividad acuática que consiste en nadar en una piscina o en aguas abiertas.',
            'imagen' => '/images/actividades/1.jpg',
            'duracion' => 60,
            'nivel' => 'Medio'
        ]);

        $actividad_2= DB::table('actividades')->insertGetId([
            'titulo' => 'Ciclismo',
            'descripcion' => 'Una actividad que consiste en pedalear en una bicicleta.',
            'imagen' => '/images/actividades/2.jpg',
            'duracion' => 30,
            'nivel' => 'Principiante'
        ]);

        $actividad_3= DB::table('actividades')->insertGetId([
            'titulo' => 'Futbol',
            'descripcion' => 'Una actividad que consiste en jugar al futbol.',
            'imagen' => '/images/actividades/3.jpg',
            'duracion' => 90,
            'nivel' => 'Medio'
        ]);

        $actividad_4= DB::table('actividades')->insertGetId([
            'titulo' => 'Atletismo',
            'descripcion' => 'Una actividad que consiste en practicar atletismo.',
            'imagen' => '/images/actividades/4.jpg',
            'duracion' => 60,
            'nivel' => 'Principiante'
        ]);

        


        /////////// NOTICIAS //////////
        $noticia_1 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nueva piscina olímpica en la ciudad',
            'contenido' => 'La ciudad ha inaugurado una nueva piscina olímpica que cuenta con instalaciones de última generación y un equipo de entrenadores profesionales para ayudar a los nadadores a alcanzar sus objetivos de fitness.',
            'imagen' => '/images/noticias/1.jpg',
            'user_id' => 1
        ]);

        $noticia_2 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nuevo gimnasio en el centro de la ciudad',
            'contenido' => 'La ciudad ha inaugurado un nuevo gimnasio en el centro de la ciudad que cuenta con instalaciones de última generación y un equipo de entrenadores profesionales para ayudar a los clientes a alcanzar sus objetivos de fitness.',
            'imagen' => '/images/noticias/2.jpg',
            'user_id' => 1
        ]);
    }
}
