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

  {{-- Botón hamburger (solo visible en móvil) --}}
  <button class="nav-toggle" id="navToggle" aria-label="Abrir menú" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>

  <nav id="mainNav">
    <ul>
      <li><a href="{{ route('home') }}">Inicio</a></li>
      <li><a href="{{ route('ui.servicios') }}">Servicios</a></li>
      <li><a href="{{ route('ui.productos') }}">Productos</a></li>

      @auth
        @if(auth()->user()->role === 'cliente')
          <li><a href="{{ route('ui.comentarios') }}">Comentarios</a></li>
          <li><a href="{{ route('ui.contacto') }}">Contacto</a></li>
        @endif

        @if(auth()->user()->role === 'admin')
          <li><a href="{{ route('admin.surveys.create') }}">Crear encuesta</a></li>
          <li><a href="{{ route('admin.reports.index') }}">Informes</a></li>
          <li><a href="{{ route('ui.comentarios') }}">Respuestas</a></li>
        @endif

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
  <script>
  const toggle = document.getElementById('navToggle');
  const nav    = document.getElementById('mainNav');

  toggle.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('open');
    toggle.classList.toggle('open', isOpen);
    toggle.setAttribute('aria-expanded', isOpen);
  });

  // Cierra el menú si el usuario hace click en un link
  nav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      nav.classList.remove('open');
      toggle.classList.remove('open');
      toggle.setAttribute('aria-expanded', false);
    });
  });
</script>
  @stack('scripts')
</body>
</html>