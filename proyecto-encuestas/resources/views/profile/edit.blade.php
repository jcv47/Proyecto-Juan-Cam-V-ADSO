@extends('layouts.front')

@section('content')
    <section class="comentarios-section" style="max-width: 850px;">
        <h2>Mi perfil</h2>

        @if (session('status') === 'profile-updated')
            <div class="alert success">
                Tu perfil fue actualizado correctamente.
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="alert success">
                Tu contraseña fue actualizada correctamente.
            </div>
        @endif

        @if (session('status') === 'account-deactivated')
            <div class="alert success">
                Tu cuenta fue desactivada correctamente.
            </div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- INFORMACIÓN PERSONAL --}}
        <div class="comentario-item" style="margin-bottom: 22px;">
            <h3>Información personal</h3>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <label for="name">Nombre</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>

                <label for="email">Correo</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>

                <label for="birthdate">Fecha de nacimiento</label>
                <input id="birthdate" name="birthdate" type="date"
                       value="{{ old('birthdate', optional($user->profile)->birthdate) }}">

                <label for="ubicacion_usuario">Ubicación</label>
                <input id="ubicacion_usuario" name="ubicacion_usuario" type="text"
                       value="{{ old('ubicacion_usuario', optional($user->profile)->ubicacion_usuario) }}"
                       placeholder="Ej: Cali, Colombia">

                <label for="role">Rol</label>
                <input id="role" type="text" value="{{ ucfirst($user->role) }}" disabled>

                <button type="submit" class="btn primary">Guardar cambios</button>
            </form>
        </div>

        {{-- SEGURIDAD --}}
        <div class="comentario-item" style="margin-bottom: 22px;">
            <h3>Seguridad</h3>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <label for="current_password">Contraseña actual</label>
                <input id="current_password" name="current_password" type="password" required>
                @error('current_password')
                    <div class="alert error" style="margin-top:8px;">{{ $message }}</div>
                @enderror

                <label for="password">Nueva contraseña</label>
                <input id="password" name="password" type="password" required>
                @error('password')
                    <div class="alert error" style="margin-top:8px;">{{ $message }}</div>
                @enderror

                <label for="password_confirmation">Confirmar nueva contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>

                <button type="submit" class="btn primary">Actualizar contraseña</button>
            </form>
        </div>

        {{-- CUENTA --}}
        <div class="comentario-item">
            <h3>Cuenta</h3>
            <p>Si desactivas tu cuenta, ya no podrás iniciar sesión hasta que un administrador la reactive.</p>

            <form method="POST" action="{{ route('profile.deactivate') }}">
                @csrf
                @method('PATCH')

                <label for="deactivate_password">Confirma tu contraseña</label>
                <input id="deactivate_password" name="password" type="password" required>

                <button type="submit" class="link-button-quit">Desactivar cuenta</button>
            </form>
        </div>
    </section>
@endsection