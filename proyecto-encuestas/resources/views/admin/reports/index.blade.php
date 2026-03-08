@extends('layouts.front')

@section('content')
<section class="comentarios-section" style="max-width: 1000px;">
  <h2>Informes</h2>

  {{-- Filtros --}}
  <form method="GET" action="{{ route('admin.reports.index') }}" style="margin: 14px 0;">
    <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
      <div style="flex:1 1 220px;">
        <label>Sentimiento</label>
        <select name="sentiment">
          <option value="">Todos</option>
          <option value="positivo" {{ ($sentiment ?? '') === 'positivo' ? 'selected' : '' }}>positivo</option>
          <option value="neutral"  {{ ($sentiment ?? '') === 'neutral'  ? 'selected' : '' }}>neutral</option>
          <option value="negativo" {{ ($sentiment ?? '') === 'negativo' ? 'selected' : '' }}>negativo</option>
        </select>
      </div>

      <div style="flex:1 1 220px;">
        <label>Severidad</label>
        <select name="severity">
          <option value="">Todos</option>
          <option value="bueno"   {{ ($severity ?? '') === 'bueno'   ? 'selected' : '' }}>bueno</option>
          <option value="regular" {{ ($severity ?? '') === 'regular' ? 'selected' : '' }}>regular</option>
          <option value="critico" {{ ($severity ?? '') === 'critico' ? 'selected' : '' }}>critico</option>
        </select>
      </div>

      <div style="flex:0 0 auto; display:flex; gap:10px;">
        <button class="btn primary" type="submit">Filtrar</button>
        <a class="btn secondary" href="{{ route('admin.reports.index') }}">Limpiar</a>
      </div>
    </div>
  </form>

  <hr style="margin: 18px 0;">

  {{-- Resultados --}}
  @if($reports->count() === 0)
    <p>No hay informes IA con esos filtros.</p>
  @else
    @foreach($reports as $r)
      @php
        $sub = $r->submission;
      @endphp

      <div class="comentario-item" style="margin-bottom: 14px;">
        <strong>Encuesta:</strong> {{ $sub?->survey?->titulo ?? '(sin encuesta)' }} <br>
        <strong>Usuario:</strong> {{ $sub?->user?->name ?? '(sin usuario)' }} ({{ $sub?->user?->email ?? '—' }}) <br>
        <strong>Fecha:</strong> {{ optional($sub)->created_at }} <br>
        <strong>Sentimiento:</strong> {{ $r->sentiment ?? '—' }} <br>
        <strong>Severidad:</strong> {{ $r->severity ?? '—' }} <br>

        <div style="margin-top:10px;">
          <strong>Resumen:</strong>
          <p style="margin:6px 0 0;">{{ $r->summary ?? '—' }}</p>
        </div>

        <div style="margin-top:10px;">
          <a class="btn secondary" href="{{ route('admin.submissions.show', $sub) }}">
            Ver detalle
          </a>
        </div>
      </div>
    @endforeach

    <div style="margin-top: 14px;">
      {{ $reports->links() }}
    </div>
  @endif
</section>
@endsection