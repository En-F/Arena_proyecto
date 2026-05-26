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


        // --- CENTROS ORIGINALES ---
        $centro_1 = DB::table('centros')->insertGetId([
            'nombre' => 'Ok+',
            'descripcion' => 'Centro deportivo con dos piscinas de 25 metros, ambas con climatización, gimnasio remodelado y amplias zonas para practicar deportes tanto de bicicleta, baile, bachata, zona de crossfit y actividades al aire libre.',
            'direccion' => 'Av. de la Rondeña, 11540 Sanlúcar de Barrameda, Cádiz',
            'telefono' => '657804438',
            'email' => 'info-sanlucar@okeymas.es',
            'latitud' => 36.77384,
            'longitud' => -6.34497
        ]);
        DB::table('centros')->where('id', $centro_1)->update(['imagen' => "centros/{$centro_1}.jpg"]);

        $centro_2 = DB::table('centros')->insertGetId([
            'nombre' => 'Gimnasio Core Fitness',
            'descripcion' => 'Un gimnasio equipado con las últimas máquinas de entrenamiento y un equipo de entrenadores profesionales con piscina.',
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

        $centro_4 = DB::table('centros')->insertGetId([
            'nombre' => 'Elite Performance Center',
            'direccion' => 'Av. de los Deportes, 45, Parque Tecnológico',
            'telefono' => '910223344',
            'email' => 'info@eliteperformance.com',
            'descripcion' => 'Centro de alto rendimiento abierto a todos los niveles. Especializado en entrenamiento de fuerza, deportes de combate y recuperación funcional.',
            'created_at' => now(),
        ]);
        DB::table('centros')->where('id', $centro_4)->update(['imagen' => "centros/{$centro_4}.jpg"]);

        $centro_5 = DB::table('centros')->insertGetId([
            'nombre' => 'Aqua Sports Club',
            'descripcion' => 'Centro especializado en deportes acuáticos. Contamos con piscina olímpica, piscina para entrenamientos de natación sincronizada, zona de aguas termales y spa acuático. Entrenadores certificados en todas las disciplinas acuáticas.',
            'direccion' => 'Calle Náutica, 25, Puerto de Santa María',
            'telefono' => '956123456',
            'email' => 'info@aquasports.es',
            'latitud' => 36.59,
            'longitud' => -6.23,
            'created_at' => now(),
        ]);
        DB::table('centros')->where('id', $centro_5)->update(['imagen' => "centros/{$centro_5}.jpg"]);

        $centro_7 = DB::table('centros')->insertGetId([
            'nombre' => 'Wellness & Balance Studio',
            'descripcion' => 'Centro holístico dedicado al bienestar integral. Especializados en yoga, pilates, meditación, aromaterapia y masajes terapéuticos. Ambiente tranquilo y relajante con instructores certificados internacionalmente.',
            'direccion' => 'Plaza del Zen, 5, Sanlúcar de Barrameda',
            'telefono' => '657654321',
            'email' => 'info@wellnessbalance.es',
            'latitud' => 36.77,
            'longitud' => -6.35,
            'created_at' => now(),
        ]);
        DB::table('centros')->where('id', $centro_7)->update(['imagen' => "centros/{$centro_7}.jpg"]);




        //---VALORACIONES---//
        DB::table('valoraciones')->insert([
            [
                'titulo' => 'Instalaciones top',
                'comentario' => 'La zona de aguas es increíble y las máquinas de cardio son muy modernas. Muy recomendable.',
                'puntuacion' => 5,
                'centro_id' => $centro_1,
                'user_id' => $jefe,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Buen ambiente',
                'comentario' => 'Me gusta mucho el ambiente de las clases dirigidas, aunque a veces hay mucha gente.',
                'puntuacion' => 4,
                'centro_id' => $centro_1,
                'user_id' => $admin,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Atención mejorable',
                'comentario' => 'El centro está muy bien pero en recepción tardaron bastante en atenderme.',
                'puntuacion' => 3,
                'centro_id' => $centro_1,
                'user_id' => $jefe, 
                'created_at' => now(),
            ],
        ]);

        DB::table('valoraciones')->insert([
            [
                'titulo' => 'La mejor piscina',
                'comentario' => 'La nueva piscina olímpica es una pasada. Entrenar aquí es un lujo para cualquier nadador.',
                'puntuacion' => 5,
                'centro_id' => $centro_2,
                'user_id' => $admin,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Muy profesional',
                'comentario' => 'Los entrenadores saben de lo que hablan y te corrigen la técnica constantemente.',
                'puntuacion' => 5,
                'centro_id' => $centro_2,
                'user_id' => $jefe,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Un poco pequeño',
                'comentario' => 'Las máquinas son muy buenas pero el espacio de peso libre se queda algo corto en horas punta.',
                'puntuacion' => 3,
                'centro_id' => $centro_2,
                'user_id' => $admin,
                'created_at' => now(),
            ],
        ]);

        DB::table('valoraciones')->insert([
            [
                'titulo' => 'Pistas de pádel impecables',
                'comentario' => 'He jugado en muchas pistas y estas son de las mejores de la provincia. El cristal panorámico es un acierto.',
                'puntuacion' => 5,
                'centro_id' => $centro_3,
                'user_id' => $jefe,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Ideal para familias',
                'comentario' => 'Llevo a mis hijos a la escuela de fútbol y están encantados. Muy seguro y bien organizado.',
                'puntuacion' => 4,
                'centro_id' => $centro_3,
                'user_id' => $admin,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Falta algo de limpieza',
                'comentario' => 'Las pistas de tenis están bien, pero los vestuarios necesitan un poco más de mantenimiento.',
                'puntuacion' => 2,
                'centro_id' => $centro_3,
                'user_id' => $jefe,
                'created_at' => now(),
            ],
        ]);

        DB::table('valoraciones')->insert([
            [
                'titulo' => 'Material de primera',
                'comentario' => 'Es el único sitio de la ciudad con jaulas de potencia profesionales y zona de kickboxing real.',
                'puntuacion' => 5,
                'centro_id' => $centro_4,
                'user_id' => $admin,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Un poco caro pero vale la pena',
                'comentario' => 'La cuota es algo más alta que la media, pero no hay aglomeraciones y las duchas están impecables.',
                'puntuacion' => 4,
                'centro_id' => $centro_4,
                'user_id' => $jefe,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Clases de Kickboxing brutales',
                'comentario' => 'El instructor es un profesional. He aprendido más en un mes aquí que en un año en otros sitios.',
                'puntuacion' => 5,
                'centro_id' => $centro_4,
                'user_id' => $jefe,
                'created_at' => now(),
            ],
        ]);

        DB::table('valoraciones')->insert([
            [
                'titulo' => 'Paraíso acuático',
                'comentario' => 'Las instalaciones de natación son impresionantes. La piscina olímpica es perfecta y el personal es muy atento.',
                'puntuacion' => 5,
                'centro_id' => $centro_5,
                'user_id' => $jefe,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Excelente para natación',
                'comentario' => 'Mejor que muchos centros de natación que he probado. Los entrenadores saben realmente enseñar.',
                'puntuacion' => 5,
                'centro_id' => $centro_5,
                'user_id' => $admin,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Muy buenas aguas termales',
                'comentario' => 'La zona de spa y aguas termales es relajante. Perfecto para recuperarse después del entrenamiento.',
                'puntuacion' => 4,
                'centro_id' => $centro_5,
                'user_id' => $admin,
                'created_at' => now(),
            ],
        ]);


        // Reseñas Centro 7 (Wellness & Balance)
        DB::table('valoraciones')->insert([
            [
                'titulo' => 'Santuario de paz',
                'comentario' => 'El ambiente es increíblemente relajante. Las clases de yoga cambiarán tu perspectiva. Muy profesional.',
                'puntuacion' => 5,
                'centro_id' => $centro_7,
                'user_id' => $admin,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Equilibrio perfecto',
                'comentario' => 'Combinan perfectamente yoga, pilates y meditación. Es lo que necesitaba para mi bienestar mental.',
                'puntuacion' => 5,
                'centro_id' => $centro_7,
                'user_id' => $jefe,
                'created_at' => now(),
            ],
            [
                'titulo' => 'Masajes terapéuticos excelentes',
                'comentario' => 'Los masajistas son expertos. Junto con las clases, es el lugar perfecto para recuperarse del estrés.',
                'puntuacion' => 5,
                'centro_id' => $centro_7,
                'user_id' => $admin,
                'created_at' => now(),
            ],
        ]);


        //--- TARIFAS ---
        // Centro 1 (Ok+) - 3 tarifas
        $tarifa_1 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 24.90, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '19:00:00', 'hora_fin' => '23:59:00', 'reservas_semanales' => 3, 'centro_id' => $centro_1, 'created_at' => now()]);
        $tarifa_2 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 45.00, 'periodo' => 'mes', 'descuento' => 10, 'hora_inicio' => '07:00:00', 'hora_fin' => '22:00:00', 'reservas_semanales' => 5, 'centro_id' => $centro_1, 'created_at' => now()]);
        $tarifa_3 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 80.00, 'periodo' => 'mes', 'descuento' => 20, 'hora_inicio' => '00:00:00', 'hora_fin' => '23:59:59', 'reservas_semanales' => 99, 'centro_id' => $centro_1, 'created_at' => now()]);
        
        // Centro 2 (Core Fitness) - 3 tarifas
        $tarifa_4 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 19.90, 'periodo' => 'mes', 'descuento' => 5, 'hora_inicio' => '07:00:00', 'hora_fin' => '12:00:00', 'reservas_semanales' => 2, 'centro_id' => $centro_2, 'created_at' => now()]);
        $tarifa_5 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 29.90, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '10:00:00', 'hora_fin' => '18:00:00', 'reservas_semanales' => 3, 'centro_id' => $centro_2, 'created_at' => now()]);
        $tarifa_6 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 75.00, 'periodo' => 'mes', 'descuento' => 15, 'hora_inicio' => '00:00:00', 'hora_fin' => '23:59:59', 'reservas_semanales' => 15, 'centro_id' => $centro_2, 'created_at' => now()]);
        
        // Centro 3 (La Marina) - 3 tarifas
        $tarifa_7 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 99.00, 'periodo' => 'mes', 'descuento' => 25, 'hora_inicio' => '07:00:00', 'hora_fin' => '22:00:00', 'reservas_semanales' => 20, 'centro_id' => $centro_3, 'created_at' => now()]);
        $tarifa_8 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 39.90, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '08:00:00', 'hora_fin' => '21:00:00', 'reservas_semanales' => 6, 'centro_id' => $centro_3, 'created_at' => now()]);
        $tarifa_9 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 22.00, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '12:00:00', 'hora_fin' => '17:00:00', 'reservas_semanales' => 2, 'centro_id' => $centro_3, 'created_at' => now()]);
        
        // Centro 4 (Elite Performance) - 3 tarifas
        $tarifa_10 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 35.00, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '06:00:00', 'hora_fin' => '13:00:00', 'reservas_semanales' => 4, 'centro_id' => $centro_4, 'created_at' => now()]);
        $tarifa_11 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 65.00, 'periodo' => 'mes', 'descuento' => 12, 'hora_inicio' => '06:00:00', 'hora_fin' => '22:00:00', 'reservas_semanales' => 8, 'centro_id' => $centro_4, 'created_at' => now()]);
        $tarifa_12 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 140.00, 'periodo' => 'mes', 'descuento' => 25, 'hora_inicio' => '00:00:00', 'hora_fin' => '23:59:59', 'reservas_semanales' => 99, 'centro_id' => $centro_4, 'created_at' => now()]);

        // Centro 5 (Aqua Sports) - 3 tarifas
        $tarifa_13 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 28.00, 'periodo' => 'mes', 'descuento' => 5, 'hora_inicio' => '07:00:00', 'hora_fin' => '14:00:00', 'reservas_semanales' => 3, 'centro_id' => $centro_5, 'created_at' => now()]);
        $tarifa_14 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 49.90, 'periodo' => 'mes', 'descuento' => 10, 'hora_inicio' => '07:00:00', 'hora_fin' => '20:00:00', 'reservas_semanales' => 6, 'centro_id' => $centro_5, 'created_at' => now()]);
        $tarifa_15 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 95.00, 'periodo' => 'mes', 'descuento' => 20, 'hora_inicio' => '00:00:00', 'hora_fin' => '23:59:59', 'reservas_semanales' => 99, 'centro_id' => $centro_5, 'created_at' => now()]);


        // Centro 7 (Wellness & Balance) - 3 tarifas
        $tarifa_19 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 25.00, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '09:00:00', 'hora_fin' => '14:00:00', 'reservas_semanales' => 3, 'centro_id' => $centro_7, 'created_at' => now()]);
        $tarifa_20 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 45.00, 'periodo' => 'mes', 'descuento' => 10, 'hora_inicio' => '09:00:00', 'hora_fin' => '20:00:00', 'reservas_semanales' => 5, 'centro_id' => $centro_7, 'created_at' => now()]);
        $tarifa_21 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 85.00, 'periodo' => 'mes', 'descuento' => 20, 'hora_inicio' => '08:00:00', 'hora_fin' => '21:00:00', 'reservas_semanales' => 99, 'centro_id' => $centro_7, 'created_at' => now()]);


        $instalacion_1 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Gimnasio Fitness',
            'imagen' => 'gym',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_1)->update(['imagen' => "instalaciones/ic-{$instalacion_1}.png"]);

        $instalacion_2 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Campo de Fútbol',
            'imagen' => 'soccer',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_2)->update(['imagen' => "instalaciones/ic-{$instalacion_2}.png"]);

        $instalacion_3 = DB::table('instalaciones')->insertGetId([
            'nombre' => 'Sala de Yoga',
            'imagen' => 'yoga',
            'created_at' => now(),
        ]);
        DB::table('instalaciones')->where('id', $instalacion_3)->update(['imagen' => "instalaciones/ic-{$instalacion_3}.png"]);

        $instalacion_4 = DB::table('instalaciones')->insertGetId(['nombre' => 'Piscina Climatizada', 'imagen' => 'pool', 'created_at' => now()]);
        DB::table('instalaciones')->where('id', $instalacion_4)->update(['imagen' => "instalaciones/ic-{$instalacion_4}.png"]);

        $instalacion_5 = DB::table('instalaciones')->insertGetId(['nombre' => 'Pistas de Pádel', 'imagen' => 'padel', 'created_at' => now()]);
        DB::table('instalaciones')->where('id', $instalacion_5)->update(['imagen' => "instalaciones/ic-{$instalacion_5}.png"]);

        $instalacion_6 = DB::table('instalaciones')->insertGetId(['nombre' => 'Zona Crossfit', 'imagen' => 'crossfit', 'created_at' => now()]);
        DB::table('instalaciones')->where('id', $instalacion_6)->update(['imagen' => "instalaciones/ic-{$instalacion_6}.png"]);

        $instalacion_7 = DB::table('instalaciones')->insertGetId(['nombre' => 'Sala de Ciclo Indoor', 'imagen' => 'bike', 'created_at' => now()]);
        DB::table('instalaciones')->where('id', $instalacion_7)->update(['imagen' => "instalaciones/ic-{$instalacion_7}.png"]);

        $instalacion_8 = DB::table('instalaciones')->insertGetId(['nombre' => 'Pista de Atletismo', 'imagen' => 'running', 'created_at' => now()]);
        DB::table('instalaciones')->where('id', $instalacion_8)->update(['imagen' => "instalaciones/ic-{$instalacion_8}.png"]);

        $instalacion_9 = DB::table('instalaciones')->insertGetId(['nombre' => 'Sala de Boxeo', 'imagen' => 'boxing', 'created_at' => now()]);
        DB::table('instalaciones')->where('id', $instalacion_9)->update(['imagen' => "instalaciones/ic-{$instalacion_9}.png"]);

        $instalacion_10 = DB::table('instalaciones')->insertGetId(['nombre' => 'Pistas de Tenis', 'imagen' => 'tennis', 'created_at' => now()]);
        DB::table('instalaciones')->where('id', $instalacion_10)->update(['imagen' => "instalaciones/ic-{$instalacion_10}.png"]);

        $instalacion_11 = DB::table('instalaciones')->insertGetId(['nombre' => 'Sauna y Spa', 'imagen' => 'spa', 'created_at' => now()]);
        DB::table('instalaciones')->where('id', $instalacion_11)->update(['imagen' => "instalaciones/ic-{$instalacion_11}.png"]);





        $actividad_1 = DB::table('actividades')->insertGetId([
            'nombre' => 'Natación',
            'descripcion' => 'Disciplina acuática integral que combina resistencia y fuerza. Ideal para fortalecer el sistema cardiovascular en un entorno de bajo impacto articular.',
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

        $actividad_8 = DB::table('actividades')->insertGetId(['nombre' => 'Crossfit', 'descripcion' => 'Entrenamiento funcional extremo.', 'nivel' => 'dificil', 'tipo_id' => $tipo_2, 'created_at' => now()]);
        DB::table('actividades')->where('id', $actividad_8)->update(['imagen' => "actividades/{$actividad_8}.jpg"]);

        $actividad_9 = DB::table('actividades')->insertGetId(['nombre' => 'Yoga', 'descripcion' => 'Equilibrio y paz mental.', 'nivel' => 'facil', 'tipo_id' => $tipo_3, 'created_at' => now()]);
        DB::table('actividades')->where('id', $actividad_9)->update(['imagen' => "actividades/{$actividad_9}.jpg"]);

        $actividad_10 = DB::table('actividades')->insertGetId([
            'nombre' => 'Boxeo',
            'descripcion' => 'Entrenamiento de alta intensidad centrado en la técnica de golpeo, agilidad defensiva y una resistencia cardiovascular inigualable.',
            'nivel' => 'intermedio',
            'tipo_id' => $tipo_2,
            'created_at' => now()
        ]);
        DB::table('actividades')->where('id', $actividad_10)->update(['imagen' => "actividades/{$actividad_10}.jpg"]);

        $actividad_11 = DB::table('actividades')->insertGetId([
            'nombre' => 'Tenis',
            'descripcion' => 'Duelo de precisión y velocidad. Mejora tu potencia de saque, coordinación ojo-mano y resistencia en partidos individuales o dobles.',
            'nivel' => 'intermedio',
            'tipo_id' => $tipo_1,
            'created_at' => now()
        ]);
        DB::table('actividades')->where('id', $actividad_11)->update(['imagen' => "actividades/{$actividad_11}.jpg"]);

        $actividad_12 = DB::table('actividades')->insertGetId([
            'nombre' => 'Zumba',
            'descripcion' => 'Combina ritmos latinos e internacionales con ejercicios de intervalos para un entrenamiento cardiovascular divertido y lleno de energía.',
            'nivel' => 'facil',
            'tipo_id' => $tipo_4,
            'created_at' => now()
        ]);
        DB::table('actividades')->where('id', $actividad_12)->update(['imagen' => "actividades/{$actividad_12}.jpg"]);

        $actividad_13 = DB::table('actividades')->insertGetId([
            'nombre' => 'Body Pump',
            'descripcion' => 'Entrenamiento con barras y discos que fortalece todo el cuerpo mediante repeticiones de alta frecuencia. Esculpe y tonifica rápidamente.',
            'nivel' => 'intermedio',
            'tipo_id' => $tipo_2,
            'created_at' => now()
        ]);
        DB::table('actividades')->where('id', $actividad_13)->update(['imagen' => "actividades/{$actividad_13}.jpg"]);

        $actividad_14 = DB::table('actividades')->insertGetId([
            'nombre' => 'Spinning Pro',
            'descripcion' => 'Sesión de ciclismo indoor de alta montaña. Desafía tus límites con sprints y escaladas simuladas bajo luces y música motivadora.',
            'nivel' => 'dificil',
            'tipo_id' => $tipo_4,
            'created_at' => now()
        ]);
        DB::table('actividades')->where('id', $actividad_14)->update(['imagen' => "actividades/{$actividad_14}.jpg"]);

        $actividad_15 = DB::table('actividades')->insertGetId([
            'nombre' => 'Pádel',
            'descripcion' => 'Deporte social y dinámico. Aprende las técnicas de rebote en pared, bandejas y voleas en nuestras pistas de cristal panorámico.',
            'nivel' => 'facil',
            'tipo_id' => $tipo_1,
            'created_at' => now()
        ]);
        DB::table('actividades')->where('id', $actividad_15)->update(['imagen' => "actividades/{$actividad_15}.jpg"]);

        $actividad_16 = DB::table('actividades')->insertGetId([
            'nombre' => 'Calistenia',
            'descripcion' => 'Domina tu propio peso corporal. Entrenamiento de fuerza pura en barras para lograr movimientos espectaculares y control total del cuerpo.',
            'nivel' => 'dificil',
            'tipo_id' => $tipo_2,
            'created_at' => now()
        ]);
        DB::table('actividades')->where('id', $actividad_16)->update(['imagen' => "actividades/{$actividad_16}.jpg"]);




        // --- NOTICIAS ---
        $noticia_1 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nueva piscina olímpica en la ciudad',
            'contenido' => 'La ciudad celebra la inauguración de una infraestructura acuática sin precedentes. Esta piscina olímpica de 50 metros cuenta con sistemas de cronometraje Omega de última generación y un sistema de filtración por microclima que garantiza la pureza del agua sin el uso excesivo de químicos. Diseñada para competiciones internacionales, el recinto ofrece gradas para 500 espectadores y zonas de recuperación térmica para atletas de alto rendimiento. Un hito que posiciona a nuestra comunidad como el epicentro de la natación competitiva.',
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

        $noticia_3 = DB::table('noticias')->insertGetId([
            'titulo' => 'Primer Gran Torneo de Pádel de Primavera',
            'contenido' => 'Abrimos las inscripciones para el torneo más esperado de la temporada. Nuestras pistas de cristal panorámicas acogerán a más de 100 parejas en distintas categorías. Habrá premios valorados en más de 2.000€, welcome pack para todos los participantes y zona de chill-out con DJ y foodtrucks para disfrutar del tercer tiempo. ¡Demuestra tu nivel en la pista!',
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_1,
            'fecha' => Carbon::now()->subDays(4)->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_3)->update(['imagen' => "noticias/{$noticia_3}.jpg"]);

        $noticia_4 = DB::table('noticias')->insertGetId([
            'titulo' => 'Masterclass Inmersiva de Yoga y Mindfulness',
            'contenido' => 'Conecta cuerpo y mente en nuestra nueva sala zen inmersiva. Este próximo fin de semana organizaremos una masterclass de Vinyasa Yoga de 2 horas impartida por instructores internacionales. La sesión estará acompañada de aromaterapia, cuencos tibetanos y una proyección envolvente para llevar tu estado de relajación y flexibilidad al siguiente nivel.',
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_2,
            'fecha' => Carbon::now()->subDays(6)->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_4)->update(['imagen' => "noticias/{$noticia_4}.jpg"]);

        $noticia_5 = DB::table('noticias')->insertGetId([
            'titulo' => 'Renovación Total de la Zona de Spinning',
            'contenido' => '¡A pedaleo limpio! Hemos actualizado completamente nuestra sala de ciclo indoor con 40 nuevas bicicletas de última generación con medidores de potencia integrados. Las nuevas pantallas gigantes te permitirán recorrer virtualmente puertos de montaña míticos del Tour de Francia mientras mides tu rendimiento cardiovascular con la máxima precisión.',
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_3 ?? $centro_1, // Fallback por si no tienes $centro_3
            'fecha' => Carbon::now()->subDays(9)->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_5)->update(['imagen' => "noticias/{$noticia_5}.jpg"]);

        $noticia_6 = DB::table('noticias')->insertGetId([
            'titulo' => 'Nuevo Servicio de Nutrición Deportiva Avanzada',
            'contenido' => 'El rendimiento no solo se forja en el gimnasio, también en la cocina. Inauguramos nuestro gabinete de nutrición deportiva. Contamos con tecnología de bioimpedancia para analizar tu composición corporal al detalle y crear planes nutricionales 100% personalizados, ya sea para pérdida de grasa, hipertrofia o mejora del rendimiento aeróbico.',
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_1,
            'fecha' => Carbon::now()->subDays(12)->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_6)->update(['imagen' => "noticias/{$noticia_6}.jpg"]);

        $noticia_7 = DB::table('noticias')->insertGetId([
            'titulo' => 'Academia Infantil de Artes Marciales',
            'contenido' => 'Inculcamos valores de disciplina, respeto y superación desde pequeños. Nuestra nueva academia infantil ofrece clases de judo y taekwondo para niños de 5 a 12 años. Impartidas por cinturones negros titulados, estas sesiones están diseñadas para mejorar la psicomotricidad y la confianza de los más jóvenes en un entorno seguro y divertido.',
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_2,
            'fecha' => Carbon::now()->subDays(15)->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_7)->update(['imagen' => "noticias/{$noticia_7}.jpg"]);

        $noticia_8 = DB::table('noticias')->insertGetId([
            'titulo' => 'Club de Running: Preparación para la Media Maratón',
            'contenido' => '¿Tu objetivo es cruzar la meta? Únete a nuestro nuevo Club de Running oficial. Organizamos salidas grupales guiadas por las mejores rutas de la ciudad, sesiones de técnica de carrera en pista y entrenamientos de fuerza específicos para evitar lesiones. Incluye planificación semanal adaptada a todos los niveles, desde debutantes hasta sub-1:30h.',
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_3 ?? $centro_2,
            'fecha' => Carbon::now()->subDays(18)->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_8)->update(['imagen' => "noticias/{$noticia_8}.jpg"]);

        $noticia_9 = DB::table('noticias')->insertGetId([
            'titulo' => 'Ampliación de Horarios Ininterrumpidos',
            'contenido' => '¡Se acabaron las excusas! Escuchando las peticiones de nuestros socios, ampliamos nuestro horario de apertura. A partir del próximo mes, las instalaciones estarán disponibles desde las 6:00 AM hasta las 23:30 PM de lunes a viernes, y fines de semana hasta las 21:00. Más flexibilidad para que adaptes el entrenamiento a tu dinámico ritmo de vida.',
            'user_id' => $admin,
            'created_at' => now(),
            'centro_id' => $centro_1,
            'fecha' => Carbon::now()->subDays(20)->format('Y-m-d')
        ]);
        DB::table('noticias')->where('id', $noticia_9)->update(['imagen' => "noticias/{$noticia_9}.jpg"]);



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

        $curso_4 = DB::table('cursos')->insertGetId(['nombre' => 'Deportes de Equipo', 'descripcion' => 'Fútbol, Basket y Waterpolo.', 'created_at' => now()]);
        $curso_5 = DB::table('cursos')->insertGetId(['nombre' => 'Triatlón Prep', 'descripcion' => 'Natación, Ciclismo y Carrera.', 'created_at' => now()]);
        $curso_6 = DB::table('cursos')->insertGetId(['nombre' => 'Potencia Máxima', 'descripcion' => 'Fuerza, Crossfit y Fútbol.', 'created_at' => now()]);
        $curso_7 = DB::table('cursos')->insertGetId(['nombre' => 'Flexibilidad Total', 'descripcion' => 'Yoga, Pilates y Natación suave.', 'created_at' => now()]);
        $curso_8 = DB::table('cursos')->insertGetId(['nombre' => 'Artes Marciales Mixtas', 'descripcion' => 'Dominio de técnicas de golpeo y defensa.', 'created_at' => now()]);
        $curso_9 = DB::table('cursos')->insertGetId(['nombre' => 'Fuerza Extrema', 'descripcion' => 'Powerlifting, Crossfit y Calistenia.', 'created_at' => now()]);
        $curso_10 = DB::table('cursos')->insertGetId(['nombre' => 'Fitness de Combate', 'descripcion' => 'Quema de grasa mediante movimientos de lucha.', 'created_at' => now()]);

        for ($i = 4; $i <= 10; $i++) {
            DB::table('cursos')->where('id', ${"curso_$i"})->update(['imagen' => "cursos/".${"curso_$i"}.".jpg"]);
        }


        //----VIDEOS----
        // NATACIÓN
        $video_1 = DB::table('videos')->insertGetId([
            'titulo'=> 'Mariposa - Técnica completa',
            'url'=> 'https://www.youtube.com/watch?v=YlhXuC25_L4'
        ]);

        $video_2 = DB::table('videos')->insertGetId([
            'titulo'=> 'Estilo Espalda - Tutorial',
            'url'=> 'https://www.youtube.com/watch?v=tbwFnGfh0X8'
        ]);

        $video_3 = DB::table('videos')->insertGetId([
            'titulo'=> 'Braza - Guía para principiantes',
            'url'=> 'https://www.youtube.com/watch?v=kcwwyFMIofs'
        ]);

        $video_4 = DB::table('videos')->insertGetId([
            'titulo'=> 'Croll o Estilo Libre',
            'url'=> 'https://www.youtube.com/watch?v=u5ZWVginAXQ'
        ]);

        $video_5 = DB::table('videos')->insertGetId([
            'titulo'=> 'Saltos desde trampolín',
            'url'=> 'https://www.youtube.com/watch?v=IzMvBMj5Kzc'
        ]);

        $video_6 = DB::table('videos')->insertGetId([
            'titulo'=> 'Brazadas en natación',
            'url'=> 'https://www.youtube.com/watch?v=5cS4oXMTmgI'
        ]);

        $video_7 = DB::table('videos')->insertGetId([
            'titulo'=> 'Waterpolo - Básicos del juego',
            'url'=> 'https://www.youtube.com/watch?v=CJ5QdXknEYs'
        ]);

        $video_8 = DB::table('videos')->insertGetId([
            'titulo'=> 'Natación deportiva - Entrenamiento',
            'url'=> 'https://www.youtube.com/watch?v=v6oQnrJ1grU'
        ]);

        $video_9 = DB::table('videos')->insertGetId([
            'titulo'=> 'Natación sincronizada',
            'url'=> 'https://www.youtube.com/watch?v=ewbP346WkdU'
        ]);

        // YOGA Y PILATES
        $video_10 = DB::table('videos')->insertGetId([
            'titulo'=> 'Yoga para principiantes - 30 minutos',
            'url'=> 'https://www.youtube.com/watch?v=DFiO6LA5IIc&pp=ygULeW9nYSAzMCBtaW4%3D'
        ]);

        $video_11 = DB::table('videos')->insertGetId([
            'titulo'=> 'Pilates Básico - Fortalecimiento core',
            'url'=> 'https://www.youtube.com/watch?v=jzH0c_Zq7Ug&pp=ygUPUGlsYXRlcyBCw6FzaWNv'
        ]);

        $video_12 = DB::table('videos')->insertGetId([
            'titulo'=> 'Yoga Vinyasa - Flujo dinámico',
            'url'=> 'https://www.youtube.com/watch?v=ORZqGpZguD0&pp=ygUMWW9nYSBWaW55YXNh'
        ]);

        // CROSSFIT Y FUERZA
        $video_13 = DB::table('videos')->insertGetId([
            'titulo'=> 'Crossfit - Entrenamiento en casa',
            'url'=> 'https://www.youtube.com/watch?v=R7fUPxmQlU4&pp=ygUaRW50cmVuYW1pZW50byBXT0QgY29tcGxldG8%3D'
        ]);

        $video_14 = DB::table('videos')->insertGetId([
            'titulo'=> 'Calistenia - Domina tu peso corporal',
            'url'=> 'https://www.youtube.com/watch?v=PpeH3Tj3nm0&pp=ygUKQ2FsaXN0ZW5pYQ%3D%3D'
        ]);

        $video_15 = DB::table('videos')->insertGetId([
            'titulo'=> 'Body Pump - Entrenamiento con barras',
            'url'=> 'https://www.youtube.com/watch?v=KyewQ_22X6s&pp=ygUJQm9keSBQdW1w'
        ]);

        // BOXEO Y ARTES MARCIALES
        $video_16 = DB::table('videos')->insertGetId([
            'titulo'=> 'Boxeo - Técnica de golpeo básica',
            'url'=> 'https://www.youtube.com/watch?v=B_YHSnEHKJU&pp=ygUiQm94ZW8gLSBUw6ljbmljYSBkZSBnb2xwZW8gYsOhc2ljYdIHCQkECwGHKiGM7w%3D%3D'
        ]);

        $video_17 = DB::table('videos')->insertGetId([
            'titulo'=> 'Kickboxing - Tutorial completo',
            'url'=> 'https://www.youtube.com/watch?v=Vevc8bHctTQ&pp=ygUTS2lja2JveGluZyBhcHJlbmRlcg%3D%3D'
        ]);

        $video_18 = DB::table('videos')->insertGetId([
            'titulo'=> 'Artes marciales mixtas - Técnicas',
            'url'=> 'https://www.youtube.com/watch?v=3WRCGl-wPl0&pp=ygUfQXJ0ZXMgbWFyY2lhbGVzIG1peHRhcyBhcHJlbmRlctIHCQkECwGHKiGM7w%3D%3D'
        ]);


        $video_20 = DB::table('videos')->insertGetId([
            'titulo'=> 'Ciclismo outdoor - Técnica de pedalada',
            'url'=> 'https://www.youtube.com/watch?v=Lxii6TdpAmw&pp=ygUUVMOpY25pY2EgZGUgcGVkYWxhZGE%3D'
        ]);

        // DEPORTES DE EQUIPO
        $video_21 = DB::table('videos')->insertGetId([
            'titulo'=> 'Fútbol - Técnica de pase y tiro',
            'url'=> 'https://www.youtube.com/watch?v=yLz_5shPGL0&pp=ygUhRsO6dGJvbCAtIFTDqWNuaWNhIGRlIHBhc2UgeSB0aXJv'
        ]);

        $video_22 = DB::table('videos')->insertGetId([
            'titulo'=> 'Baloncesto - Fundamentos del juego',
            'url'=> 'https://www.youtube.com/watch?v=5F_HNvP0nZY&pp=ygUiQmFsb25jZXN0byAtIEZ1bmRhbWVudG9zIGRlbCBqdWVnbw%3D%3D'
        ]);

        $video_23 = DB::table('videos')->insertGetId([
            'titulo'=> 'Pádel - Técnicas y estrategia',
            'url'=> 'https://www.youtube.com/watch?v=HH_c-E0b-9M&pp=ygUfUMOhZGVsIC0gVMOpY25pY2FzIHkgZXN0cmF0ZWdpYQ%3D%3D'
        ]);

        $video_24 = DB::table('videos')->insertGetId([
            'titulo'=> 'Tenis - Técnica de saque y golpeo',
            'url'=> 'https://www.youtube.com/watch?v=kQ6zcfxI-2g&pp=ygUiVGVuaXMgLSBUw6ljbmljYSBkZSBzYXF1ZSB5IGdvbHBlbw%3D%3D'
        ]);

        // CARDIO Y DANZA
        $video_25 = DB::table('videos')->insertGetId([
            'titulo'=> 'Zumba - Coreografía para principiantes',
            'url'=> 'https://www.youtube.com/watch?v=mdK0OfyE5l8&pp=ygUnWnVtYmEgLSBDb3Jlb2dyYWbDrWEgcGFyYSBwcmluY2lwaWFudGVz'
        ]);

        $video_26 = DB::table('videos')->insertGetId([
            'titulo'=> 'Atletismo - Técnica de carrera',
            'url'=> 'https://youtu.be/T6DgTuc4lRY?si=gpLStuEmz2jLBCqx'
        ]);

        $video_27 = DB::table('videos')->insertGetId([
            'titulo'=> 'Entrenamiento de potencia - Sprint',
            'url'=> 'https://www.youtube.com/watch?v=eTn_hgP85k4&pp=ygUkRW50cmVuYW1pZW50byBkZSBwb3RlbmNpYSAtIFNwcmludCcs'
        ]);

        



        //----RELACIONES----
        DB::table('videoables')->insert([
            // Natación (Curso 1 - Aguas al aire libre)
            ['video_id' => $video_1, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_2, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_3, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_4, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_5, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_6, 'videoable_id' => $actividad_1, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_7, 'videoable_id' => $curso_1, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            ['video_id' => $video_8, 'videoable_id' => $curso_1, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            ['video_id' => $video_9, 'videoable_id' => $curso_1, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            
            // Yoga (Curso 2)
            ['video_id' => $video_10, 'videoable_id' => $curso_2, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            ['video_id' => $video_12, 'videoable_id' => $curso_2, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            ['video_id' => $video_10, 'videoable_id' => $actividad_9, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Pilates (Curso 2)
            ['video_id' => $video_11, 'videoable_id' => $curso_2, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            ['video_id' => $video_11, 'videoable_id' => $actividad_5, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Crossfit (Curso 6 - Potencia máxima)
            ['video_id' => $video_13, 'videoable_id' => $curso_6, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            ['video_id' => $video_13, 'videoable_id' => $actividad_8, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Body Pump
            ['video_id' => $video_15, 'videoable_id' => $actividad_13, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Spinning
            
            // Ciclismo
            ['video_id' => $video_20, 'videoable_id' => $actividad_2, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Fútbol
            ['video_id' => $video_21, 'videoable_id' => $actividad_3, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_21, 'videoable_id' => $curso_4, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            
            // Baloncesto
            ['video_id' => $video_22, 'videoable_id' => $actividad_6, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_22, 'videoable_id' => $curso_4, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            
            // Waterpolo
            ['video_id' => $video_7, 'videoable_id' => $actividad_7, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Boxeo
            ['video_id' => $video_16, 'videoable_id' => $actividad_10, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_16, 'videoable_id' => $curso_10, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            
            // Kickboxing
            ['video_id' => $video_17, 'videoable_id' => $curso_8, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            
            // Artes Marciales Mixtas
            ['video_id' => $video_18, 'videoable_id' => $curso_8, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            
            // Tenis
            ['video_id' => $video_24, 'videoable_id' => $actividad_11, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_26, 'videoable_id' => $actividad_11, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Pádel
            ['video_id' => $video_23, 'videoable_id' => $actividad_15, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Zumba
            ['video_id' => $video_25, 'videoable_id' => $actividad_12, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Atletismo
            ['video_id' => $video_26, 'videoable_id' => $actividad_4, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_26, 'videoable_id' => $curso_5, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            
            // Calistenia
            ['video_id' => $video_14, 'videoable_id' => $actividad_16, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_14, 'videoable_id' => $curso_9, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
        ]);

        // Relación Centro - Curso
        DB::table('centro_curso')->insert([
            // Centro 1 (Ok+)
            ['centro_id' => $centro_1, 'curso_id' => $curso_1, 'created_at' => now()], // Aguas al aire Libre
            ['centro_id' => $centro_1, 'curso_id' => $curso_6, 'created_at' => now()], // Potencia Máxima

            // Centro 2 (Core Fitness)
            ['centro_id' => $centro_2, 'curso_id' => $curso_2, 'created_at' => now()], // Yoga para principiantes
            ['centro_id' => $centro_2, 'curso_id' => $curso_4, 'created_at' => now()], // Deportes de Equipo

            // Centro 3 (La Marina)
            ['centro_id' => $centro_3, 'curso_id' => $curso_3, 'created_at' => now()], // Entrenamiento funcional
            ['centro_id' => $centro_3, 'curso_id' => $curso_5, 'created_at' => now()], // Triatlón Prep

            // Centro 4 (Elite Performance)
            ['centro_id' => $centro_4, 'curso_id' => $curso_8, 'created_at' => now()], // Artes Marciales Mixtas
            ['centro_id' => $centro_4, 'curso_id' => $curso_9, 'created_at' => now()], // Fuerza Extrema

            // Centro 5 (Aqua Sports)
            ['centro_id' => $centro_5, 'curso_id' => $curso_1, 'created_at' => now()], // Aguas al aire Libre
            ['centro_id' => $centro_5, 'curso_id' => $curso_5, 'created_at' => now()], // Triatlón Prep


            // Centro 7 (Wellness & Balance)
            ['centro_id' => $centro_7, 'curso_id' => $curso_2, 'created_at' => now()], // Yoga para principiantes
            ['centro_id' => $centro_7, 'curso_id' => $curso_7, 'created_at' => now()], // Flexibilidad Total
        ]);

        // Relación Actividad - Curso
       // --- ASIGNACIÓN DE ACTIVIDADES A CURSOS/CENTROS (4 POR CENTRO) ---
        // --- ASIGNACIÓN DE ACTIVIDADES A CURSOS (Tabla pivot: actividad_curso) ---
        DB::table('actividad_curso')->insert([
            // Curso 1 (Generalmente asociado a Centro 1 y 5)
            ['curso_id' => $curso_1, 'actividad_id' => $actividad_1],  // Natación
            ['curso_id' => $curso_1, 'actividad_id' => $actividad_2],  // Ciclismo
            ['curso_id' => $curso_1, 'actividad_id' => $actividad_8],  // Crossfit
            ['curso_id' => $curso_1, 'actividad_id' => $actividad_12], // Zumba

            // Curso 2 (Generalmente asociado a Centro 2 y 7)
            ['curso_id' => $curso_2, 'actividad_id' => $actividad_1],  // Natación
            ['curso_id' => $curso_2, 'actividad_id' => $actividad_13], // Body Pump
            ['curso_id' => $curso_2, 'actividad_id' => $actividad_5],  // Pilates
            ['curso_id' => $curso_2, 'actividad_id' => $actividad_9],  // Yoga

            // Curso 3 (Generalmente asociado a Centro 3)
            ['curso_id' => $curso_3, 'actividad_id' => $actividad_3],  // Fútbol
            ['curso_id' => $curso_3, 'actividad_id' => $actividad_6],  // Baloncesto
            ['curso_id' => $curso_3, 'actividad_id' => $actividad_11], // Tenis
            ['curso_id' => $curso_3, 'actividad_id' => $actividad_15], // Pádel

            // Curso 4 (Generalmente asociado a Centro 2)
            ['curso_id' => $curso_4, 'actividad_id' => $actividad_13], // Body Pump
            ['curso_id' => $curso_4, 'actividad_id' => $actividad_2],  // Ciclismo
            ['curso_id' => $curso_4, 'actividad_id' => $actividad_16], // Calistenia
            ['curso_id' => $curso_4, 'actividad_id' => $actividad_8],  // Crossfit

            // Curso 5 (Generalmente asociado a Centro 3 y 5)
            ['curso_id' => $curso_5, 'actividad_id' => $actividad_7],  // Waterpolo
            ['curso_id' => $curso_5, 'actividad_id' => $actividad_14], // Spinning Pro
            ['curso_id' => $curso_5, 'actividad_id' => $actividad_1],  // Natación
            ['curso_id' => $curso_5, 'actividad_id' => $actividad_3],  // Fútbol

            // Curso 7 (Generalmente asociado a Centro 7)
            ['curso_id' => $curso_7, 'actividad_id' => $actividad_9],  // Yoga
            ['curso_id' => $curso_7, 'actividad_id' => $actividad_5],  // Pilates
            ['curso_id' => $curso_7, 'actividad_id' => $actividad_12], // Zumba
            ['curso_id' => $curso_7, 'actividad_id' => $actividad_10], // Boxeo

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
        ]);

        // Roles de usuario
        DB::table('usuario_rol')->insert([
            ['user_id' => $admin, 'rol_id' => $rol_1, 'created_at' => now()],
            ['user_id' => $jefe, 'rol_id' => $rol_2, 'created_at' => now()],
        ]);

        // Instalaciones del centro
        DB::table('centro_instalacion')->insert([
            // Centro 1 (Ok+)
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_1, 'created_at' => now()],  // Gimnasio
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_3, 'created_at' => now()],  // Yoga
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_6, 'created_at' => now()],  // Crossfit

            // Centro 2 (Core Fitness)
            ['centro_id' => $centro_2, 'instalacion_id' => $instalacion_4, 'created_at' => now()],  // Piscina
            ['centro_id' => $centro_2, 'instalacion_id' => $instalacion_7, 'created_at' => now()],  // Ciclo Indoor
            ['centro_id' => $centro_2, 'instalacion_id' => $instalacion_9, 'created_at' => now()],  // Boxeo

            // Centro 3 (La Marina)
            ['centro_id' => $centro_3, 'instalacion_id' => $instalacion_2, 'created_at' => now()],  // Fútbol
            ['centro_id' => $centro_3, 'instalacion_id' => $instalacion_5, 'created_at' => now()],  // Pádel
            ['centro_id' => $centro_3, 'instalacion_id' => $instalacion_10, 'created_at' => now()], // Tenis

            // Centro 4 (Elite Performance)
            ['centro_id' => $centro_4, 'instalacion_id' => $instalacion_9, 'created_at' => now()],  // Boxeo
            ['centro_id' => $centro_4, 'instalacion_id' => $instalacion_6, 'created_at' => now()],  // Crossfit
            ['centro_id' => $centro_4, 'instalacion_id' => $instalacion_11, 'created_at' => now()], // Spa

            // Centro 5 (Aqua Sports)
            ['centro_id' => $centro_5, 'instalacion_id' => $instalacion_4, 'created_at' => now()],  // Piscina Climatizada
            ['centro_id' => $centro_5, 'instalacion_id' => $instalacion_11, 'created_at' => now()], // Spa

            // Centro 7 (Wellness & Balance)
            ['centro_id' => $centro_7, 'instalacion_id' => $instalacion_3, 'created_at' => now()],  // Sala de Yoga
            ['centro_id' => $centro_7, 'instalacion_id' => $instalacion_11, 'created_at' => now()], // Spa
        ]);

        //Beneficios
        $b1 = DB::table('beneficios')->insertGetId(['titulo' => 'Resistencia Cardiovascular', 'descripcion' => 'Fortalece el corazón y mejora la circulación.', 'created_at' => now()]);
        $b2 = DB::table('beneficios')->insertGetId(['titulo' => 'Salud Articular', 'descripcion' => 'Minimiza el impacto en huesos y articulaciones.', 'created_at' => now()]);
        $b3 = DB::table('beneficios')->insertGetId(['titulo' => 'Pérdida de Peso', 'descripcion' => 'Alta quema calórica en sesiones intensivas.', 'created_at' => now()]);
        $b4 = DB::table('beneficios')->insertGetId(['titulo' => 'Reducción de Estrés', 'descripcion' => 'Libera endorfinas y mejora el bienestar mental.', 'created_at' => now()]);
        $b5 = DB::table('beneficios')->insertGetId(['titulo' => 'Fuerza Muscular', 'descripcion' => 'Desarrolla y tonifica los grupos musculares clave.', 'created_at' => now()]);
        $b6 = DB::table('beneficios')->insertGetId(['titulo' => 'Flexibilidad Mejorada', 'descripcion' => 'Aumenta el rango de movimiento y evita lesiones.', 'created_at' => now()]);
        $b7 = DB::table('beneficios')->insertGetId(['titulo' => 'Coordinación y Equilibrio', 'descripcion' => 'Mejora la agilidad y el control corporal.', 'created_at' => now()]);
        $b8 = DB::table('beneficios')->insertGetId(['titulo' => 'Socialización', 'descripcion' => 'Entrena en equipo y conoce gente con tus metas.', 'created_at' => now()]);
        $b9 = DB::table('beneficios')->insertGetId(['titulo' => 'Postura Corporal', 'descripcion' => 'Fortalece el core y corrige la alineación de la espalda.', 'created_at' => now()]);
        $b10 = DB::table('beneficios')->insertGetId(['titulo' => 'Calidad del Sueño', 'descripcion' => 'Ayuda a conciliar un descanso más profundo y reparador.', 'created_at' => now()]);

        DB::table('beneficio_curso')->insert([
            
            [
                'beneficio_id' => $b1,
                'curso_id'     => $curso_1,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b4,
                'curso_id'     => $curso_1,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b9,
                'curso_id'     => $curso_1,
                'created_at'   => now(), 'updated_at' => now()
            ],
            
            [
                'beneficio_id' => $b2,
                'curso_id'     => $curso_2,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b5,
                'curso_id'     => $curso_2,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b10,
                'curso_id'     => $curso_2,
                'created_at'   => now(), 'updated_at' => now()
            ],
            
            [
                'beneficio_id' => $b3,
                'curso_id'     => $curso_3,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b6,
                'curso_id'     => $curso_3,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b8,
                'curso_id'     => $curso_3,
                'created_at'   => now(), 'updated_at' => now()
            ],
            
            [
                'beneficio_id' => $b7,
                'curso_id'     => $curso_4,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b1,
                'curso_id'     => $curso_4,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b4,
                'curso_id'     => $curso_4,
                'created_at'   => now(), 'updated_at' => now()
            ],
            
            [
                'beneficio_id' => $b5,
                'curso_id'     => $curso_5,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b2,
                'curso_id'     => $curso_5,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b9,
                'curso_id'     => $curso_5,
                'created_at'   => now(), 'updated_at' => now()
            ],
            
            [
                'beneficio_id' => $b3,
                'curso_id'     => $curso_6,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b8,
                'curso_id'     => $curso_6,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b10,
                'curso_id'     => $curso_6,
                'created_at'   => now(), 'updated_at' => now()
            ],
            
            [
                'beneficio_id' => $b1,
                'curso_id'     => $curso_7,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b6,
                'curso_id'     => $curso_7,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b7,
                'curso_id'     => $curso_7,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b5,
                'curso_id'     => $curso_8,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b7,
                'curso_id'     => $curso_8,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b3,
                'curso_id'     => $curso_8,
                'created_at'   => now(), 'updated_at' => now()
            ],

            // Curso 9: Fuerza Extrema
            [
                'beneficio_id' => $b5,
                'curso_id'     => $curso_9,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b9,
                'curso_id'     => $curso_9,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b3,
                'curso_id'     => $curso_9,
                'created_at'   => now(), 'updated_at' => now()
            ],

            // Curso 10: Fitness de Combate
            [
                'beneficio_id' => $b1,
                'curso_id'     => $curso_10,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b3,
                'curso_id'     => $curso_10,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b4,
                'curso_id'     => $curso_10,
                'created_at'   => now(), 'updated_at' => now()
            ],
        ]);


        // --- HORARIOS (Reutilizamos los mismos) ---
        $horario_1 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '07:00', 'hora_fin' => '08:30', 'estado' => true, 'created_at' => now()]);
        $horario_2 = DB::table('horarios')->insertGetId(['dia' => 'Martes', 'hora_inicio' => '09:00', 'hora_fin' => '10:30', 'estado' => true, 'created_at' => now()]);
        $horario_3 = DB::table('horarios')->insertGetId(['dia' => 'Miércoles', 'hora_inicio' => '11:00', 'hora_fin' => '12:30', 'estado' => true, 'created_at' => now()]);
        $horario_4 = DB::table('horarios')->insertGetId(['dia' => 'Jueves', 'hora_inicio' => '14:00', 'hora_fin' => '15:30', 'estado' => true, 'created_at' => now()]);
        $horario_5 = DB::table('horarios')->insertGetId(['dia' => 'Viernes', 'hora_inicio' => '16:00', 'hora_fin' => '17:30', 'estado' => true, 'created_at' => now()]);
        $horario_6 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '10:00', 'hora_fin' => '13:00', 'estado' => true, 'created_at' => now()]);
        $horario_7 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '18:00', 'hora_fin' => '19:30', 'estado' => true, 'created_at' => now()]);
        $horario_8 = DB::table('horarios')->insertGetId(['dia' => 'Martes', 'hora_inicio' => '20:00', 'hora_fin' => '21:30', 'estado' => true, 'created_at' => now()]);
        $horario_9 = DB::table('horarios')->insertGetId(['dia' => 'Miércoles', 'hora_inicio' => '21:30', 'hora_fin' => '23:00', 'estado' => true, 'created_at' => now()]);
        $horario_10 = DB::table('horarios')->insertGetId(['dia' => 'Jueves', 'hora_inicio' => '08:00', 'hora_fin' => '12:00', 'estado' => true, 'created_at' => now()]);
        $horario_11 = DB::table('horarios')->insertGetId(['dia' => 'Viernes', 'hora_inicio' => '18:00', 'hora_fin' => '22:00', 'estado' => true, 'created_at' => now()]);
        $horario_12 = DB::table('horarios')->insertGetId(['dia' => 'Viernes', 'hora_inicio' => '17:00', 'hora_fin' => '17:30', 'estado' => true, 'created_at' => now()]);
        $horario_13 = DB::table('horarios')->insertGetId(['dia' => 'Jueves', 'hora_inicio' => '08:00', 'hora_fin' => '09:30', 'estado' => true, 'created_at' => now()]);
        $horario_14 = DB::table('horarios')->insertGetId(['dia' => 'Martes', 'hora_inicio' => '10:00', 'hora_fin' => '11:30', 'estado' => true, 'created_at' => now()]);
        $horario_15 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '15:00', 'hora_fin' => '16:30', 'estado' => true, 'created_at' => now()]);


        $horario_noche_ok = DB::table('horarios')->insertGetId([
            'dia' => 'Martes', 'hora_inicio' => '20:30', 'hora_fin' => '23:40', 'estado' => true, 'created_at' => now()
        ]);

        // ==========================================
        // 2. CONFIGURACIÓN Y GENERACIÓN GENERAL
        // ==========================================
        // 1. INSERCIÓN DE HORARIOS (Lunes a Viernes)
        $horario_1 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '07:00', 'hora_fin' => '08:30', 'estado' => true, 'created_at' => now()]);
        $horario_2 = DB::table('horarios')->insertGetId(['dia' => 'Martes', 'hora_inicio' => '09:00', 'hora_fin' => '10:30', 'estado' => true, 'created_at' => now()]);
        $horario_3 = DB::table('horarios')->insertGetId(['dia' => 'Miércoles', 'hora_inicio' => '11:00', 'hora_fin' => '12:30', 'estado' => true, 'created_at' => now()]);
        $horario_4 = DB::table('horarios')->insertGetId(['dia' => 'Jueves', 'hora_inicio' => '14:00', 'hora_fin' => '15:30', 'estado' => true, 'created_at' => now()]);
        $horario_5 = DB::table('horarios')->insertGetId(['dia' => 'Viernes', 'hora_inicio' => '16:00', 'hora_fin' => '17:30', 'estado' => true, 'created_at' => now()]);
        $horario_6 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '10:00', 'hora_fin' => '13:00', 'estado' => true, 'created_at' => now()]);
        $horario_7 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '18:00', 'hora_fin' => '19:30', 'estado' => true, 'created_at' => now()]);
        $horario_8 = DB::table('horarios')->insertGetId(['dia' => 'Martes', 'hora_inicio' => '20:00', 'hora_fin' => '21:30', 'estado' => true, 'created_at' => now()]);
        $horario_9 = DB::table('horarios')->insertGetId(['dia' => 'Miércoles', 'hora_inicio' => '21:30', 'hora_fin' => '23:00', 'estado' => true, 'created_at' => now()]);
        $horario_10 = DB::table('horarios')->insertGetId(['dia' => 'Jueves', 'hora_inicio' => '08:00', 'hora_fin' => '12:00', 'estado' => true, 'created_at' => now()]);
        $horario_11 = DB::table('horarios')->insertGetId(['dia' => 'Viernes', 'hora_inicio' => '18:00', 'hora_fin' => '22:00', 'estado' => true, 'created_at' => now()]);
        $horario_12 = DB::table('horarios')->insertGetId(['dia' => 'Viernes', 'hora_inicio' => '17:00', 'hora_fin' => '17:30', 'estado' => true, 'created_at' => now()]);
        $horario_13 = DB::table('horarios')->insertGetId(['dia' => 'Jueves', 'hora_inicio' => '08:00', 'hora_fin' => '09:30', 'estado' => true, 'created_at' => now()]);
        $horario_14 = DB::table('horarios')->insertGetId(['dia' => 'Martes', 'hora_inicio' => '10:00', 'hora_fin' => '11:30', 'estado' => true, 'created_at' => now()]);
        $horario_15 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '15:00', 'hora_fin' => '16:30', 'estado' => true, 'created_at' => now()]);

        $horario_noche_ok = DB::table('horarios')->insertGetId([
            'dia' => 'Martes', 'hora_inicio' => '20:30', 'hora_fin' => '23:40', 'estado' => true, 'created_at' => now()
        ]);

        // ==========================================
        // 2. CONFIGURACIÓN Y GENERACIÓN GENERAL
        // ==========================================
        $hoy = Carbon::create(2026, 5, 26);
        
        $config_centros_cursos = [
            $centro_1 => [$curso_1, $curso_6],
            $centro_2 => [$curso_2, $curso_4],
            $centro_3 => [$curso_3, $curso_5],
            $centro_4 => [$curso_8, $curso_9],
            $centro_5 => [$curso_1, $curso_5],
            $centro_7 => [$curso_2, $curso_7],
        ];

        $horarios_disponibles = [
            $horario_1, $horario_2, $horario_3, $horario_4, $horario_5,
            $horario_6, $horario_7, $horario_8, $horario_9, $horario_10,
            $horario_11, $horario_12, $horario_13, $horario_14, $horario_15
        ];

        $sesion_counter = 0;

        foreach ($config_centros_cursos as $centro_id => $cursos) {
            foreach ($cursos as $curso_id) {
                $actividades_curso = DB::table('actividad_curso')->where('curso_id', $curso_id)->pluck('actividad_id')->toArray();

                if (count($actividades_curso) > 0) {
                    $dias_generados = 0;
                    $intento_dia = 0;

                    // Generamos 5 sesiones pero saltando fines de semana
                    while ($dias_generados < 5) {
                        $fecha_temp = $hoy->copy()->addDays($intento_dia);
                        
                        // Si es Sábado (6) o Domingo (0), no insertamos y pasamos al siguiente día
                        if (!$fecha_temp->isWeekend()) {
                            DB::table('sesiones')->insert([
                                'fecha'        => $fecha_temp->format('Y-m-d'),
                                'capacidad'    => rand(12, 25),
                                'centro_id'    => $centro_id,
                                'curso_id'     => $curso_id,
                                'actividad_id' => $actividades_curso[$sesion_counter % count($actividades_curso)],
                                'horario_id'   => $horarios_disponibles[$sesion_counter % count($horarios_disponibles)],
                                'estado'       => true,
                                'created_at'   => now(),
                                'updated_at'   => now(),
                            ]);
                            $dias_generados++;
                            $sesion_counter++;
                        }
                        $intento_dia++;
                    }
                }
            }
        }

        // ==========================================
        // 3. SESIONES EXTRA: CENTRO OK+ (LUNES A VIERNES)
        // ==========================================
        $reparto_ok = [
            '2026-05-25' => 1, // Lunes
            '2026-05-26' => 2, // Martes
            '2026-05-27' => 3, // Miércoles
            '2026-05-28' => 1, // Jueves
            '2026-05-29' => 2, // Viernes
        ];

        $acts_ok = DB::table('actividad_curso')->where('curso_id', $curso_1)->pluck('actividad_id')->toArray();

        if (count($acts_ok) > 0) {
            foreach ($reparto_ok as $fecha_rep => $cantidad) {
                // Validación extra: solo insertar si no es fin de semana
                if (!Carbon::parse($fecha_rep)->isWeekend()) {
                    for ($j = 0; $j < $cantidad; $j++) {
                        DB::table('sesiones')->insert([
                            'fecha'        => $fecha_rep,
                            'capacidad'    => 20,
                            'centro_id'    => $centro_1,
                            'curso_id'     => $curso_1, 
                            'actividad_id' => $acts_ok[$j % count($acts_ok)],
                            'horario_id'   => $horario_noche_ok,
                            'estado'       => true,
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);
                    }
                }
            }
        }

        // ==========================================
        // 4. SESIONES EXTRA: ELITE PERFORMANCE (CENTRO 4)
        // ==========================================
        $reparto_elite = [
            '2026-05-25' => 1, '2026-05-26' => 2, '2026-05-27' => 1, '2026-05-28' => 2, '2026-05-29' => 1,
        ];

        $acts_elite = DB::table('actividad_curso')->whereIn('curso_id', [$curso_8, $curso_9])->pluck('actividad_id')->toArray();
        $horarios_elite = [$horario_8, $horario_10, $horario_11, $horario_4];

        if (count($acts_elite) > 0) {
            $e_counter = 0;
            foreach ($reparto_elite as $fecha_e => $cantidad) {
                if (!Carbon::parse($fecha_e)->isWeekend()) {
                    for ($k = 0; $k < $cantidad; $k++) {
                        DB::table('sesiones')->insert([
                            'fecha'        => $fecha_e,
                            'capacidad'    => rand(10, 15),
                            'centro_id'    => $centro_4,
                            'curso_id'     => ($k % 2 == 0) ? $curso_8 : $curso_9,
                            'actividad_id' => $acts_elite[$e_counter % count($acts_elite)],
                            'horario_id'   => $horarios_elite[$e_counter % count($horarios_elite)],
                            'estado'       => true,
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);
                        $e_counter++;
                    }
                }
            }
        }
    
        
    }
}