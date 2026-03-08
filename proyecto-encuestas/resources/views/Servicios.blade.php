@extends('layouts.front')

@section('title', 'Sondar - Servicios')

@section('content')
  <section class="features">
    <h2>Nuestros Servicios</h2>
    <div class="cards">
      <div class="card">
        <div class="icon">⚙️</div>
        <h3>Desarrollo Web</h3>
        <p>Construimos páginas modernas, seguras y optimizadas para potenciar tu presencia digital.</p>
      </div>
      <div class="card">
        <div class="icon">📊</div>
        <h3>Análisis de Datos</h3>
        <p>Transformamos tus datos en conocimiento útil para mejorar la toma de decisiones.</p>
      </div>
      <div class="card">
        <div class="icon">🤖</div>
        <h3>Soluciones con IA</h3>
        <p>Aplicamos inteligencia artificial para automatizar procesos y mejorar la experiencia de tus clientes.</p>
      </div>
    </div>
  </section>
@endsection