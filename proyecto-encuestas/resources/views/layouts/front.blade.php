<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Sondar')</title>

  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  @stack('head')
</head>

<body>
  <div class="container">
    <header>
      <div class="barra_navegacion">Sondar</div>
      <nav>
    <ul>
      <li><a href="{{ route('home') }}">Inicio</a></li>
      <li><a href="{{ route('ui.servicios') }}">Servicios</a></li>
      <li><a href="{{ route('ui.productos') }}">Productos</a></li>

      @auth
        {{-- CLIENTE --}}
        @if(auth()->user()->role === 'cliente')
          <li><a href="{{ route('ui.comentarios') }}">Comentarios</a></li>
          <li><a href="{{ route('ui.contacto') }}">Contacto</a></li>
        @endif

        {{-- ADMIN --}}
        @if(auth()->user()->role === 'admin')
          <li><a href="{{ route('admin.surveys.create') }}">Crear encuesta</a></li>
          <li><a href="{{ route('admin.reports.index') }}">Informes</a></li>
          <li><a href="{{ route('ui.comentarios') }}">Respuestas</a></li>
        @endif

        {{-- PERFIL + LOGOUT --}}
        <li><a href="{{ route('profile.edit') }}">Ver perfil</a></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="link-button">Cerrar sesión</button>
          </form>
        </li>
      @else
        <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
        <li><a href="{{ route('register') }}">Registrarse</a></li>
      @endauth
    </ul>
  </nav>
    </header>

    <main>
      @if(session('success'))
  <div class="alert success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert error">{{ session('error') }}</div>
@endif

@if($errors->any())
  <div class="alert error">
    <ul style="margin:0; padding-left:18px;">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif
      @yield('content')
    </main>

    <footer>
      <p>
        &copy; 2025 Sondar. Todos los derechos reservados. |
        <a href="#">Política de Privacidad</a> |
        <a href="#">Términos de Servicio</a>
      </p>
    </footer>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>