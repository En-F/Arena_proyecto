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
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4f46e5; /* El mismo azul del registro */
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9fafb;
            border-left: 4px solid #4f46e5;
            border-radius: 4px;
        }
        .label {
            font-weight: bold;
            color: #4f46e5;
            display: block;
            font-size: 14px;
            text-transform: uppercase;
        }
        .message-box {
            background: #ffffff;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            margin-top: 10px;
            font-style: italic;
        }
        .footer {
            background-color: #f9fafb;
            color: #6b7280;
            padding: 15px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📩 Nuevo mensaje de contacto</h1>
        </div>
        <div class="content">
            <div class="info-row">
                <span class="label">Remitente:</span>
                <span>{{ $datos['nombre'] }}</span>
            </div>

            <div class="info-row">
                <span class="label">Correo electrónico:</span>
                <span>{{ $datos['email'] }}</span>
            </div>

            <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 20px 0;">

            <span class="label">Mensaje recibido:</span>
            <div class="message-box">
                "{{ $datos['mensaje'] }}"
            </div>
        </div>
        <div class="footer">
            Este correo ha sido generado automáticamente por el sistema de <strong>{{ config('app.name') }}</strong>.
        </div>
    </div>
</body>
</html>
