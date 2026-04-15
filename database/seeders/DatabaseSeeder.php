<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- USUARIO ---
        $user_id = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'dni' => '12345678A',
            'created_at' => now(),
        ]);

        // --- CENTROS ---
        $centro_1 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro de Aguas Libres',
            'descripcion' => 'Ubicado en la costa, nuestro centro ofrece un entorno privilegiado para el entrenamiento acuático con piscina climatizada de alto rendimiento.',
            'direccion' => 'Calle del Natación, 789, Ciudad',
            'telefono' => '234857432',
            'email' => 'piscina@olimpica.com'
        ]);
        DB::table('centros')->where('id', $centro_1)->update(['imagen' => "centros/{$centro_1}.jpg"]);

        $centro_2 = DB::table('centros')->insertGetId([
            'nombre' => 'Gimnasio Core Fitness',
            'descripcion' => 'Un gimnasio equipado con las últimas máquinas de entrenamiento y un equipo de entrenadores profesionales de élite.',
            'direccion' => 'Avenida del Deporte, 456, Ciudad',
            'telefono' => '987654321',
            'email' => 'gimnasio@gim.com'
        ]);
        DB::table('centros')->where('id', $centro_2)->update(['imagen' => "centros/{$centro_2}.jpg"]);

        $centro_3 = DB::table('centros')->insertGetId([
            'nombre' => 'Adventure Hub Aire Libre',
            'descripcion' => 'Variedad de actividades para disfrutar en la naturaleza, como senderismo, ciclismo y escalada profesional.',
            'direccion' => 'Parque Natural, 123, Ciudad',
            'telefono' => '345678901',
            'email' => 'airelibre@actividades.com'
        ]);
        DB::table('centros')->where('id', $centro_3)->update(['imagen' => "centros/{$centro_3}.jpg"]);

        $centro_4 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro de Atletismo Municipal',
            'descripcion' => 'Instalaciones modernas con pista de tartán y equipo técnico especializado en alto rendimiento.',
            'direccion' => 'Calle del Atletismo, 456, Ciudad',
            'telefono' => '987958421',
            'email' => 'atletismo@atletismo.com'
        ]);
        DB::table('centros')->where('id', $centro_4)->update(['imagen' => "centros/{$centro_4}.jpg"]);

        // --- ACTIVIDADES ---
        $actividad_1 = DB::table('actividades')->insertGetId([
            'titulo' => 'Natación',
            'descripcion' => 'Disciplina acuática integral que combina resistencia y fuerza. Ideal para fortalecer el sistema cardiovascular en un entorno de bajo impacto articular.',            'nivel' => 'Medio',
            'tipo' => 'Acuática'
        ]);
        DB::table('actividades')->where('id', $actividad_1)->update(['imagen' => "actividades/{$actividad_1}.jpg"]);

        $actividad_2 = DB::table('actividades')->insertGetId([
            'titulo' => 'Ciclismo',
            'descripcion' => 'Mejora tu capacidad aeróbica sobre ruedas. Trabajo de potencia en el tren inferior y resistencia metabólica en sesiones dinámicas.',
            'nivel' => 'Principiante',
            'tipo' => 'Cardio'
        ]);
        DB::table('actividades')->where('id', $actividad_2)->update(['imagen' => "actividades/{$actividad_2}.jpg"]);

        $actividad_3 = DB::table('actividades')->insertGetId([
            'titulo' => 'Fútbol',
            'descripcion' => 'Estrategia grupal, potencia explosiva y agilidad. Participa en entrenamientos diseñados para mejorar tu coordinación táctica y velocidad.',
            'nivel' => 'Medio',
            'tipo' => 'Cardio'
        ]);
        DB::table('actividades')->where('id', $actividad_3)->update(['imagen' => "actividades/{$actividad_3}.jpg"]);

        $actividad_4 = DB::table('actividades')->insertGetId([
            'titulo' => 'Atletismo',
            'descripcion' => 'Fundamentos del movimiento: carrera, saltos y lanzamientos. Perfecciona tu técnica de zancada y economía de carrera.',
            'nivel' => 'Principiante',
            'tipo' => 'Cardio'
        ]);
        DB::table('actividades')->where('id', $actividad_4)->update(['imagen' => "actividades/{$actividad_4}.jpg"]);

        // --- NOTICIAS ---
        $noticia_1 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nueva piscina olímpica en la ciudad',
            'contenido' => 'Inauguración de instalaciones de última generación con equipo de entrenadores profesionales para todos los niveles.',
            'user_id' => $user_id,
            'created_at' => now(),
        ]);
        DB::table('noticias')->where('id', $noticia_1)->update(['imagen' => "noticias/{$noticia_1}.jpg"]);

        $noticia_2 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nuevo gimnasio en el centro',
            'contenido' => 'Apertura de un centro deportivo premium con maquinaria de vanguardia y programas personalizados.',
            'user_id' => $user_id,
            'created_at' => now(),
        ]);
        DB::table('noticias')->where('id', $noticia_2)->update(['imagen' => "noticias/{$noticia_2}.jpg"]);

        // --- CURSOS ---
        $curso_1 = DB::table('cursos')->insertGetId([
            'titulo' => 'Yoga para principiantes',
            'descripcion' => 'Introducción al yoga con ejercicios básicos y técnicas de respiración.',
            'tipo' => 'Flexibilidad'
        ]);
        DB::table('cursos')->where('id', $curso_1)->update(['imagen' => "cursos/{$curso_1}.jpg"]);

        $curso_2 = DB::table('cursos')->insertGetId([
            'titulo' => 'Entrenamiento funcional',
            'descripcion' => 'Ejercicios que imitan movimientos diarios para mejorar la fuerza y resistencia.',
            'tipo' => 'Cardio'
        ]);
        DB::table('cursos')->where('id', $curso_2)->update(['imagen' => "cursos/{$curso_2}.jpg"]);


    }

}