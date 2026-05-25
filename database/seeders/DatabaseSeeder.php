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

        $centro_4 = DB::table('centros')->insertGetId([
            'nombre' => 'Elite Performance Center',
            'direccion' => 'Av. de los Deportes, 45, Parque Tecnológico',
            'telefono' => '910223344',
            'email' => 'info@eliteperformance.com',
            'descripcion' => 'Centro de alto rendimiento abierto a todos los niveles. Especializado en entrenamiento de fuerza, deportes de combate y recuperación funcional.',
            'created_at' => now(),
        ]);
        DB::table('centros')->where('id', $centro_4)->update(['imagen' => "centros/{$centro_4}.jpg"]);




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
                'user_id' => $admin,
                'created_at' => now(),
            ],
        ]);



        //Tarfias
        $tarifa_1 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 24.90, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '14:00:00', 'hora_fin' => '20:00:00', 'reservas_semanales' => 3, 'centro_id' => $centro_1, 'created_at' => now()]);
        $tarifa_2 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 45.00, 'periodo' => 'mes', 'descuento' => 10, 'hora_inicio' => '07:00:00', 'hora_fin' => '22:00:00', 'reservas_semanales' => 5, 'centro_id' => $centro_1, 'created_at' => now()]);
        $tarifa_3 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 80.00, 'periodo' => 'mes', 'descuento' => 20, 'hora_inicio' => '00:00:00', 'hora_fin' => '23:59:59', 'reservas_semanales' => 99, 'centro_id' => $centro_1, 'created_at' => now()]);
        $tarifa_4 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 19.90, 'periodo' => 'mes', 'descuento' => 5, 'hora_inicio' => '07:00:00', 'hora_fin' => '12:00:00', 'reservas_semanales' => 2, 'centro_id' => $centro_2, 'created_at' => now()]);
        $tarifa_5 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 29.90, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '10:00:00', 'hora_fin' => '18:00:00', 'reservas_semanales' => 3, 'centro_id' => $centro_2, 'created_at' => now()]);
        $tarifa_6 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 75.00, 'periodo' => 'mes', 'descuento' => 15, 'hora_inicio' => '00:00:00', 'hora_fin' => '23:59:59', 'reservas_semanales' => 15, 'centro_id' => $centro_2, 'created_at' => now()]);
        $tarifa_7 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 99.00, 'periodo' => 'mes', 'descuento' => 25, 'hora_inicio' => '07:00:00', 'hora_fin' => '22:00:00', 'reservas_semanales' => 20, 'centro_id' => $centro_3, 'created_at' => now()]);
        $tarifa_8 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 39.90, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '08:00:00', 'hora_fin' => '21:00:00', 'reservas_semanales' => 6, 'centro_id' => $centro_3, 'created_at' => now()]);
        $tarifa_9 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 22.00, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '12:00:00', 'hora_fin' => '17:00:00', 'reservas_semanales' => 2, 'centro_id' => $centro_3, 'created_at' => now()]);
        $tarifa_10 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 120.00, 'periodo' => 'trimestre', 'descuento' => 30, 'hora_inicio' => '00:00:00', 'hora_fin' => '23:59:59', 'reservas_semanales' => 50, 'centro_id' => $centro_1, 'created_at' => now()]);
        
        // --- TARIFAS ELITE PERFORMANCE CENTER ---
        $tarifa_11 = DB::table('tarifas')->insertGetId(['tipo' => 'Basica', 'precio' => 35.00, 'periodo' => 'mes', 'descuento' => 0, 'hora_inicio' => '06:00:00', 'hora_fin' => '13:00:00', 'reservas_semanales' => 4, 'centro_id' => $centro_4, 'created_at' => now()]);
        $tarifa_12 = DB::table('tarifas')->insertGetId(['tipo' => 'Estandar', 'precio' => 65.00, 'periodo' => 'mes', 'descuento' => 12, 'hora_inicio' => '06:00:00', 'hora_fin' => '22:00:00', 'reservas_semanales' => 8, 'centro_id' => $centro_4, 'created_at' => now()]);
        $tarifa_13 = DB::table('tarifas')->insertGetId(['tipo' => 'Premium', 'precio' => 140.00, 'periodo' => 'mes', 'descuento' => 25, 'hora_inicio' => '00:00:00', 'hora_fin' => '23:59:59', 'reservas_semanales' => 99, 'centro_id' => $centro_4, 'created_at' => now()]);


        




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

        $actividad_8 = DB::table('actividades')->insertGetId(['nombre' => 'Crossfit', 'descripcion' => 'Entrenamiento funcional extremo.', 'nivel' => 'dificil', 'tipo_id' => $tipo_2, 'created_at' => now()]);
        DB::table('actividades')->where('id', $actividad_8)->update(['imagen' => "actividades/{$actividad_8}.jpg"]);

        $actividad_9 = DB::table('actividades')->insertGetId(['nombre' => 'Yoga', 'descripcion' => 'Equilibrio y paz mental.', 'nivel' => 'facil', 'tipo_id' => $tipo_3, 'created_at' => now()]);
        DB::table('actividades')->where('id', $actividad_9)->update(['imagen' => "actividades/{$actividad_9}.jpg"]);


        // --- ACTIVIDADES ADICIONALES (10 nuevas) ---

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
            'url'=> 'https://www.youtube.com/watch?v=9vPi-aSmXnE'
        ]);

        $video_11 = DB::table('videos')->insertGetId([
            'titulo'=> 'Pilates Básico - Fortalecimiento core',
            'url'=> 'https://www.youtube.com/watch?v=EUfBwF9M-TQ'
        ]);

        $video_12 = DB::table('videos')->insertGetId([
            'titulo'=> 'Yoga Vinyasa - Flujo dinámico',
            'url'=> 'https://www.youtube.com/watch?v=OMOFfAFj2gE'
        ]);

        // CROSSFIT Y FUERZA
        $video_13 = DB::table('videos')->insertGetId([
            'titulo'=> 'Crossfit - Entrenamiento WOD completo',
            'url'=> 'https://www.youtube.com/watch?v=l6PVgPlU1_s'
        ]);

        $video_14 = DB::table('videos')->insertGetId([
            'titulo'=> 'Calistenia - Domina tu peso corporal',
            'url'=> 'https://www.youtube.com/watch?v=qWd2vDSuYnU'
        ]);

        $video_15 = DB::table('videos')->insertGetId([
            'titulo'=> 'Body Pump - Entrenamiento con barras',
            'url'=> 'https://www.youtube.com/watch?v=Eu1L2VEIBvI'
        ]);

        // BOXEO Y ARTES MARCIALES
        $video_16 = DB::table('videos')->insertGetId([
            'titulo'=> 'Boxeo - Técnica de golpeo básica',
            'url'=> 'https://www.youtube.com/watch?v=kn9reFqW61k'
        ]);

        $video_17 = DB::table('videos')->insertGetId([
            'titulo'=> 'Kickboxing - Tutorial completo',
            'url'=> 'https://www.youtube.com/watch?v=VXp6IvJhFxU'
        ]);

        $video_18 = DB::table('videos')->insertGetId([
            'titulo'=> 'Artes marciales mixtas - Técnicas',
            'url'=> 'https://www.youtube.com/watch?v=2LLfQ9Xd4B8'
        ]);

        // CICLISMO Y SPINNING
        $video_19 = DB::table('videos')->insertGetId([
            'titulo'=> 'Spinning Pro - Sesión intensiva',
            'url'=> 'https://www.youtube.com/watch?v=8SvQ8-EAg6w'
        ]);

        $video_20 = DB::table('videos')->insertGetId([
            'titulo'=> 'Ciclismo outdoor - Técnica de pedalada',
            'url'=> 'https://www.youtube.com/watch?v=F8P6AaOQM2U'
        ]);

        // DEPORTES DE EQUIPO
        $video_21 = DB::table('videos')->insertGetId([
            'titulo'=> 'Fútbol - Técnica de pase y tiro',
            'url'=> 'https://www.youtube.com/watch?v=Lw3FjLMGfMU'
        ]);

        $video_22 = DB::table('videos')->insertGetId([
            'titulo'=> 'Baloncesto - Fundamentos del juego',
            'url'=> 'https://www.youtube.com/watch?v=FCQcj5-qhC8'
        ]);

        $video_23 = DB::table('videos')->insertGetId([
            'titulo'=> 'Pádel - Técnicas y estrategia',
            'url'=> 'https://www.youtube.com/watch?v=8J5q0nQtKN0'
        ]);

        $video_24 = DB::table('videos')->insertGetId([
            'titulo'=> 'Tenis - Técnica de saque y golpeo',
            'url'=> 'https://www.youtube.com/watch?v=bxLhSHo-rmo'
        ]);

        // CARDIO Y DANZA
        $video_25 = DB::table('videos')->insertGetId([
            'titulo'=> 'Zumba - Coreografía para principiantes',
            'url'=> 'https://www.youtube.com/watch?v=Jv-J8lEaM7I'
        ]);

        $video_26 = DB::table('videos')->insertGetId([
            'titulo'=> 'Atletismo - Técnica de carrera',
            'url'=> 'https://www.youtube.com/watch?v=7gLkW9FxCEA'
        ]);

        $video_27 = DB::table('videos')->insertGetId([
            'titulo'=> 'Entrenamiento de potencia - Sprint',
            'url'=> 'https://www.youtube.com/watch?v=Nt2YR81HKxc'
        ]);

        //Horarios
        $horario_1 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '07:00', 'hora_fin' => '08:30', 'estado' => true, 'created_at' => now()]);
        $horario_2 = DB::table('horarios')->insertGetId(['dia' => 'Martes', 'hora_inicio' => '09:00', 'hora_fin' => '10:30', 'estado' => true, 'created_at' => now()]);
        $horario_3 = DB::table('horarios')->insertGetId(['dia' => 'Miércoles', 'hora_inicio' => '11:00', 'hora_fin' => '12:30', 'estado' => true, 'created_at' => now()]);
        $horario_4 = DB::table('horarios')->insertGetId(['dia' => 'Jueves', 'hora_inicio' => '14:00', 'hora_fin' => '15:30', 'estado' => true, 'created_at' => now()]);
        $horario_5 = DB::table('horarios')->insertGetId(['dia' => 'Viernes', 'hora_inicio' => '16:00', 'hora_fin' => '17:30', 'estado' => true, 'created_at' => now()]);
        $horario_6 = DB::table('horarios')->insertGetId(['dia' => 'Sábado', 'hora_inicio' => '10:00', 'hora_fin' => '13:00', 'estado' => true, 'created_at' => now()]);
        $horario_7 = DB::table('horarios')->insertGetId(['dia' => 'Lunes', 'hora_inicio' => '18:00', 'hora_fin' => '19:30', 'estado' => true, 'created_at' => now()]);
        $horario_8 = DB::table('horarios')->insertGetId(['dia' => 'Martes', 'hora_inicio' => '20:00', 'hora_fin' => '21:30', 'estado' => true, 'created_at' => now()]);
        $horario_9 = DB::table('horarios')->insertGetId(['dia' => 'Miércoles', 'hora_inicio' => '21:30', 'hora_fin' => '23:00', 'estado' => true, 'created_at' => now()]);
        $horario_10 = DB::table('horarios')->insertGetId(['dia' => 'Jueves', 'hora_inicio' => '08:00', 'hora_fin' => '12:00', 'estado' => true, 'created_at' => now()]);



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
            ['video_id' => $video_19, 'videoable_id' => $actividad_14, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            
            // Ciclismo
            ['video_id' => $video_20, 'videoable_id' => $actividad_2, 'videoable_type' => 'App\Models\Actividad', 'created_at' => now()],
            ['video_id' => $video_19, 'videoable_id' => $curso_5, 'videoable_type' => 'App\Models\Curso', 'created_at' => now()],
            
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
            ['centro_id' => $centro_1, 'curso_id' => $curso_1, 'created_at' => now()], // Aguas al aire Libre
            ['centro_id' => $centro_1, 'curso_id' => $curso_6, 'created_at' => now()], // Potencia Máxima

            ['centro_id' => $centro_2, 'curso_id' => $curso_2, 'created_at' => now()], // Yoga para principiantes
            ['centro_id' => $centro_2, 'curso_id' => $curso_4, 'created_at' => now()], // Deportes de Equipo

            ['centro_id' => $centro_3, 'curso_id' => $curso_3, 'created_at' => now()], // Entrenamiento funcional
            ['centro_id' => $centro_3, 'curso_id' => $curso_5, 'created_at' => now()], // Triatlón Prep

            ['centro_id' => $centro_4, 'curso_id' => $curso_8, 'created_at' => now()], // Artes Marciales Mixtas
            ['centro_id' => $centro_4, 'curso_id' => $curso_9, 'created_at' => now()], // Fuerza Extrema
        ]);
        // Relación Actividad - Curso
        DB::table('actividad_curso')->insert([
            // Curso 1 (Aguas): Natación + Waterpolo
            ['curso_id' => $curso_1, 'actividad_id' => $actividad_1, 'created_at' => now()],
            ['curso_id' => $curso_1, 'actividad_id' => $actividad_7, 'created_at' => now()],

            // Curso 2 (Yoga): Yoga + Pilates
            ['curso_id' => $curso_2, 'actividad_id' => $actividad_9, 'created_at' => now()],
            ['curso_id' => $curso_2, 'actividad_id' => $actividad_5, 'created_at' => now()],

            // Curso 3 (Funcional): Crossfit + Body Pump
            ['curso_id' => $curso_3, 'actividad_id' => $actividad_8, 'created_at' => now()],
            ['curso_id' => $curso_3, 'actividad_id' => $actividad_13, 'created_at' => now()],

            // Curso 4 (Equipo): Fútbol + Baloncesto
            ['curso_id' => $curso_4, 'actividad_id' => $actividad_3, 'created_at' => now()],
            ['curso_id' => $curso_4, 'actividad_id' => $actividad_6, 'created_at' => now()],

            // Curso 5 (Triatlón): Ciclismo + Atletismo
            ['curso_id' => $curso_5, 'actividad_id' => $actividad_2, 'created_at' => now()],
            ['curso_id' => $curso_5, 'actividad_id' => $actividad_4, 'created_at' => now()],

            // Curso 6 (Potencia): Crossfit + Calistenia
            ['curso_id' => $curso_6, 'actividad_id' => $actividad_8, 'created_at' => now()],
            ['curso_id' => $curso_6, 'actividad_id' => $actividad_16, 'created_at' => now()],

            // Curso 8 (Artes Marciales): Boxeo + Calistenia
            ['curso_id' => $curso_8, 'actividad_id' => $actividad_10, 'created_at' => now()],
            ['curso_id' => $curso_8, 'actividad_id' => $actividad_16, 'created_at' => now()],

            // Curso 9 (Fuerza Extrema): Body Pump + Calistenia
            ['curso_id' => $curso_9, 'actividad_id' => $actividad_13, 'created_at' => now()],
            ['curso_id' => $curso_9, 'actividad_id' => $actividad_16, 'created_at' => now()],
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
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_1, 'created_at' => now()], 
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_3, 'created_at' => now()], 
            ['centro_id' => $centro_1, 'instalacion_id' => $instalacion_6, 'created_at' => now()], 

            ['centro_id' => $centro_2, 'instalacion_id' => $instalacion_4, 'created_at' => now()], 
            ['centro_id' => $centro_2, 'instalacion_id' => $instalacion_7, 'created_at' => now()],  
            ['centro_id' => $centro_2, 'instalacion_id' => $instalacion_9, 'created_at' => now()], 

            ['centro_id' => $centro_3, 'instalacion_id' => $instalacion_2, 'created_at' => now()], 
            ['centro_id' => $centro_3, 'instalacion_id' => $instalacion_5, 'created_at' => now()], 
            ['centro_id' => $centro_3, 'instalacion_id' => $instalacion_10, 'created_at' => now()], 

            ['centro_id' => $centro_4, 'instalacion_id' => $instalacion_9, 'created_at' => now()],  
            ['centro_id' => $centro_4, 'instalacion_id' => $instalacion_6, 'created_at' => now()],  
            ['centro_id' => $centro_4, 'instalacion_id' => $instalacion_11, 'created_at' => now()], 
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
                'beneficio_id' => $b5, // Fuerza Muscular
                'curso_id'     => $curso_8,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b7, // Coordinación y Equilibrio
                'curso_id'     => $curso_8,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b3, // Pérdida de Peso
                'curso_id'     => $curso_8,
                'created_at'   => now(), 'updated_at' => now()
            ],

            // Curso 9: Fuerza Extrema (Body Pump + Calistenia)
            [
                'beneficio_id' => $b5, // Fuerza Muscular
                'curso_id'     => $curso_9,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b9, // Postura Corporal
                'curso_id'     => $curso_9,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b3, // Pérdida de Peso
                'curso_id'     => $curso_9,
                'created_at'   => now(), 'updated_at' => now()
            ],

            // Curso 10: Fitness de Combate (Boxeo + Zumba)
            [
                'beneficio_id' => $b1, // Resistencia Cardiovascular
                'curso_id'     => $curso_10,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b3, // Pérdida de Peso
                'curso_id'     => $curso_10,
                'created_at'   => now(), 'updated_at' => now()
            ],
            [
                'beneficio_id' => $b4, // Reducción de Estrés
                'curso_id'     => $curso_10,
                'created_at'   => now(), 'updated_at' => now()
            ],
        ]);


        $configuracion_cursos = [
        $curso_1  => [$centro_1, $actividad_1, $actividad_7],  // Aguas: Natación, Waterpolo
        $curso_2  => [$centro_2, $actividad_9, $actividad_5],  // Yoga: Yoga, Pilates
        $curso_3  => [$centro_3, $actividad_8, $actividad_13], // Funcional: Crossfit, Body Pump
        $curso_4  => [$centro_2, $actividad_3, $actividad_6],  // Equipo: Fútbol, Basket
        $curso_5  => [$centro_3, $actividad_2, $actividad_4],  // Triatlón: Ciclismo, Atletismo
        $curso_6  => [$centro_1, $actividad_8, $actividad_16], // Potencia: Crossfit, Calistenia
        $curso_7  => [$centro_2, $actividad_9, $actividad_5],  // Flexibilidad: Yoga, Pilates
        $curso_8  => [$centro_4, $actividad_10, $actividad_16],// MMA: Boxeo, Calistenia
        $curso_9  => [$centro_4, $actividad_13, $actividad_16],// Fuerza: Body Pump, Calistenia
        $curso_10 => [$centro_4, $actividad_10, $actividad_12],// Combate: Boxeo, Zumba
    ];

    foreach ($configuracion_cursos as $cursoId => $datos) {
        $centroId = $datos[0];
        $acts = [$datos[1], $datos[2]];

        for ($i = 0; $i < 7; $i++) {
            $fecha = Carbon::create(2026, 5, 25)->addDays($i)->format('Y-m-d');
            
            $actividadId = $acts[$i % 2]; 
            
            // Asignamos un horario (del 1 al 10) rotando para que no coincidan todos a la misma hora
            $horarioId = ${"horario_" . (($i + $cursoId) % 10 + 1)};

            DB::table('sesiones')->insert([
                'fecha'        => $fecha,
                'capacidad'    => rand(15, 25), // Capacidad aleatoria para dar realismo
                'centro_id'    => $centroId,
                'curso_id'     => $cursoId,
                'actividad_id' => $actividadId,
                'horario_id'   => $horarioId,
                'estado'       => true,
                'created_at'   => now(),
            ]);
        }
    }

    }

}