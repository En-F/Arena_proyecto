<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
            'rol' => 'socio',
            'description' => 'Socio que tiene acceso a las reservas de las actividades'
        ]);
        $rol_4=DB::table('roles')->insertGetId([
            'rol' => 'registrado',
            'description' => 'Usuario registrado que no tiene acceso a las reservas de las actividades'
        ]);



        // --- USUARIOS ---
        $admin = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'dni' => '67182280Q',
            'telefono' => '111111111',
            'stripe_customer_id' => 'cus_Admin' . Str::random(10), 
            'created_at' => now(),
            'fecha_inicio_plataforma' => now(),
            'activo' => true
        ]);

        $jefe = DB::table('users')->insertGetId([
            'name' => 'Enrique',
            'email' => 'enrique@enrique.com',
            'password' => Hash::make('enrique'),
            'dni' => '68957529X',
            'telefono' => '123456789',
            'stripe_customer_id' => 'cus_Enrique' . Str::random(10),
            'created_at' => now(),
            'fecha_inicio_plataforma' => now(),
            'activo' => true
        ]);

        $usuario_1 = DB::table('users')->insertGetId([
            'name' => 'usuario1',
            'email' => 'usuario1@usuario1.com',
            'password' => Hash::make('usuario1'),
            'dni' => '83589575P',
            'telefono' => '987654321',
            'stripe_customer_id' => 'cus_User1' . Str::random(10),
            'created_at' => now(),
            'fecha_inicio_plataforma' => now(),
            'activo' => true
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
            'descripcion' => 'Centro deportivo con dos piscinas dos piscinas de 25 metros , ambas con climatización , gimnasio remodelado y amplias zonas  para practicar deportes tanto de bicileta,baile,bachata,tambien una zona de crosfit y por ultimo zona de actividdaes al aire libre.',
            'direccion' => 'Av. de la Rondeña, 11540 Sanlúcar de Barrameda, Cádiz',
            'telefono' => '657804438',
            'email' => 'info-sanlucar@okeymas.es',
            'latitud' => 36.77384,
            'longitud' => -6.34497
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
            'nombre' => 'Complejo Deportivo La Marina',
            'descripcion' => 'Instalaciones de alto rendimiento con pistas de pádel, tenis y un pabellón cubierto multiusos.',
            'direccion' => 'Calle del Mar, 12',
            'telefono' => '612 34 56 78',
            'email' => 'lamarina-deportes@gmail.es',
            'created_at' => now(),
        ]);
        DB::table('centros')->where('id', $centro_3)->update(['imagen' => "centros/{$centro_3}.jpg"]);




        //---VALORACIONES---//
        DB::table('valoraciones')->insert([
            'titulo' => 'Excelente centro',
            'comentario' => 'Me encanta entrenar aquí, las instalaciones son de primera y el personal es muy amable.',
            'puntuacion' => 4,
            'centro_id' => $centro_1,
            'user_id' => $jefe,
            'created_at' => now(),
        ]);

        DB::table('valoraciones')->insert([
            'titulo' => 'Muy buen ambiente',
            'comentario' => 'El ambiente es muy motivador y las actividades son variadas. Lo recomiendo.',
            'puntuacion' => 4,
            'centro_id' => $centro_1,
            'user_id' => $admin,
            'created_at' => now(),
        ]);

        DB::table('redes_sociales')->insert([
            'nombre' => 'Facebook',
            'url' => 'https://www.facebook.com/centro1',
            'centro_id' => $centro_1,
            'created_at' => now(),
        ]);


        //Tarifas
        $tarifa_1 = DB::table('tarifas')->insertGetId([
            'tipo' => 'basica',
            'precio' => 24.90,
            'periodo' => 'mes',
            'descuento' => 0,
            'descripcion' => json_encode([
                'Acceso 8:00 a 14:00',
                'Máximo 3 reservas semanales',
                'Solo días laborables'
            ]),
            'centro_id' => $centro_1,
            'created_at' => now(),
        ]);

        $tarifa_2 = DB::table('tarifas')->insertGetId([
            'tipo' => 'estandar',
            'precio' => 65.00, 
            'periodo' => 'trimestre',
            'descuento' => 10, 
            'descripcion' => json_encode([
                'Acceso Mañana y Tarde',
                'Máximo 6 reservas semanales',
                'Pago único cada 3 meses'
            ]),
            'centro_id' => $centro_1,
            'created_at' => now(),
        ]);

        $tarifa_3 = DB::table('tarifas')->insertGetId([
            'tipo' => 'premium',
            'precio' => 120.00,
            'periodo' => 'semestre',
            'descuento' => 20, 
            'descripcion' => json_encode([
                'Acceso Total 24/7',
                'Reservas ilimitadas',
                'Pago único cada 6 meses'
            ]),
            'centro_id' => $centro_1,
            'created_at' => now(),
        ]);


        $tarifa_4 = DB::table('tarifas')->insertGetId([
            'tipo' => 'basica',
            'precio' => 14.90,
            'periodo' => 'mes',
            'descuento' => 0,
            'descripcion' => json_encode([
                'Acceso 8:00 a 14:00',
                'Máximo 2 reservas semanales'
            ]),
            'centro_id' => $centro_2,
            'created_at' => now(),
        ]);

        $tarifa_5 = DB::table('tarifas')->insertGetId([
            'tipo' => 'estandar',
            'precio' => 24.90,
            'periodo' => 'trimestre',
            'descuento' => 10, 
            'descripcion' => json_encode([
                'Acceso mañana y tarde',
                'Máximo 4 reservas semanales',
                'Pago cada 3 meses'
            ]),
            'centro_id' => $centro_2,
            'created_at' => now(),
        ]);


        // --- Instalación 1: Gimnasio Fitness ---
        $instalacion_1 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Gimnasio Fitness',
            'imagen' => 'gym',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_1)->update(['imagen' => "instalaciones/ic-{$instalacion_1}.png"]);

        // --- Instalación 2: Campo de Fútbol ---
        $instalacion_2 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Campo de Fútbol',
            'imagen' => 'soccer',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_2)->update(['imagen' => "instalaciones/ic-{$instalacion_2}.png"]);

        // --- Instalación 3: Sala de Yoga ---
        $instalacion_3 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Sala de Yoga',
            'imagen' => 'yoga',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_3)->update(['imagen' => "instalaciones/ic-{$instalacion_3}.png"]);


        // --- ACTIVIDADES ---
            $actividad_1 = DB::table('actividades')->insertGetId([
            'nombre' => 'Natación',
            'descripcion' => 'Disciplina acuática integral que combina resistencia y fuerza. Ideal para fortalecer el sistema cardiovascular en un entorno de bajo impacto articular.',            'nivel' => 'Medio',
            'nivel' => 'intermedio',
            'tipo_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_1)->update(['imagen' => "actividades/{$actividad_1}.jpg"]);

        $actividad_2 = DB::table('actividades')->insertGetId([
            'nombre' => 'Ciclismo',
            'descripcion' => 'Mejora tu capacidad aeróbica sobre ruedas. Trabajo de potencia en el tren inferior y resistencia metabólica en sesiones dinámicas.',
            'nivel' => 'facil',
            'tipo_id' => $tipo_4
        ]);
        DB::table('actividades')->where('id', $actividad_2)->update(['imagen' => "actividades/{$actividad_2}.jpg"]);

        $actividad_3 = DB::table('actividades')->insertGetId([
            'nombre' => 'Fútbol',
            'descripcion' => 'Estrategia grupal, potencia explosiva y agilidad. Participa en entrenamientos diseñados para mejorar tu coordinación táctica y velocidad.',
            'nivel' => 'intermedio',
            'tipo_id' => $tipo_2
        ]);
        DB::table('actividades')->where('id', $actividad_3)->update(['imagen' => "actividades/{$actividad_3}.jpg"]);

        $actividad_4 = DB::table('actividades')->insertGetId([
            'nombre' => 'Atletismo',
            'descripcion' => 'Fundamentos del movimiento: carrera, saltos y lanzamientos. Perfecciona tu técnica de zancada y economía de carrera.',
            'nivel' => 'facil',
            'tipo_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_4)->update(['imagen' => "actividades/{$actividad_4}.jpg"]);

        $actividad_5 = DB::table('actividades')->insertGetId([
            'nombre' => 'Pilates',
            'descripcion' => 'Ejercicios de bajo impacto que mejoran la flexibilidad, fuerza y equilibrio.',
            'nivel' => 'facil',
            'tipo_id' => $tipo_4
        ]);
        DB::table('actividades')->where('id', $actividad_5)->update(['imagen' => "actividades/{$actividad_5}.jpg"]);

        $actividad_6 = DB::table('actividades')->insertGetId([
            'nombre' => 'Baloncesto',
            'descripcion' => 'Deporte de equipo que combina habilidades técnicas, resistencia y estrategia. Mejora tu coordinación, agilidad y capacidad aeróbica en la cancha.',
            'nivel' => 'facil',
            'tipo_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_6)->update(['imagen' => "actividades/{$actividad_6}.jpg"]);

        $actividad_7 = DB::table('actividades')->insertGetId([
            'nombre' => 'Waterpolo',
            'descripcion' => 'Deporte de equipo que combina habilidades técnicas, resistencia y estrategia. Mejora tu coordinación, agilidad y capacidad aeróbica en la cancha.',
            'nivel' => 'facil',
           'tipo_id' => $tipo_1
        ]);
        DB::table('actividades')->where('id', $actividad_7)->update(['imagen' => "actividades/{$actividad_7}.jpg"]);


        //Beneficios
        $beneficio_1 = DB::table('beneficios')->insertGetId([
            'titulo' => 'Mejora la capacidad cardiovascular',
            'descripcion' => 'Fortalece el corazón y los pulmones, aumentando la resistencia física.'
        ]);

        $beneficio_2 = DB::table('beneficios')->insertGetId([
            'titulo' => 'Reduce el impacto en las articulaciones',
            'descripcion' => 'Al realizarse en el agua, el cuerpo pesa menos y las articulaciones sufren menos estrés.'
        ]);

        $beneficio_3 = DB::table('beneficios')->insertGetId([
            'titulo' => 'Trabaja todo el cuerpo de manera equilibrada',
            'descripcion' => 'Activa simultáneamente brazos, piernas, abdomen y espalda.'
        ]);


        // --- NOTICIAS ---
        $noticia_1 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nueva piscina olímpica en la ciudad',
            'contenido' => 'La ciudad celebra la inauguración de una infraestructura acuática sin precedentes. Esta piscina olímpica de 50 metros cuenta con sistemas de cronometraje Omega de última generación y un sistema de filtración por microclima que garantiza la pureza del agua sin el uso excesivo de químicos. Diseñada para competiciones internacionales, el recinto ofrece gradas para 500 espectadores y zonas de recuperación térmica para atletas de alto rendimiento. Un hito que posiciona a nuestra comunidad como el epicentro de la natación competitiva.'    ,
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_2,
            'fecha' => Carbon::now()->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_1)->update(['imagen' => "noticias/{$noticia_1}.jpg"]);

        $noticia_2 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nuevo gimnasio en el centro',
            'contenido' => 'Abrimos las puertas del centro deportivo más exclusivo de la zona. Nuestro nuevo gimnasio premium no solo ofrece maquinaria de fuerza de la línea Life Fitness, sino que introduce un concepto de entrenamiento basado en la biomecánica aplicada. Contamos con una zona de peso libre expandida, un box de entrenamiento funcional y un estudio de ciclo indoor con realidad virtual. Además, cada socio dispondrá de un programa de seguimiento digitalizado para monitorizar sus progresos en tiempo real a través de nuestra app oficial.',
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_1,
            'fecha' => Carbon::now()->subDay(2)->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_2)->update(['imagen' => "noticias/{$noticia_2}.jpg"]);






        // --- CURSOS ---

        $curso_1 = DB::table('cursos')->insertGetId([
            'nombre' => 'Aguas al aire Libre',
            'descripcion' => 'Entrenamiento de agua que te va a mejorar la resistencia y el bienestar ya sea en el entorno natural o en una piscina.',
        ]);
        DB::table('cursos')->where('id', $curso_1)->update(['imagen' => "cursos/{$curso_1}.jpg"]);


        $curso_2 = DB::table('cursos')->insertGetId([
            'nombre' => 'Yoga para principiantes',
            'descripcion' => 'Introducción al yoga con ejercicios básicos y técnicas de respiración.',
        ]);
        DB::table('cursos')->where('id', $curso_2)->update(['imagen' => "cursos/{$curso_2}.jpg"]);

        $curso_3 = DB::table('cursos')->insertGetId([
            'nombre' => 'Entrenamiento funcional',
            'descripcion' => 'Ejercicios que imitan movimientos diarios para mejorar la fuerza y resistencia.',
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

        $video_7 = DB::table('videos')->insertGetId([
            'titulo'=> 'Waterpolo',
            'url'=> 'https://www.youtube.com/watch?v=CJ5QdXknEYs'
        ]);

        $video_8 = DB::table('videos')->insertGetId([
            'titulo'=> 'Natacion general',
            'url'=> 'https://www.youtube.com/watch?v=v6oQnrJ1grU&pp=ygURbmF0YWNpb24gZGVwb3J0ZSA%3D'
        ]);

        $video_9 = DB::table('videos')->insertGetId([
            'titulo'=> 'Natacion Sincronizada',
            'url'=> 'https://www.youtube.com/watch?v=ewbP346WkdU&pp=ygUibmF0YWNpb24gc2luY29uaXphZGEgIGNvbW8gaGFjZXJsbw%3D%3D'
        ]);

        //Horarios
        $horario_1= DB::table('horarios')->insertGetId([
            'dia' => 'Lunes',
            'hora_inicio'=> '08:00',
            'hora_fin' => '14:30',
        ]);

        $horario_1= DB::table('horarios')->insertGetId([
            'dia' => 'Martes',
            'hora_inicio'=> '08:00',
            'hora_fin' => '14:30',
            'estado' => true
        ]);



        //----RELACIONES----
        DB::table('videoables')->insert([
            ['video_id' => $video_1, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_2, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_3, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_4, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_5, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_6, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_7, 'videoable_id' => $curso_1, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            ['video_id' => $video_8, 'videoable_id' => $curso_1, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            ['video_id' => $video_9, 'videoable_id' => $curso_1, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
        ]);

        // Relación Centro - Curso
        DB::table('centro_curso')->insert([
            ['centro_id' => $centro_1, 'curso_id' => $curso_1, 'created_at' => now()],
            ['centro_id' => $centro_1, 'curso_id' => $curso_2, 'created_at' => now()],
            ['centro_id' => $centro_2, 'curso_id' => $curso_3, 'created_at' => now()],
        ]);

        // Relación Actividad - Curso
        DB::table('actividad_curso')->insert([
            ['actividad_id' => $actividad_1, 'curso_id' => $curso_1, 'created_at' => now()],
            ['actividad_id' => $actividad_7, 'curso_id' => $curso_1, 'created_at' => now()],
            ['actividad_id' => $actividad_2, 'curso_id' => $curso_3, 'created_at' => now()]
        ]);

        // Inscripciones
        DB::table('inscripciones')->insert([
            [
                'centro_id'      => $centro_1,
                'user_id'        => $jefe,
                'fecha_alta'     => Carbon::now(),
                'fecha_inicio'   => Carbon::now(),
                'stripe_id'      => 'sub_test_' . Str::random(24), 
                'tarifa_id'      => null,
                'status'         => 'active', 
                'activo'         => true,
            ],
            [
                'centro_id'      => $centro_1,
                'user_id'        => $usuario_1,
                'fecha_alta'     => Carbon::now(),
                'fecha_inicio'   => Carbon::now(),
                'stripe_id'      => 'sub_test_' . Str::random(24),
                'tarifa_id'      => $tarifa_1,
                'status'         => 'active',
                'activo'         => true,
            ],
            [
                'centro_id'      => $centro_2,
                'user_id'        => $usuario_1,
                'fecha_alta'     => Carbon::now()->subDays(2),
                'fecha_inicio'   => Carbon::now()->subMonth(),
                'stripe_id'      => 'sub_test_' . Str::random(24),
                'tarifa_id'      => $tarifa_4,
                'status'         => 'active',
                'activo'         => true,
            ]
        ]);

        // Roles de usuario
        DB::table('usuario_rol')->insert([
            ['user_id' => $admin, 'rol_id' => $rol_1, 'created_at' => now()],
            ['user_id' => $jefe, 'rol_id' => $rol_2, 'created_at' => now()],
            ['user_id' => $usuario_1, 'rol_id' => $rol_3, 'created_at' => now()],
        ]);

        // Instalaciones del centro
        DB::table('centro_instalacion')->insert([
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_1, 'created_at' => now()],
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_2, 'created_at' => now()],
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_3, 'created_at' => now()],
            ['centro_id' => $centro_2, 'instalacion_id' => $instalacion_1, 'created_at' => now()],
        ]);

        DB::table('beneficio_curso')->insert([
        [
            'beneficio_id' => $beneficio_1,
            'curso_id'     => $curso_1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ],
        [
            'beneficio_id' => $beneficio_2,
            'curso_id'     => $curso_1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ],
        [
            'beneficio_id' => $beneficio_3,
            'curso_id'     => $curso_1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ],
        ]);


        $sesion_1 = DB::table('sesiones')->insertGetId([
            'fecha'        => '2026-06-01', 
            'capacidad'    => 20,
            'centro_id'    => 1,            
            'curso_id'     => 1,            
            'actividad_id' => 1,           
            'horario_id'   => 1,            
            'estado'       => true,
        ]);


        DB::table('reservas')->insert([
            'user_id'=> $usuario_1,
            'sesion_id' => $sesion_1,
            'estado' => 'Confirmada'
        ]);

    }


}