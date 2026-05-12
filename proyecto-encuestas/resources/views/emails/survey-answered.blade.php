<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Encuesta respondida</title>
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

        .btn-wrap { text-align: center; margin: 0.5rem 0; }
        .btn {
            display: inline-block;
            background: #2979FF;
            color: #ffffff;
            font-size: 15px;
            font-weight: bold;
            padding: 0.7rem 2rem;
            border-radius: 8px;
            text-decoration: none;
        }

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
                <h1>Encuesta respondida</h1>
                <p>Notificación al panel administrativo</p>
            </div>

            <div class="email-body">
                <p>Un cliente acaba de responder una encuesta en <strong style="color:#185FA5;">Sondar</strong>. Aquí tienes el resumen:</p>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Usuario</span>
                        <span class="info-value">{{ $submission->user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Correo</span>
                        <span class="info-value">{{ $submission->user->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Encuesta</span>
                        <span class="info-value">{{ $submission->survey->titulo }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha</span>
                        <span class="info-value">{{ $submission->created_at }}</span>
                    </div>
                </div>

                <hr class="divider">

                <p>Ingresa al panel administrativo para revisar la respuesta completa.</p>

                <div class="btn-wrap">
                    <a href="{{ route('login') }}" class="btn">Ir al panel →</a>
                </div>
            </div>

            <div class="email-footer">
                <p>Notificación automática &middot; <span style="color:#185FA5;">Sondar</span></p>
            </div>

        </div>
    </div>
</body>
</html>