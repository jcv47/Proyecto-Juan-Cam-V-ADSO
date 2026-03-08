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
          <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Iniciar Sesión</a></li>
          <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Registrarse</a></li>
        </ul>
      </nav>
    </header>

    <main>
      @yield('content')
    </main>

    <footer>
      <p>&copy; 2025 Sondar. Todos los derechos reservados.</p>
    </footer>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>