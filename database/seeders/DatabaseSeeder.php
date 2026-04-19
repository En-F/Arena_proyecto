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
        $user_id_1 = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'dni' => '12345678A',
            'created_at' => now(),
        ]);

        //---  Tipos de actividades ---
        $tipo_1 = DB::table('tipos')->insertGetId([            
            'tipo'=> 'Resistencia'        
        ]);
        $tipo_2 = DB::table('tipos')->insertGetId([            
            'tipo'=> 'Fuerza'        
        ]);
        $tipo_3 = DB::table('tipos')->insertGetId([            
            'tipo'=> 'Flexibilidad'        
        ]);
        $tipo_4 = DB::table('tipos')->insertGetId([            
            'tipo'=> 'Cardio'        
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

        $centro_5 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro de Preueba que es mas largo que la tot en bragas',
            'descripcion' => 'asd de tartán y equipo técnico especializado en alto rendimiento.',
            'direccion' => 'asdasd',
            'telefono' => '987923421',
            'email' => 'sds@atletismo.com'
        ]);
        DB::table('centros')->where('id', $centro_5)->update(['imagen' => "centros/{$centro_4}.jpg"]);

        // --- ACTIVIDADES ---
        $actividad_1 = DB::table('actividades')->insertGetId([
            'titulo' => 'Natación',
            'descripcion' => 'Disciplina acuática integral que combina resistencia y fuerza. Ideal para fortalecer el sistema cardiovascular en un entorno de bajo impacto articular.',            'nivel' => 'Medio',
            'tipos_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_1)->update(['imagen' => "actividades/{$actividad_1}.jpg"]);

        $actividad_2 = DB::table('actividades')->insertGetId([
            'titulo' => 'Ciclismo',
            'descripcion' => 'Mejora tu capacidad aeróbica sobre ruedas. Trabajo de potencia en el tren inferior y resistencia metabólica en sesiones dinámicas.',
            'nivel' => 'Principiante',
            'tipos_id' => $tipo_4
        ]);
        DB::table('actividades')->where('id', $actividad_2)->update(['imagen' => "actividades/{$actividad_2}.jpg"]);

        $actividad_3 = DB::table('actividades')->insertGetId([
            'titulo' => 'Fútbol',
            'descripcion' => 'Estrategia grupal, potencia explosiva y agilidad. Participa en entrenamientos diseñados para mejorar tu coordinación táctica y velocidad.',
            'nivel' => 'Medio',
            'tipos_id' => $tipo_2
        ]);
        DB::table('actividades')->where('id', $actividad_3)->update(['imagen' => "actividades/{$actividad_3}.jpg"]);

        $actividad_4 = DB::table('actividades')->insertGetId([
            'titulo' => 'Atletismo',
            'descripcion' => 'Fundamentos del movimiento: carrera, saltos y lanzamientos. Perfecciona tu técnica de zancada y economía de carrera.',
            'nivel' => 'Principiante',
            'tipos_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_4)->update(['imagen' => "actividades/{$actividad_4}.jpg"]);

        $actividad_5 = DB::table('actividades')->insertGetId([
            'titulo' => 'Waterpolo',
            'descripcion' => 'Juego de equipo en el agua que combina estrategia y habilidades técnicas.',
            'nivel' => 'Principiante',
            'tipos_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_5)->update(['imagen' => "actividades/{$actividad_5}.jpg"]);


        // --- NOTICIAS ---
        $noticia_1 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nueva piscina olímpica en la ciudad',
            'contenido' => 'Inauguración de instalaciones de última generación con equipo de entrenadores profesionales para todos los niveles.',
            'user_id' => $user_id_1,
            'created_at' => now(),
        ]);
        DB::table('noticias')->where('id', $noticia_1)->update(['imagen' => "noticias/{$noticia_1}.jpg"]);

        $noticia_2 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nuevo gimnasio en el centro',
            'contenido' => 'Apertura de un centro deportivo premium con maquinaria de vanguardia y programas personalizados.',
            'user_id' => $user_id_1,
            'created_at' => now(),
        ]);
        DB::table('noticias')->where('id', $noticia_2)->update(['imagen' => "noticias/{$noticia_2}.jpg"]);

        // --- CURSOS ---
        $curso_1 = DB::table('cursos')->insertGetId([
            'titulo' => 'Natacion libre',
            'descripcion' => 'Entrenamiento  para mejorar la resistencia y técnica de nado así como aprender nuevos juegos que se dan en el agua.',
            'tipo' => 'Cardio'
        ]);
        DB::table('cursos')->where('id', $curso_1)->update(['imagen' => "cursos/{$curso_1}.jpg"]);

        $curso_2 = DB::table('cursos')->insertGetId([
            'titulo' => 'Entrenamiento funcional',
            'descripcion' => 'Ejercicios que imitan movimientos diarios para mejorar la fuerza y resistencia.',
            'tipo' => 'Cardio'
        ]);
        DB::table('cursos')->where('id', $curso_2)->update(['imagen' => "cursos/{$curso_2}.jpg"]);


        //---  VIDEOS ---

        $video_1 = DB::table('videos')->insertGetId([            
            'titulo'=> 'Mariposa',           
            'url'=> 'https://www.youtube.com/watch?v=YlhXuC25_L4&pp=ygUPZXN0aWxvIG1hcmlwb3Nh'   
        ]);

        $video_2 = DB::table('videos')->insertGetId([            
            'titulo'=> 'Espalda',            
            'url'=> 'https://www.youtube.com/watch?v=tbwFnGfh0X8&pp=ygUOZXN0aWxvIGVzcGFsZGE%3D'
        ]);

        $video_3 = DB::table('videos')->insertGetId([            
            'titulo'=> 'Braza',            
            'url'=> 'https://www.youtube.com/watch?v=kcwwyFMIofs&t=1s&pp=ygUMZXN0aWxvIGJyYXph' 
        ]);

        $video_4 = DB::table('videos')->insertGetId([            
            'titulo'=> 'Croll',            
            'url'=> 'https://www.youtube.com/watch?v=u5ZWVginAXQ&pp=ygUMZXN0aWxvIGNyb2xs'  
        ]);
        $video_5 = DB::table('videos')->insertGetId([            
            'titulo'=> 'Tirarse de Tranpolin',            
            'url'=> 
            'https://www.youtube.com/watch?v=IzMvBMj5Kzc&pp=ygUWY29tbyBzYWx0YXIgZGVsIHBvZGl1bg%3D%3D'   
        ]);

        $video_6 = DB::table('videos')->insertGetId([            
            'titulo'=> 'Remadas',            
            'url'=> 'https://www.youtube.com/watch?v=5cS4oXMTmgI&pp=ygUTcmVtYWRhcyBlbiBuYXRhY2lvbg%3D%3D'   
        ]);

        

        


        //---RELACIONES ---

        DB::table('inscripcion')->insert([            
            'centro_id'=> $centro_1,            
            'user_id'=> $user_id_1,            
            'created_at'=>now(),
            'fecha_alta' => now()      
        ]);

        DB::table('videoables')->insert([            
            'video_id'=> $video_1,            
            'videoable_id'=> $actividad_1,            
            'videoable_type'=> 'App\Models\Actividad',            
            'created_at'=>now()        
        ]);
        DB::table('videoables')->insert([            
            'video_id'=> $video_2,            
            'videoable_id'=> $actividad_1,            
            'videoable_type'=> 'App\Models\Actividad',           
             'created_at'=>now()        
        ]);
        DB::table('videoables')->insert([            
            'video_id'=> $video_3,            
            'videoable_id'=> $actividad_1,            
            'videoable_type'=> 'App\Models\Actividad',            
            'created_at'=>now()        
        ]);
        DB::table('videoables')->insert([            
            'video_id'=> $video_4,            
            'videoable_id'=> $actividad_1,            
            'videoable_type'=> 'App\Models\Actividad',            
            'created_at'=>now()        
        ]);
        DB::table('videoables')->insert([            
            'video_id'=> $video_5,            
            'videoable_id'=> $actividad_1,            
            'videoable_type'=> 'App\Models\Actividad',            
            'created_at'=>now()       
         ]);
        DB::table('videoables')->insert([            
            'video_id'=> $video_6,            
            'videoable_id'=> $actividad_1,            
            'videoable_type'=> 'App\Models\Actividad',            
            'created_at'=>now()        
        ]);


        DB::table('centro_curso')->insert([            
            'centro_id'=> $centro_1,            
            'curso_id'=> $curso_1,            
            'created_at'=>now()        
        ]);


        Db::table('actividad_curso')->insert([            
            'actividad_id'=> $actividad_1,            
            'curso_id'=> $curso_1,            
            'created_at'=>now()        
        ]);

        Db::table('actividad_curso')->insert([            
            'actividad_id'=> $actividad_5,            
            'curso_id'=> $curso_1,            
            'created_at'=>now()        
        ]);


    }

}