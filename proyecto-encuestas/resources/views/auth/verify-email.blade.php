@extends('layouts.auth')

@section('title', 'Sondar - Verificar correo')

@section('content')
  <section class="auth">
    <h2>Verifica tu correo</h2>

    <p>
      Te enviamos un enlace de verificación al correo que registraste.
      Antes de continuar, revisa tu bandeja de entrada y confirma tu cuenta.
    </p>

    @if (session('status') == 'verification-link-sent')
      <p class="alert success">
        Se envió un nuevo enlace de verificación a tu correo.
      </p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
      @csrf
      <button type="submit" class="btn primary">Reenviar correo de verificación</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" style="margin-top: 10px;">
      @csrf
      <button type="submit" class="btn secondary">Cerrar sesión</button>
    </form>
  </section>
@endsection