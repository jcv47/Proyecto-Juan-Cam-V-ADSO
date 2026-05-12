<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nueva encuesta</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #e8f2fc; font-family: Arial, sans-serif; padding: 2rem 1rem; }

        .email-wrap { max-width: 560px; margin: 0 auto; }
        .email-card { background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #d0e4f7; }

        .email-header { background: #e8f2fc; padding: 2rem 2rem 1.5rem; text-align: center; }
        .email-header .logo { font-size: 18px; font-weight: bold; color: #185FA5; margin-bottom: 0.4rem; }
        .email-header h1 { font-size: 22px; font-weight: 600; color: #185FA5; margin-bottom: 0.25rem; }
        .email-header p { font-size: 13px; color: #378ADD; }

        .email-body { padding: 1.75rem 2rem; }
        .email-body p { font-size: 15px; color: #2C2C2A; line-height: 1.7; margin-bottom: 1rem; }

        .survey-box {
            background: #e8f2fc;
            border-left: 4px solid #378ADD;
            border-radius: 0 8px 8px 0;
            padding: 0.85rem 1.1rem;
            margin: 1.25rem 0;
        }
        .survey-box .label {
            font-size: 11px;
            color: #185FA5;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 4px;
        }
        .survey-box .titulo { font-size: 16px; font-weight: bold; color: #0C447C; }

        .btn-wrap { text-align: center; margin: 1.5rem 0 0.5rem; }
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
                <h1>¡Nueva encuesta disponible!</h1>
                <p>Innovación a tu alcance</p>
            </div>

            <div class="email-body">
                <p>Hola, tenemos una nueva encuesta activa en <strong style="color:#185FA5;">Sondar</strong> y nos gustaría conocer tu opinión.</p>

                <div class="survey-box">
                    <div class="label">Encuesta activa</div>
                    <div class="titulo">{{ $survey->titulo }}</div>
                </div>

                <p>Ya puedes ingresar al sistema y responderla. Solo toma unos minutos y tu participación es muy valiosa.</p>

                <div class="btn-wrap">
                    <a href="{{ route('login') }}" class="btn">
                        Responder encuesta →
                    </a>
                </div>
            </div>

            <div class="email-footer">
                <p>Gracias por participar &middot; <span style="color:#185FA5;">Sondar</span></p>
            </div>

        </div>
    </div>
</body>
</html>