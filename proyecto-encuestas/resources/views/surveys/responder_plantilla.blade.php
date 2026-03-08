@extends('layouts.front')

@section('content')
<section class="comentarios-section">
  <h2>{{ $survey->titulo }}</h2>
  <p>{{ $survey->descripcion }}</p>

  {{-- Usuario logueado (solo UI, no se guarda) --}}
  <div class="comentario-item">
    <strong>Nombre:</strong> {{ auth()->user()->name }} <br>
    <strong>Correo:</strong> {{ auth()->user()->email }}
  </div>

  @php
    $qMotivo = $survey->questions->firstWhere('contenido', 'Motivo del comentario');
    $qSatis  = $survey->questions->firstWhere('contenido', 'Satisfacción general');
    $qCom    = $survey->questions->firstWhere('contenido', 'Comentarios');
    $qFunc   = $survey->questions->firstWhere('contenido', 'Solicitud de funcionalidad (opcional)');
  @endphp

  @if(!$qMotivo || !$qSatis || !$qCom || !$qFunc)
    <div class="alert error">
      La plantilla no está configurada correctamente (faltan preguntas). Revisa los textos exactos en la BD.
    </div>
  @else
    <form method="POST" action="{{ route('ui.surveys.submit', $survey) }}">
      @csrf

      {{-- Motivo --}}
      <div style="margin:16px 0;">
        <label><strong>{{ $qMotivo->contenido }}</strong></label>

        <label style="display:block; margin-bottom:8px;">
          <input type="radio" name="answers[{{ $qMotivo->id }}]" value="Producto" required>
          Reseña de Producto
        </label>

        <label style="display:block;">
          <input type="radio" name="answers[{{ $qMotivo->id }}]" value="Servicio" required>
          Reseña de Servicio al Cliente
        </label>

        @error("answers.$qMotivo->id")
          <div class="alert error">{{ $message }}</div>
        @enderror
      </div>

      {{-- Satisfacción --}}
      <div style="margin:16px 0;">
        <label><strong>{{ $qSatis->contenido }}</strong></label><br><br>

        <select name="answers[{{ $qSatis->id }}]" required style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc;">
          <option value="" selected disabled>Selecciona una opción</option>
          <option value="Bueno">Bueno</option>
          <option value="Regular">Regular</option>
          <option value="Malo">Malo</option>
        </select>

        @error("answers.$qSatis->id")
          <div class="alert error">{{ $message }}</div>
        @enderror
      </div>

      {{-- Comentarios --}}
      <div style="margin:16px 0;">
        <label><strong>{{ $qCom->contenido }}</strong></label>
        <textarea name="answers[{{ $qCom->id }}]" required style="width:100%; min-height:120px;"></textarea>

        @error("answers.$qCom->id")
          <div class="alert error">{{ $message }}</div>
        @enderror
      </div>

      {{-- Solicitud (opcional) --}}
      <div style="margin:16px 0;">
        <label><strong>{{ $qFunc->contenido }}</strong></label>
        <textarea name="answers[{{ $qFunc->id }}]" style="width:100%; min-height:120px;"></textarea>

        @error("answers.$qFunc->id")
          <div class="alert error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn primary">Enviar</button>
    </form>
  @endif

  <div style="margin-top:14px;">
    <a class="btn secondary" href="{{ route('ui.comentarios') }}">Volver</a>
  </div>
</section>
@endsection