@extends('layouts.front')

@section('title', 'Sondar - Contacto')

@push('head')
  <script defer src="{{ asset('js/script.js') }}"></script>
@endpush

@section('content')
  <section class="contacto-section">
    <h2>Contáctanos</h2>
    <p class="contacto-text">
      ¿Tienes dudas o ideas? Escríbenos y te responderemos pronto.
    </p>

    <div class="cards" style="margin-bottom:24px;">
      <div class="card">
        <div class="icon">📧</div>
        <h3>Correo</h3>
        <p>soporte@sondar.co</p>
      </div>
      <div class="card">
        <div class="icon">📞</div>
        <h3>Teléfono</h3>
        <p>+57 300 000 0000</p>
      </div>
      <div class="card">
        <div class="icon">📍</div>
        <h3>Ubicación</h3>
        <p>Cali, Colombia</p>
      </div>
    </div>

    <form class="contacto-form" id="contactoForm">
      <label for="nombre">Nombre completo:</label>
      <input type="text" id="nombre" name="nombre" required>

      <label for="email">Correo electrónico:</label>
      <input type="email" id="email" name="email" required>

      <label for="asunto">Asunto:</label>
      <input type="text" id="asunto" name="asunto" required>

      <label for="mensaje">Mensaje:</label>
      <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

      <button type="submit" class="btn primary">Enviar mensaje</button>
    </form>

    <div class="map-container">
      <iframe
        title="Mapa Sondar"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d997363.377!2d-76.8!3d3.4!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e30a6a31f6b8b7b%3A0x6b8d2d1b9c!2sCali!5e0!3m2!1ses!2sco!4v0000000000"
        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </section>
@endsection

@push('scripts')
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const contactoForm = document.getElementById("contactoForm");
      if (!contactoForm) return;

      contactoForm.addEventListener("submit", (e) => {
        e.preventDefault();
        alert("✅ Tu mensaje ha sido enviado correctamente.");
        contactoForm.reset();
      });
    });
  </script>
@endpush