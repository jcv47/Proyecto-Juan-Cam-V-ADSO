@extends('layouts.auth')

@section('title', 'Sondar - Iniciar Sesión')

@section('content')
  <section class="auth">
    <h2>Iniciar Sesión</h2>

    {{-- Mensaje de estado (por ejemplo: email de reset enviado) --}}
    @if (session('status'))
      <p class="alert success">{{ session('status') }}</p>
    @endif

    {{-- Errores --}}
    @if ($errors->any())
      <div class="alert error">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="loginForm" method="POST" action="{{ route('login') }}">
      @csrf

      <label for="email">Correo:</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus />

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required />

      <label class="remember">
        <input type="checkbox" name="remember">
        Recuérdame
      </label>

      <button type="submit" class="btn primary">Ingresar</button>
    </form>

    @if (Route::has('password.request'))
      <p style="margin-top: 10px;">
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
      </p>
    @endif

    <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
  </section>
@endsection