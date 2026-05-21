@extends('layouts.auth')

@section('title', 'Sondar - Registro')

@section('content')
  <section class="auth">
    <h2>Registro de Usuario</h2>

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

    <form id="registerForm" method="POST" action="{{ route('register') }}">
      @csrf

      <label for="name">Nombre:</label>
      <input type="text" id="name" name="name" value="{{ old('name') }}" required />

      <label for="email">Correo:</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required />

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required />

      <label for="password_confirmation">Confirmar contraseña:</label>
      <input type="password" id="password_confirmation" name="password_confirmation" required />

      <label for="role">Tipo de cuenta:</label>

      <select id="role" name="role" required>
        <option value="cliente">Cliente</option>
        <option value="admin">Administrador</option>
      </select>

      <div id="adminCodeContainer" style="display:none; margin-top:20px;">
        <label for="admin_code">Código administrador:</label>

        <input type="password" id="admin_code" name="admin_code">
      </div>

      <script>
        document.addEventListener('DOMContentLoaded', () => {

          const roleSelect = document.getElementById('role');
          const adminContainer = document.getElementById('adminCodeContainer');

          roleSelect.addEventListener('change', () => {

            if (roleSelect.value === 'admin') {
              adminContainer.style.display = 'block';
            } else {
              adminContainer.style.display = 'none';
            }
          });

        });
      </script>


      <button type="submit" class="btn primary">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
  </section>
@endsection