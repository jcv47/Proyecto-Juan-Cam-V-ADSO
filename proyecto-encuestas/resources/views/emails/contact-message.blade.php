<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuevo mensaje</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #e8f2fc; font-family: Arial, sans-serif; padding: 2rem 1rem; }

        .email-wrap { max-width: 560px; margin: 0 auto; }
        .email-card { background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #d0e4f7; }

        .email-header { background: #e8f2fc; padding: 1.75rem 2rem 1.25rem; text-align: center; }
        .email-header .logo { font-size: 18px; font-weight: bold; color: #185FA5; margin-bottom: 0.4rem; }
        .email-header h1 { font-size: 20px; font-weight: 600; color: #185FA5; margin-bottom: 0.2rem; }
        .email-header p { font-size: 13px; color: #378ADD; }

        .email-body { padding: 1.75rem 2rem; }
        .email-body > p { font-size: 15px; color: #2C2C2A; line-height: 1.7; margin-bottom: 1.25rem; }

        .info-grid {
            background: #e8f2fc;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
            display: grid;
            gap: 0.65rem;
        }
        .info-row { display: flex; align-items: flex-start; gap: 10px; }
        .info-label {
            font-size: 12px;
            color: #185FA5;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            min-width: 72px;
            padding-top: 2px;
        }
        .info-value { font-size: 15px; color: #0C447C; font-weight: bold; }

        .divider { border: none; border-top: 1px solid #d0e4f7; margin-bottom: 1.25rem; }

        .mensaje-box {
            background: #f0f7ff;
            border-radius: 8px;
            border: 1px solid #d0e4f7;
            padding: 1rem 1.25rem;
        }
        .mensaje-label {
            font-size: 12px;
            color: #185FA5;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
        .mensaje-text { font-size: 15px; color: #2C2C2A; line-height: 1.7; }

        .email-footer {
            background: #f0f7ff;
            border-top: 1px solid #d0e4f7;
            padding: 1rem 2rem;
            text-align: center;
        }
        .email-footer p { font-size: 12px; color: #5F5E5A; }
    </style>
</head>
<body>
    <div class="email-wrap">
        <div class="email-card">

            <div class="email-header">
                <div class="logo">Sondar</div>
                <h1>Nuevo mensaje de contacto</h1>
                <p>Recibido desde el formulario "Contáctanos"</p>
            </div>

            <div class="email-body">
                <p>Alguien se ha puesto en contacto a través del sitio de <strong style="color:#185FA5;">Sondar</strong>.</p>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Nombre</span>
                        <span class="info-value">{{ $data['nombre'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Correo</span>
                        <span class="info-value">{{ $data['email'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Asunto</span>
                        <span class="info-value">{{ $data['asunto'] }}</span>
                    </div>
                </div>

                <hr class="divider">

                <div class="mensaje-box">
                    <div class="mensaje-label">Mensaje</div>
                    <div class="mensaje-text">{{ $data['mensaje'] }}</div>
                </div>
            </div>

            <div class="email-footer">
                <p>Notificación automática &middot; <span style="color:#185FA5;">Sondar</span></p>
            </div>

        </div>
    </div>
</body>
</html>