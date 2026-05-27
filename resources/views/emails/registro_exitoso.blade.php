<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .footer {
            background-color: #f9fafb;
            color: #6b7280;
            padding: 15px;
            text-align: center;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido a {{ config('app.name') }}!</h1>
        </div>
        <div class="content">
            <h2>Hola, {{ $user->name }}</h2>
            <p>Es un placer saludarte. Tu cuenta ha sido creada correctamente en nuestra plataforma.</p>
            <p>A partir de ahora podrás acceder a todas las funcionalidades con tu correo:</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>

            <a href="{{ url('/login') }}" class="button">Acceder a mi cuenta</a>

            <p>Si no has sido tú quien ha realizado este registro, por favor ignora este correo.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
