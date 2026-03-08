@extends('layouts.front')

@section('content')
<section class="comentarios-section">
  <h2>Detalle de respuesta</h2>

  <div class="comentario-item">
    <strong>Encuesta:</strong> {{ $submission->survey->titulo }} <br>
    <strong>Usuario:</strong> {{ $submission->user->name }} ({{ $submission->user->email }}) <br>
    <strong>Fecha:</strong> {{ $submission->created_at }}
  </div>

  <h3 style="margin-top:18px;">Respuestas</h3>

  @foreach($submission->answers as $a)
    <div class="comentario-item">
      <strong>[{{ $a->question->tipo }}]</strong> {{ $a->question->contenido }}
      <p style="margin-top:8px;">{{ $a->contenido }}</p>
    </div>
  @endforeach

  <h3 style="margin-top:18px;">Informe IA</h3>

  @if($submission->aiReport)
    <div class="comentario-item">
      <strong>Sentimiento:</strong> {{ $submission->aiReport->sentiment }} <br>
      <strong>Severidad:</strong> {{ $submission->aiReport->severity }} <br>

      <strong>Resumen:</strong>
      <p>{{ $submission->aiReport->summary }}</p>

      <strong>Mejoras:</strong>
      <ul style="margin-top:8px; padding-left:18px;">
        @foreach(($submission->aiReport->improvements ?? []) as $imp)
          <li>{{ $imp }}</li>
        @endforeach
      </ul>
    </div>
  @else
    <p>Aun no se ha generado el informe IA</p>
  @endif

  <div style="margin-top:14px;">
    <a class="btn secondary" href="{{ route('ui.comentarios') }}">Volver</a>
  </div>
</section>
@endsection