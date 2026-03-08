@extends('layouts.front')

@section('content')

@if(session('success'))
  <div class="alert success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert error">{{ session('error') }}</div>
@endif

@if($mode === 'admin')
  <section class="comentarios-section">
    <h2>Respuestas de encuestas</h2>

    @if($submissions->count() === 0)
      <p>No hay respuestas todavía.</p>
    @else
      @foreach($submissions as $s)
        <div class="comentario-item">
          <strong>Encuesta:</strong> {{ $s->survey->titulo }} <br>
          <strong>Usuario:</strong> {{ $s->user->name }} ({{ $s->user->email }}) <br>
          <strong>Fecha:</strong> {{ $s->created_at }} <br>

          @if($s->aiReport)
            <strong>IA:</strong> {{ $s->aiReport->severity ?? 'sin severidad' }} / {{ $s->aiReport->sentiment ?? 'sin sentimiento' }}
          @else
            <strong>IA:</strong> (aún no generado)
          @endif

          <div style="margin-top:10px;">
            <a class="btn secondary" href="{{ route('admin.submissions.show', $s) }}">
              Ver detalle
            </a>
          </div>
        </div>
      @endforeach

      <div style="margin-top:15px;">
        {{ $submissions->links() }}
      </div>
    @endif
  </section>

@else
  <section class="comentarios-section">
  <h2>Reseña rápida</h2>

  @if($templateSurvey)
    <div class="comentario-item">
      <strong>{{ $templateSurvey->titulo }}</strong>
      <p>{{ $templateSurvey->descripcion }}</p>

      <a class="btn primary" href="{{ route('ui.surveys.show', $templateSurvey) }}">
        Responder reseña rápida
      </a>
    </div>
  @else
    <p>(No hay reseña rápida activa)</p>
  @endif

  <hr style="margin:20px 0;">

  <h2>Encuestas disponibles</h2>
  @if($availableSurveys->count() === 0)
    <p>No tienes encuestas normales pendientes</p>
  @else
    @foreach($availableSurveys as $survey)
      <div class="comentario-item">
        <strong>{{ $survey->titulo }}</strong>
        <p>{{ $survey->descripcion }}</p>

        <a class="btn primary" href="{{ route('ui.surveys.show', $survey) }}">
          Responder
        </a>
      </div>
    @endforeach
  @endif

  <hr style="margin:20px 0;">

  <h3>Mis reseñas rápidas</h3>
  @if($myTemplateSubmissions->count() === 0)
    <p>Aún no has enviado reseñas rápidas.</p>
  @else
    @foreach($myTemplateSubmissions as $s)
      <div class="comentario-item">
        <strong>{{ $s->survey->titulo }}</strong><br>
        <span>Enviada: {{ $s->created_at }}</span>
      </div>
    @endforeach
  @endif

  <hr style="margin:20px 0;">

  <h3>Mis encuestas normales</h3>
  @if($myNormalSubmissions->count() === 0)
    <p>Aún no has respondido encuestas normales.</p>
  @else
    @foreach($myNormalSubmissions as $s)
      <div class="comentario-item">
        <strong>{{ $s->survey->titulo }}</strong><br>
        <span>Respondida: {{ $s->created_at }}</span>
      </div>
    @endforeach
  @endif
</section>
@endif

@endsection