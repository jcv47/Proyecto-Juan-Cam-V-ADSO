@extends('layouts.front')

@section('content')
<section class="comentarios-section">
  <h2>{{ $survey->titulo }}</h2>
  <p>{{ $survey->descripcion }}</p>

  <form method="POST" action="{{ route('ui.surveys.submit', $survey) }}">
    @csrf

    @foreach($survey->questions as $q)
      <div style="margin-bottom:16px;">
        <label>{{ $q->contenido }}</label>
        <textarea name="answers[{{ $q->id }}]" required></textarea>

        @error("answers.$q->id")
          <div class="alert error">{{ $message }}</div>
        @enderror
      </div>
    @endforeach

    <button type="submit" class="btn primary">Enviar respuestas</button>
  </form>
</section>
@endsection