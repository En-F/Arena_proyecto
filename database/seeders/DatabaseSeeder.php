<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        //--- ROLES ---

        $rol_1=DB::table('roles')->insertGetId([
            'rol' => 'admin',
            'description' => 'Administrador de la página web'
            ]);
        $rol_2=DB::table('roles')->insertGetId([
            'rol' => 'jefe',
            'description' => 'Es el que gestiona su centro'
        ]);
        $rol_3=DB::table('roles')->insertGetId([
            'rol' => 'logeado',
            'description' => 'Usuario logeado que tiene acceso a las reservas de las actividades'
        ]);

            
        // --- USUARIOS ---
        $admin = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'dni' => '67182280Q',
            'created_at' => now(),
        ]);

        $jefe = DB::table('users')->insertGetId([
            'name' => 'Enrique',
            'email' => 'enrique@enrique.com',
            'password' => Hash::make('enrique'),
            'dni' => '68957529X',
            'created_at' => now(),
        ]);

        $usuario_1 = DB::table('users')->insertGetId([
            'name' => 'usuario1',
            'email' => 'usuario1@usuario1.com',
            'password' => Hash::make('usuario1'),
            'dni' => '83589575P',
            'created_at' => now(),
        ]);

        $usuario_2 = DB::table('users')->insertGetId([
            'name' => 'usuario2',
            'email' => 'usuario2@usuario2.com',
            'password' => Hash::make('usuario2'),
            'dni' => '30179491H',
            'created_at' => now(),
            'activo'=> false
        ]);

        $usuario_3 = DB::table('users')->insertGetId([
            'name' => 'usuario3',
            'email' => 'usuario3@usuario3.com',
            'password' => Hash::make('usuario3'),
            'dni' => '66981463N',
            'created_at' => now(),
            'activo'=> false
        ]);

        
        //Tipos
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
            'nombre' => 'Ok+',
            'descripcion' => ' para el entrenamiento acuático con piscina climatizada de alto rendimiento.',
            'direccion' => 'Calle del Natación, 789, Ciudad',
            'telefono' => '234857432',
            'email' => 'piscina@olimpica.com'
        ]);
        DB::table('centros')->where('id', $centro_1)->update(['imagen' => "centros/{$centro_1}.jpg"]);

        $centro_2 = DB::table('centros')->insertGetId([
            'nombre' => 'Gimnasio Core Fitness',
            'descripcion' => 'Un gimnasio equipado con las últimas máquinas de entrenamiento y un equipo de entrenadores profesionales con piscina .',
            'direccion' => 'Av. de la Rondeña, S/N',
            'telefono' => '657 80 44 38',
            'email' => 'info-sanlucar@gmail.es'
        ]);
        DB::table('centros')->where('id', $centro_2)->update(['imagen' => "centros/{$centro_2}.jpg"]);

        $centro_3 = DB::table('centros')->insertGetId([
            'nombre' => 'Adventure Hub Aire Libre',
            'descripcion' => 'Variedad de actividades para disfrutar en la naturaleza, como senderismo, ciclismo y escalada profesional.',
            'direccion' => 'Parque Natural, 123, Ciudad',
            'telefono' => '345678901',
            'email' => 'airelibre@gmail.com'
        ]);
        DB::table('centros')->where('id', $centro_3)->update(['imagen' => "centros/{$centro_3}.jpg"]);

        $centro_4 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro de Atletismo Municipal',
            'descripcion' => 'Instalaciones modernas con pista de tartán y equipo técnico especializado en alto rendimiento.',
            'direccion' => 'Calle del Atletismo, 456, Ciudad',
            'telefono' => '987958421',
            'email' => 'atletismo@gmail.com'
        ]);
        DB::table('centros')->where('id', $centro_4)->update(['imagen' => "centros/{$centro_4}.jpg"]);

        $centro_5 = DB::table('centros')->insertGetId([
            'nombre' => 'Pabellón Polideportivo Municipal Donostia',
            'descripcion' => 'Instalación cubierta de alto nivel equipada con pistas de parqué multideporte, canastas retráctiles, porterías y gradas de gran capacidad para eventos deportivos.',
            'direccion' => 'Calle de los Deportes, s/n, Zona Estadio',
            'telefono' => '943001122',
            'email' => 'pabellon_municipal@gmail.es'
        ]);
        DB::table('centros')->where('id', $centro_5)->update(['imagen' => "centros/{$centro_5}.jpg"]);

        $centro_6 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro de Manolo Gallego',
            'descripcion' => 'Instalaciones modernas para practicar Yoga deporte de fuerza y mantenerse en forma.',
            'direccion' => 'Calle del Papeleo, 456, Ciudad',
            'telefono' => '987958123',
            'email' => 'centromano@gmail.com'
        ]);
        DB::table('centros')->where('id', $centro_6)->update(['imagen' => "centros/{$centro_6}.jpg"]);

        $centro_7 = DB::table('centros')->insertGetId([
            'nombre' => 'CAR Granada',
            'descripcion' => 'Instalación técnica especializada diseñada para optimizar el desempeño de deportistas de élite. Su objetivo principal es ofrecer un entorno integral que combina entrenamiento de vanguardia, servicios médicos especializados y apoyo científico, permitiendo a los atletas prepararse para competiciones nacionales e internacionales en las mejores condiciones posibles. ',
            'direccion' => 'Sierra Nevada',
            'telefono' => '912111678',
            'email' => 'CAR@gmail.com'
        ]);
        DB::table('centros')->where('id', $centro_7)->update(['imagen' => "centros/{$centro_7}.jpg"]);

        $centro_8 = DB::table('centros')->insertGetId([
            'nombre' => 'Centro Deportivo Municipal El Barrio',
            'descripcion' => 'Complejo deportivo con campo de fútbol de césped artificial de última generación, zonas de entrenamiento al aire libre y vestuarios renovados.',
            'direccion' => 'Calle de la Vecindad, 8, Distrito Centro',
            'telefono' => '910000008',
            'email' => 'elbarriodeportes@gmail.com'
        ]);
        DB::table('centros')->where('id', $centro_8)->update(['imagen' => "centros/{$centro_8}.jpg"]);





        //---VALORACIONES---// 
        DB::table('valoraciones')->insert([
            'titulo' => 'Excelente centro',
            'comentario' => 'Me encanta entrenar aquí, las instalaciones son de primera y el personal es muy amable.',
            'puntuacion' => 8,
            'centro_id' => $centro_1,
            'user_id' => $jefe,
            'created_at' => now(),
        ]);
        
        DB::table('valoraciones')->insert([
            'titulo' => 'Muy buen ambiente',
            'comentario' => 'El ambiente es muy motivador y las actividades son variadas. Lo recomiendo.',
            'puntuacion' => 8,
            'centro_id' => $centro_1,
            'user_id' => $jefe,
            'created_at' => now(),
        ]);

        DB::table('redes_sociales')->insert([
            'nombre' => 'Facebook',
            'url' => 'https://www.facebook.com/centro1',
            'centro_id' => $centro_1,
            'created_at' => now(),
        ]);


        //INSTALACIONES
        $instalacion_1 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Piscina Olímpica',
            'imagen' => 'swimming-pool',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_1)->update(['imagen' => "instalaciones/{$instalacion_1}.jpg"]);


        $instalacion_2 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Pista de Atletismo',
            'imagen' => 'pista-atletismo',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_2)->update(['imagen' => "instalaciones/{$instalacion_2}.jpg"]);

        $instalacion_3 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Baloncesto',
            'imagen' => 'baloncesto',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_3)->update(['imagen' => "instalaciones/{$instalacion_3}.jpg"]);

        $instalacion_4 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Pista de tenis',
            'imagen' => 'tenis',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_4)->update(['imagen' => "instalaciones/{$instalacion_4}.jpg"]);


        // --- ACTIVIDADES ---
               $actividad_1 = DB::table('actividades')->insertGetId([
            'titulo' => 'Natación',
            'descripcion' => 'Disciplina acuática integral que combina resistencia y fuerza. Ideal para fortalecer el sistema cardiovascular en un entorno de bajo impacto articular.',            'nivel' => 'Medio',
            'tipo_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_1)->update(['imagen' => "actividades/{$actividad_1}.jpg"]);

        $actividad_2 = DB::table('actividades')->insertGetId([
            'titulo' => 'Ciclismo',
            'descripcion' => 'Mejora tu capacidad aeróbica sobre ruedas. Trabajo de potencia en el tren inferior y resistencia metabólica en sesiones dinámicas.',
            'nivel' => 'Principiante',
            'tipo_id' => $tipo_4
        ]);
        DB::table('actividades')->where('id', $actividad_2)->update(['imagen' => "actividades/{$actividad_2}.jpg"]);

        $actividad_3 = DB::table('actividades')->insertGetId([
            'titulo' => 'Fútbol',
            'descripcion' => 'Estrategia grupal, potencia explosiva y agilidad. Participa en entrenamientos diseñados para mejorar tu coordinación táctica y velocidad.',
            'nivel' => 'Medio',
            'tipo_id' => $tipo_2
        ]);
        DB::table('actividades')->where('id', $actividad_3)->update(['imagen' => "actividades/{$actividad_3}.jpg"]);

        $actividad_4 = DB::table('actividades')->insertGetId([
            'titulo' => 'Atletismo',
            'descripcion' => 'Fundamentos del movimiento: carrera, saltos y lanzamientos. Perfecciona tu técnica de zancada y economía de carrera.',
            'nivel' => 'Principiante',
            'tipo_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_4)->update(['imagen' => "actividades/{$actividad_4}.jpg"]);

        $actividad_5 = DB::table('actividades')->insertGetId([
            'titulo' => 'Pilates',
            'descripcion' => 'Ejercicios de bajo impacto que mejoran la flexibilidad, fuerza y equilibrio.',
            'nivel' => 'Principiante',
            'tipo_id' => $tipo_4
        ]);
        DB::table('actividades')->where('id', $actividad_5)->update(['imagen' => "actividades/{$actividad_5}.jpg"]);

        $actividad_6 = DB::table('actividades')->insertGetId([
            'titulo' => 'Baloncesto',
            'descripcion' => 'Deporte de equipo que combina habilidades técnicas, resistencia y estrategia. Mejora tu coordinación, agilidad y capacidad aeróbica en la cancha.',
            'nivel' => 'Principiante',
            'tipo_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_6)->update(['imagen' => "actividades/{$actividad_6}.jpg"]);

        $actividad_7 = DB::table('actividades')->insertGetId([
            'titulo' => 'Waterpolo',
            'descripcion' => 'Deporte de equipo que combina habilidades técnicas, resistencia y estrategia. Mejora tu coordinación, agilidad y capacidad aeróbica en la cancha.',
            'nivel' => 'Principiante',
           'tipo_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_7)->update(['imagen' => "actividades/{$actividad_7}.jpg"]);




        // --- NOTICIAS ---
        $noticia_1 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nueva piscina olímpica en la ciudad',
            'contenido' => 'Inauguración de instalaciones de última generación con equipo de entrenadores profesionales para todos los niveles.',
            'user_id' => $admin,
            'created_at' => now(),
        ]);
        DB::table('noticias')->where('id', $noticia_1)->update(['imagen' => "noticias/{$noticia_1}.jpg"]);

        $noticia_2 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nuevo gimnasio en el centro',
            'contenido' => 'Apertura de un centro deportivo premium con maquinaria de vanguardia y programas personalizados.',
            'user_id' => $admin,
            'created_at' => now(),
        ]);
        DB::table('noticias')->where('id', $noticia_2)->update(['imagen' => "noticias/{$noticia_2}.jpg"]);




        // --- CURSOS ---

        $curso_1 = DB::table('cursos')->insertGetId([
            'titulo' => 'Aguas al aire Libre',
            'descripcion' => 'Entrenamiento de agua que te va a mejorar la resistencia y el bienestar ya sea en el entorno natural o en una piscina.',
            'tipo' => 'Resistencia'
        ]);
        DB::table('cursos')->where('id', $curso_1)->update(['imagen' => "cursos/{$curso_1}.jpg"]);


        $curso_2 = DB::table('cursos')->insertGetId([
            'titulo' => 'Yoga para principiantes',
            'descripcion' => 'Introducción al yoga con ejercicios básicos y técnicas de respiración.',
            'tipo' => 'Flexibilidad'
        ]);
        DB::table('cursos')->where('id', $curso_2)->update(['imagen' => "cursos/{$curso_2}.jpg"]);

        $curso_3 = DB::table('cursos')->insertGetId([
            'titulo' => 'Entrenamiento funcional',
            'descripcion' => 'Ejercicios que imitan movimientos diarios para mejorar la fuerza y resistencia.',
            'tipo' => 'Cardio'
        ]);
        DB::table('cursos')->where('id', $curso_3)->update(['imagen' => "cursos/{$curso_3}.jpg"]);



        //----VIDEOS----
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
            'url'=> 'https://www.youtube.com/watch?v=IzMvBMj5Kzc&pp=ygUWY29tbyBzYWx0YXIgZGVsIHBvZGl1bg%3D%3D'
        ]);

        $video_6 = DB::table('videos')->insertGetId([
            'titulo'=> 'Remadas',
            'url'=> 'https://www.youtube.com/watch?v=5cS4oXMTmgI&pp=ygUTcmVtYWRhcyBlbiBuYXRhY2lvbg%3D%3D'
        ]);

        //----RELACIONES----

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

        DB::table('centro_curso')->insert([
            'centro_id'=> $centro_1,
            'curso_id'=> $curso_2,
            'created_at'=>now()
        ]);

        DB::table('actividad_curso')->insert([
            'actividad_id'=> $actividad_1,
            'curso_id'=>$curso_1,
            'created_at'=>now()
        ]);

        DB::table('actividad_curso')->insert([
            'actividad_id'=> $actividad_7,
            'curso_id'=>$curso_1,
            'created_at'=>now()
        ]);

        DB::table('inscripcion')->insert([
            'centro_id'=> $centro_1,
            'user_id'=> $jefe,
            'fecha_alta'=> now()
        ]);


        DB::table('inscripcion')->insert([
            'centro_id'=> $centro_2,
            'user_id'=> $jefe,
            'fecha_alta'=> now()
        ]);

        DB::table('inscripcion')->insert([
            'centro_id'=> $centro_2,
            'user_id'=> $usuario_1,
            'fecha_alta'=> now()
        ]);

        DB::table('inscripcion')->insert([
            'centro_id'=> $centro_1,
            'user_id'=> $usuario_2,
            'fecha_alta'=> now()
        ]);

        DB::table('inscripcion')->insert([
            'centro_id'=> $centro_3,
            'user_id'=> $usuario_3,
            'fecha_alta'=> now()
        ]);

        DB::table('usuario_rol')->insert([
            'user_id' => $admin,
            'rol_id' => $rol_1,
            'created_at'=>now()
        ]);

        DB::table('usuario_rol')->insert([
            'user_id' => $jefe,
            'rol_id' => $rol_2,
            'created_at'=>now()
        ]);

        DB::table('usuario_rol')->insert([
            'user_id' => $usuario_1,
            'rol_id' => $rol_3,
            'created_at'=>now()
        ]);

        DB::table('usuario_rol')->insert([
            'user_id' => $usuario_2,
            'rol_id' => $rol_3,
            'created_at'=>now()
        ]);

        DB::table('usuario_rol')->insert([
            'user_id' => $usuario_3,
            'rol_id' => $rol_3,
            'created_at'=>now()
        ]);

        

        DB::table('centro_instalacion')->insert([
            'centro_id' => $centro_1,
            'instalacion_id' => $instalacion_1,
            'created_at'=>now()
        ]);

        DB::table('centro_instalacion')->insert([
            'centro_id' => $centro_1,
            'instalacion_id' => $instalacion_2,
            'created_at'=>now()
        ]);

        DB::table('centro_instalacion')->insert([
            'centro_id' => $centro_1,
            'instalacion_id' => $instalacion_3,
            'created_at'=>now()
        ]);

    }


}