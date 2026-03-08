@extends('layouts.front')

@section('content')
  <div class="comentarios-section" style="max-width: 1100px;">
    <h2>Crear encuesta</h2>

    @if (session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.surveys.store') }}" id="surveyForm">
      @csrf

      <label for="titulo">Título</label>
      <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required>

      <label for="descripcion">Descripción</label>
      <textarea id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>

      <label for="estado">Estado</label>
      <select id="estado" name="estado" required>
        <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activa</option>
        <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactiva</option>
      </select>

      <hr style="margin: 20px 0;">

      <h3>Preguntas</h3>

      <div id="questionsWrap" style="max-width: 1070px"></div>

      <button type="button" class="btn secondary" id="addQuestionBtn">+ Agregar pregunta</button>

      <div style="margin-top: 18px;">
        <button type="submit" class="btn primary">Guardar encuesta</button>
      </div>
    </form>
  </div>

  <script>
    const wrap = document.getElementById('questionsWrap');
    const addBtn = document.getElementById('addQuestionBtn');

    let idx = 0;

    function questionRow({tipo = 'servicio', contenido = ''} = {}) {
      const row = document.createElement('div');
      row.className = 'card';
      row.style.width = '100%';
      row.style.marginBottom = '14px';

      row.innerHTML = `
        <div class="question-row" style="max-width: 1070px">

      <div class="question-col">
        <label>Tipo</label>
        <select name="questions[${idx}][tipo]" required>
          <option value="producto">Producto</option>
          <option value="servicio">Servicio</option>
          <option value="general">General</option>
        </select>
      </div>

      <div class="question-col question-col-wide" style="max-width: 98%;">
        <label>Contenido</label>
        <input type="text" name="questions[${idx}][contenido]" required />
      </div>

      <div class="question-col question-col-actions">
        <button type="button" class="link-button-quit removeBtn">Eliminar</button>
      </div>

    </div>
      `;

      row.querySelector('.removeBtn').addEventListener('click', () => {
        row.remove();
      });

      wrap.appendChild(row);
      idx++;
    }

    addBtn.addEventListener('click', () => questionRow());

    // arranca con 2 preguntas por defecto
    questionRow({tipo:'servicio', contenido:''});
    questionRow({tipo:'producto', contenido:''});
  </script>
@endsection